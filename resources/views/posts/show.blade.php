<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $post->title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <div class="mb-4 text-sm text-gray-600">
                        Автор: <span class="font-bold">{{ $post->user->name }}</span> |
                        Категория: {{ $post->category->name }} |
                        Опубликовано: {{ $post->created_at->format('d.m.Y H:i') }}
                    </div>

                    @if($post->cover_image)
                    <img src="{{ asset('storage/' . $post->cover_image) }}" alt="{{ $post->title }}" class="w-full h-auto max-h-96 object-cover rounded mb-6">
                    @endif

                    <div class="prose max-w-none text-gray-800">
                        {!! nl2br(e($post->body)) !!} <!-- Выводим текст, сохраняя переносы строк -->
                    </div>

                    <div class="mt-8 pt-4 border-t">
                        <a href="{{ route('posts.index') }}" class="text-blue-500 hover:underline">&larr; Назад к списку</a>
                    </div>

                    @can('update', $post)
                    <div class="mt-8 flex gap-4">
                        <a href="{{ route('posts.edit', $post->slug) }}" class="bg-yellow-500 text-black px-4 py-2 rounded">Редактировать</a>

                        <form action="{{ route('posts.destroy', $post->slug) }}" method="POST" onsubmit="return confirm('Удалить?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-500 text-black px-4 py-2 rounded">Удалить</button>
                        </form>
                    </div>
                    @endcan

                </div>
            </div>
        </div>
    </div>

    <!-- Секция комментариев -->
    <div class="mt-10 pt-6 border-t">
        <h3 class="text-xl font-bold mb-4">Комментарии ({{ $post->comments->count() }})</h3>

        <!-- Форма добавления (только для авторизованных) -->
        @auth
        <form action="{{ route('comments.store', $post) }}" method="POST" class="mb-8">
            @csrf
            <div class="mb-4">
                <textarea name="body" rows="3" class="w-full border-gray-300 rounded-md shadow-sm" placeholder="Напишите ваш комментарий..." required></textarea>
                @error('body')
                <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <button type="submit" class="bg-green-500 hover:bg-green-700 text-black font-bold py-2 px-4 rounded">
                Отправить
            </button>
        </form>
        @else
        <p class="mb-4 text-gray-500"><a href="{{ route('login') }}" class="text-blue-500">Войдите</a>, чтобы оставить комментарий.</p>
        @endauth

        <!-- Список комментариев -->
        <div class="space-y-6">
            @forelse($post->comments as $comment)
            <div class="bg-gray-50 p-4 rounded-lg">
                <div class="flex justify-between items-start">
                    <div class="font-semibold text-gray-800">
                        {{ $comment->user->name }}
                    </div>
                    <div class="text-xs text-gray-500">
                        {{ $comment->created_at->diffForHumans() }}

                        <!-- Кнопка удаления (если это комментарий пользователя) -->
                        @if(Auth::id() === $comment->user_id)
                        <form action="{{ route('comments.destroy', $comment) }}" method="POST" class="inline ml-2">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500 hover:text-red-700 text-xs" onclick="return confirm('Удалить комментарий?')">
                                Удалить
                            </button>
                        </form>
                        @endif
                    </div>
                </div>
                <p class="mt-2 text-gray-700 whitespace-pre-line">{{ $comment->body }}</p>
            </div>
            @empty
            <p class="text-gray-500 italic">Пока нет комментариев. Будьте первым!</p>
            @endforelse
        </div>
    </div>

</x-app-layout>