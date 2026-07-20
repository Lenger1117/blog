<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Все категории') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        @foreach($categories as $category)
                            <a href="{{ route('categories.show', $category->slug) }}" class="block p-4 border rounded hover:bg-gray-50 transition">
                                <h3 class="font-bold text-lg">{{ $category->name }}</h3>
                                <p class="text-sm text-gray-500">Статей: {{ $category->posts_count }}</p>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>