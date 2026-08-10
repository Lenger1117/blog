<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Редактирование статьи') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    @if ($errors->any())
                        <div class="mb-4 text-red-600">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- метод PUT и маршрут update -->
                    <form method="POST" action="{{ route('posts.update', $post->slug) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT') <!-- Симуляция метода PUT -->

                        <div class="mb-4">
                            <label for="title" class="block text-sm font-medium text-gray-700">Заголовок</label>
                            <input type="text" name="title" id="title" value="{{ old('title', $post->title) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                        </div>

                        <div class="mb-4">
                            <label for="category_id" class="block text-sm font-medium text-gray-700">Категория</label>
                            <select name="category_id" id="category_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ $post->category_id == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-4">
                            <label for="body" class="block text-sm font-medium text-gray-700">Текст статьи</label>
                            <textarea name="body" id="body" rows="10" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>{{ old('body', $post->body) }}</textarea>
                        </div>

                        <div class="mb-4">
                            <label for="cover_image" class="block text-sm font-medium text-gray-700">Новая обложка (необязательно)</label>
                            <input type="file" name="cover_image" id="cover_image" class="mt-1 block w-full text-sm text-gray-500">
                            @if($post->cover_image)
                                <p class="text-sm text-gray-500 mt-2">Текущая: {{ $post->cover_image }}</p>
                            @endif
                        </div>

                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Сохранить изменения
                        </button>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>