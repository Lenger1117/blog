<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Админ-панель') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <!-- Пользователи -->
            <div class="bg-white p-6 rounded shadow">
                <h3 class="text-lg font-bold mb-4">Пользователи</h3>
                <table class="min-w-full">
                    <thead>
                        <tr class="border-b">
                            <th class="text-left py-2">ID</th>
                            <th class="text-left py-2">Имя</th>
                            <th class="text-left py-2">Email</th>
                            <th class="text-left py-2">Действия</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                            <tr class="border-b">
                                <td class="py-2">{{ $user->id }}</td>
                                <td class="py-2">{{ $user->name }}</td>
                                <td class="py-2">{{ $user->email }}</td>
                                <td class="py-2">
                                    @if(auth()->id() !== $user->id)
                                        <form action="{{ route('admin.banUser', $user) }}" method="POST" onsubmit="return confirm('Удалить пользователя?')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="text-red-500 hover:underline">Удалить</button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="mt-4">{{ $users->links() }}</div>
            </div>

            <!-- Сюда можно добавить таблицы для Постов и Комментариев аналогично -->

        </div>
    </div>
</x-app-layout>