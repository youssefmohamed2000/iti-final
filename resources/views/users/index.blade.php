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
                    <div class="mb-6 text-right">
                        <form action="">
                            <x-text-input placeholder="Search users by id" name="user_id"/>
                            <x-primary-button>Search</x-primary-button>
                        </form>
                    </div>
                    <table class="w-full border bg-gray-100">
                        <thead>
                        <th class="p-2 border">Id</th>
                        <th class="p-2 border">Name</th>
                        <th class="p-2 border">Email</th>
                        </thead>
                        <tbody>
                        @forelse($users as $user)
                            <tr>
                                <td class="p-4 text-center border">{{ $user->id }}</td>
                                <td class="p-4 text-center border">{{ $user->name }}</td>
                                <td class="p-4 text-center border">{{ $user->email }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center p-4">There are no users!!!</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                    <div class="mt-6">
                        {{ $users->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
