<?php

namespace App\Console\Commands;

use App\User;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class RunTaskEveryWeekOnSunday extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'every:week';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'this command gives total charges during whole week';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $allEntries = DB::table('book_user')->get();

        foreach ($allEntries as $entry) {
            $current_charge = $entry->current_charge;
            $past_charges = $entry->past_charges;

            $sum = $current_charge + $past_charges;

            $entry->past_charge = $sum;

            DB::table('book_user')->where([
                ['user_id', '=', $entry->user_id],
                ['book_id', '=', $entry->book_id],
            ])->update([
                'past_charges' => $sum,
                'updated_at' => Carbon::now()
            ]);
        }

        $users = DB::table('book_user')->select('user_id')->distinct()->get()->toArray();

        foreach ($users as $key => $value) {

            $arrayed_value = json_decode(json_encode($value));
            $id = $arrayed_value->user_id;

            $books = DB::table('book_user')->where([
                ['user_id', '=', $id],
            ])->get()->toArray();

            $books = json_decode(json_encode($books));
            // dd($books);

            $sum = 0;

            foreach ($books as $book) {
                $book = json_decode(json_encode($book), true);

                // dd($book);
                $charge = $book['past_charges'];
                $sum = $sum + $charge;
            }

            User::find($id)->update([
                'account' => $sum,
            ]);
        }
    }
}
