<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Book Details
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <ul>
                        <li class="p-3">
                            <span class="font-semibold">Name</span>: {{ $book->name }}
                        </li>
                        <li class="p-3">
                            <span class="font-semibold">Description</span>: {{ $book->description }}
                        </li>
                        <li class="p-3">
                            <span class="font-semibold">Author</span>: {{ $book->author }}
                        </li>
                        @if(!is_null($book->return_date))
                            <li class="p-3">
                                <span class="font-semibold">Status</span>: Not Available
                            </li>

                            <li class="p-3">
                                <span class="font-semibold">Return Date</span>: {{ $book->return_date }}
                            </li>
                        @else
                            <li class="p-3">
                                <span class="font-semibold">Status</span>: Available
                            </li>
                        @endif
                    </ul>


                </div>
            </div>
        </div>
    </div>
</x-app-layout>
