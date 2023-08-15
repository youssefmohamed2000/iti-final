<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Borrow a book
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('books.borrow.confirm') }}" method="post">
                        @csrf
                        @method('put')
                        <div class="grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6 mb-4">
                            <div class="sm:col-span-3">
                                <x-input-label for="book_id" value="Select Book"/>
                                <select name="book_id" id="book_id" autocomplete="country-name"
                                        class=" block w-full mt-2 rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600  sm:text-sm sm:leading-6">
                                    <option value="">Choose a book</option>
                                    @foreach($books as $book)
                                        <option value="{{ $book->id }}"
                                            @selected(old('book_id') == $book->id)>
                                            {{ $book->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('book_id')" class="mt-2"/>
                            </div>

                            <div class="sm:col-span-3">
                                <x-input-label for="return_date" value="Return Date"/>
                                <x-text-input id="return_date" class="block mt-1 w-full" name="return_date"
                                              :value="old('return_date')" type="date"/>
                                <x-input-error :messages="$errors->get('return_date')" class="mt-2"/>
                            </div>
                        </div>

                        <div class="text-right">
                            <x-primary-button>Save</x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
