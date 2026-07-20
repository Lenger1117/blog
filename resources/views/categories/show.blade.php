<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Категория: ') }} {{ $category->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
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
                                Автор: {{ $post->user->name }} | Дата: {{ $post->created_at->format('d.m.Y') }}
                            </div>
                            <p class="text-gray-700 mb-4">{{ Str::limit($post->body, 200) }}</p>
                            <a href="{{ route('posts.show', $post->slug) }}" class="text-blue-500 hover:text-blue-700 font-semibold">Читать далее &rarr;</a>
                        </article>
                    @empty
                        <p>В этой категории пока нет статей.</p>
                    @endforelse

                    <div class="mt-4">
                        {{ $posts->links() }}
                    </div>
                    
                    <div class="mt-6">
                        <a href="{{ route('posts.index') }}" class="text-gray-500 hover:underline">&larr; Все статьи</a>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>