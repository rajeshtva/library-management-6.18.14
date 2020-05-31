<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class RunTaskEveryMinute extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'every:minute';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command calculates past charges for each book subscribed by the user every minute';

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

        foreach($allEntries as $entry){
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

        // $allEntries = DB::table('book_user')->get();

    }
}
