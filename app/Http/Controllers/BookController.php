<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\BookStoreRequest;
use App\Http\Requests\BorrowBookRequest;
use App\Models\Book;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class BookController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin')
            ->only('create', 'store', 'edit', 'update', 'destroy');
    }

    public function index(): View
    {
        $books = Book::query()->paginate(5);

        return view('books.index', compact('books'));
    }

    public function create(): View
    {
        $this->authorize('create', Book::class);

        return \view('books.create');
    }

    public function store(BookStoreRequest $request): RedirectResponse
    {
        $this->authorize('create', Book::class);

        Book::query()->create($request->validated());

        return redirect()->route('books.index');
    }

    public function show(Book $book): View
    {
        return view('books.show', compact('book'));
    }

    public function edit(Book $book): View
    {
        $this->authorize('update', $book);

        return \view('books.edit', compact('book'));
    }

    public function update(
        BookStoreRequest $request,
        Book $book
    ): RedirectResponse {
        $this->authorize('update', $book);

        $book->update($request->validated());

        return redirect()->route('books.index');
    }

    public function destroy(Book $book): RedirectResponse
    {
        $this->authorize('delete', $book);

        $book->delete();

        return redirect()->route('books.index');
    }

    public function borrow(): View
    {
        $books = Book::query()
            ->where('user_id', '=', null)
            ->where('return_date', '=', null)
            ->select('id', 'name')
            ->get();

        return view('books.borrow.create', compact('books'));
    }

    public function borrowConfirm(BorrowBookRequest $request): RedirectResponse
    {
        Book::query()
            ->findOrFail($request->validated('book_id'))
            ->update([
                'user_id' => $request->user()->id,
                'return_date' => $request->validated('return_date'),
            ]);

        return redirect()->route('books.index');
    }

    public function borrowed(): View
    {
        $books = Book::query()
            ->whereNot('user_id', '=', null)
            ->whereNot('return_date', '=', null)
            ->paginate(5);

        return view('books.borrow.index', compact('books'));
    }

    public function returnToShelf(Book $book): RedirectResponse
    {
        if ($book->user_id !== auth()->user()->id) {
            abort(403);
        }

        $book->update([
            'user_id' => null,
            'return_date' => null,
        ]);

        return redirect()->route('dashboard');
    }
}
