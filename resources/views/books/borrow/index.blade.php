<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Borrowed Books
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="text-right mb-6">
                    </div>
                    <table class="w-full border bg-gray-100">
                        <thead>
                        <th class="p-2 border">Name</th>
                        <th class="p-2 border">Author</th>
                        <th class="p-2 border">Return Date</th>
                        </thead>
                        <tbody>
                        @forelse($books as $book)
                            <tr>
                                <td class="p-4 text-center border">{{ $book->name }}</td>
                                <td class="p-4 text-center border">{{ $book->author }}</td>
                                <td class="p-4 text-center border">{{ $book->return_date}}</td>

                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center p-4">There are no books!!!</td>
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
