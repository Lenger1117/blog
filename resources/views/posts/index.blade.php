<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Блог') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Кнопка создания (видна всем авторизованным) -->
            <div class="mb-6 flex justify-end">
                <a href="{{ route('posts.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Написать статью
                </a>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    @forelse($posts as $post)
                        <article class="mb-8 border-b pb-8 last:border-b-0">
                            <h3 class="text-2xl font-bold mb-2">
                                <a href="{{ route('posts.show', $post->slug) }}" class="text-blue-600 hover:underline">
                                    {{ $post->title }}
                                </a>
                            </h3>
                            
                            <div class="text-sm text-gray-600 mb-4">
                                Автор: {{ $post->user->name }} | 
                                Категория: {{ $post->category->name }} | 
                                Дата: {{ $post->created_at->format('d.m.Y') }}
                            </div>

                            <!-- Если есть картинка, показываем её -->
                            @if($post->cover_image)
                                <img src="{{ asset('storage/' . $post->cover_image) }}" alt="{{ $post->title }}" class="w-full h-64 object-cover rounded mb-4">
                            @endif

                            <p class="text-gray-700 mb-4">
                                {{ Str::limit($post->body, 200) }} <!-- Показываем только первые 200 символов -->
                            </p>

                            <a href="{{ route('posts.show', $post->slug) }}" class="text-blue-500 hover:text-blue-700 font-semibold">
                                Читать далее &rarr;
                            </a>
                        </article>
                    @empty
                        <p>Статей пока нет. Будь первым!</p>
                    @endforelse

                    <!-- Ссылки пагинации -->
                    <div class="mt-4">
                        {{ $posts->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>