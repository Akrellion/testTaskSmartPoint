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
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->string('author', 100)->comment('Имя автора');
            $table->decimal('rating',3 ,1)->nullable()->comment('Рейтинг');
            $table->text('text_like')->nullable()->comment('Текст положительного отзыва');
            $table->text('text_dislike')->nullable()->comment('Текст отрицательного отзыва');
            $table->timestamp('date_publication')->comment('Дата отзыва');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
