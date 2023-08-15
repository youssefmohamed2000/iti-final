<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            All Books
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="text-right mb-6">
                        @can('create' ,\App\Models\Book::class)
                            <a href="{{ route('books.create') }}"
                               class="px-4 py-2 mr-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Add a book
                            </a>
                        @endcan

                        <a href="{{ route('books.borrow.create') }}"
                           class="px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            Borrow a book
                        </a>
                    </div>
                    <table class="w-full border bg-gray-100">
                        <thead>
                        <th class="p-2 border">Name</th>
                        <th class="p-2 border">Author</th>
                        <th class="p-2 border">Status</th>
                        <th class="p-2 border">Actions</th>
                        </thead>
                        <tbody>
                        @forelse($books as $book)
                            <tr>
                                <td class="p-4 text-center border">{{ $book->name }}</td>
                                <td class="p-4 text-center border">{{ $book->author }}</td>
                                <td class="p-4 text-center border">{{ $book->status }}</td>
                                <td class="p-4 text-center border">
                                    <a href="{{ route('books.show' , $book->id) }}"
                                       class="mr-2 px-2 py-1 bg-indigo-800 border border-transparent rounded-md text-xs text-white tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                        Details
                                    </a>
                                    @can('update' ,$book)
                                        <a href="{{ route('books.edit' , $book->id) }}"
                                           class="mr-2 px-2 py-1 bg-cyan-800 border border-transparent rounded-md text-xs text-white tracking-widest hover:bg-cyan-700 focus:bg-cyan-700 active:bg-cyan-900 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                            Edit
                                        </a>
                                    @endcan
                                    @can('delete' ,$book)
                                        <form action="{{ route('books.destroy' , $book->id) }}" method="post"
                                              class="inline-flex">
                                            @csrf
                                            @method('delete')
                                            <button type="submit"
                                                    class="mr-2 px-2 py-1 bg-red-800 border border-transparent rounded-md text-xs text-white tracking-widest hover:bg-red-700 focus:bg-red-700 active:bg-red-900 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                                Delete
                                            </button>
                                        </form>
                                    @endcan
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center p-4">There are no books!!!</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                    <div class="mt-6">
                        {{ $books->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
