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

                </div>
            </div>
        </div>
    </div>
</x-app-layout>