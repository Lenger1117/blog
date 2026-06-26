<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Кто автор? Ссылка на таблицу users
            $table->foreignId('category_id')->constrained()->onDelete('set null'); // Категория. Если удалят категорию, у поста станет null
            $table->string('title');
            $table->string('slug')->unique(); // Для красивых ссылок
            $table->text('body'); // Текст статьи
            $table->string('cover_image')->nullable(); // Путь к картинке (может не быть)
            $table->boolean('is_published')->default(false); // Чтобы можно было сохранять черновики
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
