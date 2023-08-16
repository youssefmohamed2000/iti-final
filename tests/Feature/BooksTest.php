<?php

namespace Tests\Feature;

use App\Models\Book;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BooksTest extends TestCase
{
    use RefreshDatabase;
    private User $user;
    private User $admin;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = $this->createUser();
        $this->admin = $this->createUser(isAdmin: true);
    }

    public function test_books_page_contains_empty_table(): void
    {
        $response = $this->actingAs($this->user)->get('books');

        $response->assertStatus(200);
        $response->assertSee('There are no books');
    }

    public function test_books_page_contains_non_empty_table(): void
    {
        $book = Book::factory()->create();

        $response = $this->actingAs($this->user)->get('books');

        $response->assertStatus(200);
        $response->assertDontSee('There are no books');
        $response->assertViewHas('books', function ($collection) use ($book) {
            return $collection->contains($book);
        });
    }

    public function test_paginated_books_table_doesnt_contain_6th_record(): void
    {
        $books = Book::factory(6)->create();
        $lastBook = $books->last();

        $response = $this->actingAs($this->user)->get('books');

        $response->assertStatus(200);
        $response->assertViewHas('books', function ($collection) use ($lastBook) {
            return !$collection->contains($lastBook);
        });
    }

    public function test_admin_can_see_add_book_button(): void
    {
        $response = $this->actingAs($this->admin)->get('books');

        $response->assertStatus(200);
        $response->assertSee('Add a book');
    }

    public function test_user_cannot_see_add_book_button(): void
    {
        $response = $this->actingAs($this->user)->get('books');

        $response->assertStatus(200);
        $response->assertDontSee('Add a book');
    }

    public function test_admin_can_access_books_create_page(): void
    {
        $response = $this->actingAs($this->admin)->get('books/create');

        $response->assertStatus(200);
    }

    public function test_user_cannot_access_books_create_page(): void
    {
        $response = $this->actingAs($this->user)->get('books/create');

        $response->assertStatus(403);
    }

    public function test_user_cannot_create_book(): void
    {
        $response = $this->actingAs($this->user)->post('books', [
            'name' => 'name',
            'description' => 'desc',
            'author' => 'author'
        ]);

        $response->assertStatus(403);
    }

    public function test_admin_create_book_successful(): void
    {
        $data = [
            'name' => 'name',
            'description' => 'desc',
            'author' => 'author'
        ];

        $response = $this->actingAs($this->admin)->post('books', $data);

        $response->assertStatus(302);
        $response->assertRedirect('books');

        $this->assertDatabaseHas('books', $data);

        $lastBook = Book::query()->latest()->first();

        $this->assertEquals($data['name'], $lastBook->name);
        $this->assertEquals($data['description'], $lastBook->description);
        $this->assertEquals($data['author'], $lastBook->author);
    }

    public function test_admin_can_access_books_edit_page(): void
    {
        $book = Book::factory()->create();

        $response = $this->actingAs($this->admin)->get("books/{$book->id}/edit");

        $response->assertStatus(200);
    }

    public function test_user_cannot_access_books_edit_page(): void
    {
        $book = Book::factory()->create();

        $response = $this->actingAs($this->user)->get("books/{$book->id}/edit");

        $response->assertStatus(403);
    }

    public function test_book_edit_contains_correct_values(): void
    {
        $book = Book::factory()->create();

        $response = $this->actingAs($this->admin)->get("books/{$book->id}/edit");

        $response->assertSee('value="' . $book->name . '"', false);
        $response->assertSee($book->description, false);
        $response->assertSee('value="' . $book->author . '"', false);
        $response->assertViewHas('book', $book);
    }

    public function test_book_update_validation_redirect_back_to_form(): void
    {
        $book = Book::factory()->create();

        $response = $this->actingAs($this->admin)->put("books/{$book->id}", [
            'name' => '',
            'description' => '',
            'author' => ''
        ]);

        $response->assertStatus(302);
        $response->assertSessionHasErrors(['name', 'description', 'author']);
    }

    public function test_book_update_successful(): void
    {
        $book = Book::factory()->create();
        $data = [
            'name' => 'name test',
            'description' => 'description test',
            'author' => 'author test'
        ];

        $response = $this->actingAs($this->admin)->put("books/{$book->id}", $data);

        $response->assertStatus(302);
        $response->assertRedirect('books');

        $this->assertDatabaseHas('books', $data);
    }

    public function test_book_delete_successful(): void
    {

        $book = Book::factory()->create();

        $response = $this->actingAs($this->admin)->delete("books/{$book->id}");

        $response->assertStatus(302);
        $response->assertRedirect('books');

        $this->assertDatabaseMissing('books', $book->toArray());
        $this->assertDatabaseCount('books', 0);
    }

    public function test_borrow_book_validation_redirect_back_to_form(): void
    {
        $book = Book::factory()->create();
        $data = [
            'book_id' => '',
            'user_id' => $this->user->id,
            'return_date' => '2019-07-12'
        ];

        $response = $this->actingAs($this->user)->put('books/borrow', $data);

        $response->assertStatus(302);
        $response->assertSessionHasErrors(['return_date']);
    }

    public function test_user_can_borrow_book_successful(): void
    {
        $book = Book::factory()->create();
        $data = [
            'book_id' => $book->id,
            'user_id' => $this->user->id,
            'return_date' => Carbon::now()->addMonth()->format('Y-m-d')
        ];

        $response = $this->actingAs($this->user)->put('books/borrow', $data);

        $response->assertStatus(302);
        $response->assertRedirect('books');

        $this->assertDatabaseHas('books', [
            'user_id' => $this->user->id,
            'return_date' => Carbon::now()->addMonth()->format('Y-m-d')
        ]);
    }

    private function createUser(bool $isAdmin = false): User
    {
        return User::factory()->create([
            'is_admin' => $isAdmin
        ]);
    }
}
