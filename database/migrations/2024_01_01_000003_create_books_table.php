<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->string('author');
            $table->string('publisher');
            $table->date('publish_date')->nullable();
            $table->string('isbn')->unique()->nullable();
            $table->integer('pages')->nullable();
            $table->string('language')->default('Indonesia');
            $table->decimal('width', 8, 2)->nullable();
            $table->decimal('height', 8, 2)->nullable();
            $table->decimal('weight', 8, 2)->nullable();
            $table->text('synopsis')->nullable();
            $table->string('cover')->nullable();
            $table->integer('stock')->default(1);
            $table->integer('borrowed_count')->default(0);
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('books'); }
};
