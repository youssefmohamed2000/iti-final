<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Book
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('books.update' , $book->id) }}" method="post">
                        @csrf
                        @method('put')
                        {{-- name--}}
                        <div class="">
                            <x-input-label for="name" value="Name"/>
                            <x-text-input id="name" name="name" class="block mt-1 w-full"
                                          :value="old('name', $book->name)"/>
                            <x-input-error :messages="$errors->get('name')" class="mt-2"/>
                        </div>

                        {{-- author--}}
                        <div class="mt-4">
                            <x-input-label for="description" value="Description"/>
                            <textarea name="description" id="description"
                                      class="block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                {{ old('description' , $book->description) }}
                            </textarea>
                            <x-input-error :messages="$errors->get('description')" class="mt-2"/>
                        </div>

                        {{-- author --}}
                        <div class="mt-4">
                            <x-input-label for="author" value="Author"/>
                            <x-text-input id="author" name="author" class="block mt-1 w-full"
                                          :value="old('author' , $book->author)"/>

                            <x-input-error :messages="$errors->get('author')" class="mt-2"/>
                        </div>

                        <div class="text-right mt-4">
                            <x-primary-button>Update</x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
