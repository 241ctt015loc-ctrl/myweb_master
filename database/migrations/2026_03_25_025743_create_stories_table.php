<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   
    public function up(): void
    {
       Schema::create('stories', function (Blueprint $table) {
    $table->id();
    $table->string('title');
    $table->string('slug')->unique();
    $table->decimal('price', 10, 2)->default(0);
    $table->foreignId('category_id')->constrained('categories')->onDelete('cascade');
    $table->text('summary')->nullable();
    $table->string('cover_image')->nullable();
    $table->timestamps();
});
    }

    public function down(): void
    {
        Schema::dropIfExists('stories');
    }
};
