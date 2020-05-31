<?php

namespace Tests\Feature;

use App\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class CartFeatureTest extends TestCase
{
    use RefreshDatabase;


    /** @test */
    public function a_student_can_add_a_book_to_the_cart()
    {
        $this->storeBooks();

        $randIndex = 4;
        $this->actingAs($this->student)->post('/carts/store', ['book_id' => $randIndex])->assertStatus(302)->assertRedirect('/home');

        $cart = session()->get('cart');
        $this->assertContains($randIndex, $cart, 'not found');
    }

    /** @test */
    public function a_student_can_delete_a_book_from_cart()
    {
        $this->withoutExceptionHandling();
        $this->storeBooks();
        $this->assertCount(20, Book::all());
        $deleteItems = array(4, 1, 8, 7, 12);
        foreach ($deleteItems as $item) {
            $this->actingAs($this->student)->post('/carts/store', ['book_id' => $item])->assertStatus(302)->assertRedirect('/home');
        }

        // $this->assertContains(4, $cart, 'not found');
        $randIndex = 4;

        $this->actingAs($this->student)->delete('/carts/delete', ['book_id' => $randIndex]);
        $cart = session()->get('cart');
        $this->assertFalse(in_array($randIndex, $cart));
    }

    /** @test */
    public function a_student_can_checkout_all_books()
    {

        $this->storeBooks();
        $cartArray = array(4, 2, 1, 12, 13, 8);
        session()->put('cart', $cartArray);

        $this->assertDatabaseMissing('book_user', ['user_id' => $this->student->id]);
        $this->actingAs($this->student)->post('/checkout')->assertStatus(302);
        $this->assertDatabaseHas('book_user', ['user_id' => $this->student->id]);

        $db_count = DB::table('book_user')->count();
        // dump(DB::table('book_user')->get());

        $this->assertEquals($db_count, count(array_unique($cartArray)));
    }

    /** @test */
    public function past_charges_get_added()
    {
        $this->withoutExceptionHandling();
        $this->a_student_can_checkout_all_books();
        $cartArray = array(4, 13, 9, 15, 16, 4);
        $totalArray = array(1, 2, 4, 12, 13, 15, 8, 9, 16);

        session()->put('cart', $cartArray);
        $user = auth()->user();

        $this->actingAs($this->student)->post('/checkout')->assertStatus(302);
        $book = $user->hasRented->find(4)->pivot;
        $this->assertEquals($book->past_charges, 2 * $book->current_charge);
        $book = $user->hasRented->find(13)->pivot;
        $this->assertEquals($book->past_charges, $book->current_charge);
        $this->assertDatabaseHas('book_user', ['user_id' => $this->student->id]);
        $db_count = DB::table('book_user')->count();
        // dump(DB::table('book_user')->get()); //this was error where because
        $this->assertEquals($db_count, count($totalArray));
    }

    /** @test */
    public function a_student_can_see_his_cart_page()
    {
        $this->actingAs($this->student)->get('/carts')->assertStatus(200);
    }

    /** @test */
    public function an_item_from_store_can_be_soft_deleted()
    {
        $this->withoutExceptionHandling();
        $this->storeBooks();
        $cart = [5, 8, 3, 1, 2, 9, 10];
        session()->put('cart', $cart);
        $this->actingAs($this->student)->post('/checkout')->assertStatus(302)->assertRedirect('/home');
        $db_count = DB::table('book_user')->count();
        $this->assertEquals($db_count, count($cart));
        // $user = $this->student;
        // dump($this->student->id);
        // dump($user->getRoleNames());

        foreach ($cart as $item) {
            $this->assertDatabaseHas('book_user', [
                ['book_id', '=', (string) $item],
                ['user_id', '=',  (string) $this->student->id],
            ]);
        }

        // dump(Book::all());
        $deletedCart = [8, 1, 5, 10];
        // $id = $this->student->id;
        foreach ($deletedCart as $item) {
            $url = '/' . $this->student->id . '/softdelete/' . $item;
            $this->delete($url)->assertStatus(200);
        }

        // dump(DB::table('book_user')->get());

        $allItems = DB::table('book_user')->where([
            ['user_id', '=', $this->student->id],
        ])->get();
        // dump($allItems);


        $this->assertEquals(count($allItems), 7);

        $deleted = 0;
        $subscribed = 0;
        foreach ($allItems as $item) {
            if ($item->deleted_at != null) {
                $deleted++;
            } else {
                $subscribed++;
            }
        }

        $this->assertEquals($deleted, 4);
        $this->assertEquals($subscribed, 3);
    }



    protected function storeBooks()
    {
        for ($i = 0; $i < 20; $i++) {
            $data = [
                'book_name' => $this->faker->realText($maxNbChars = 30, $indexSize = 4),
                'author_name' => $this->faker->name,
                'description' => $this->faker->paragraph($nbSentence = 10, $variableNbSentence = true),
                'price' => $this->faker->randomFloat(3, 0, 1000)
            ];

            $this->actingAs($this->admin)->post(route('books.store'), $data);
        }
    }
}
