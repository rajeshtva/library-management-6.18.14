<?php
namespace std;

use App\Book;
use App\User;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookFeatureTest extends TestCase
{
	use RefreshDatabase;

	/** @test */
	public function a_index_page_can_be_accessed()
	{
		$this->withoutExceptionHandling();
		factory(Book::class, 20);
		$this->actingAs($this->admin, 'web')->get(route('books.index'))->assertStatus(200);
	}

	/** @test */
	public function anAdminCanEditBookDetail()
	{
		$this->withoutExceptionHandling();
		
		$user = factory(User::class)->create();
		$user->assignRole('Admin');
		$book = factory(Book::class)->create(['user_id' => $user->id]);

		$this->actingAs($this->admin)->get(route('books.edit', $book->id))->assertStatus(200);
	
	}

	/** @test */
	public function anAdminCanVisitCreatePage($value='')
	{
		$this->actingAs($this->admin)->get(route('books.create'))->assertStatus(200);
	}

	/** @test */
	public function anAdminCanUpdateBook()
	{
		$this->withoutExceptionHandling();
		$user = factory(User::class)->create();
		$user->assignRole('Admin');

		$book = factory(Book::class)->create(['user_id' => $user->id ]);
		$data = [
			'book_name' => $this->faker->word,
			'author_name' => $this->faker->name,
		];


		$data = array_merge([
			'book_name' => $book->book_name,
			'author_name' => $book->author_name, 
			'price' => $book->price,
			'description' => $book->description,
		], $data);
		$this->actingAs($user)->put(route('books.update', $book->id), $data)->assertStatus(302)->assertRedirect(route('books.edit', $book->id));
	}

	/** @test */
	public function aStudentCanNotStorebook()
	{
		// $this->withoutExceptionHandling();
		$data = [
			'book_name' => $this->faker->realText($maxNbChars = 30, $indexSize= 4),
			'author_name' => $this->faker->name,
			'description' => $this->faker->paragraph($nbSentence = 10, $variableNbSentence = true),
			'price' => $this->faker->randomFloat(3, 0, 1000)
		];

		$this->actingAs($this->student)->post(route('books.store'), $data)->assertStatus(401);
	}
	/** @test */
	public function anAdminCanStorebook()
	{
		// $this->withoutExceptionHandling();
		$data = [
			'book_name' => $this->faker->realText($maxNbChars = 30, $indexSize= 4),
			'author_name' => $this->faker->name,
			'description' => $this->faker->paragraph($nbSentence = 10, $variableNbSentence = true),
			'price' => $this->faker->randomFloat(3, 0, 1000)
		];

		$this->actingAs($this->admin)->post(route('books.store'), $data)->assertStatus(302);
	}

	/** @test */
	public function a_student_sees_book_on_his_home_page()
	{
		for ($i=0; $i < 10; $i++) { 
			$data = [
				'book_name' => $this->faker->realText($maxNbChars = 30, $indexSize= 4),
				'author_name' => $this->faker->name,
				'description' => $this->faker->paragraph($nbSentence = 10, $variableNbSentence = true),
				'price' => $this->faker->randomFloat(3, 0, 1000)
			];

			$this->actingAs($this->admin)->post(route('books.store'), $data);		
		}

		$books = Book::all();
		$this->actingAs($this->student)->get('/home')->assertStatus(200)->assertSee(htmlentities($books, ENT_QUOTES));
	}

	

}