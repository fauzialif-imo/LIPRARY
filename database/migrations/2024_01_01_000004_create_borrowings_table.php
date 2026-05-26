<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('borrowings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('book_id')->constrained()->onDelete('cascade');
            $table->date('borrow_date');
            $table->date('return_date');
            $table->date('actual_return_date')->nullable();
            $table->enum('condition', ['normal', 'rusak_ringan', 'rusak_berat'])->default('normal');
            $table->enum('status', ['pending','approved','rejected','returning','returned'])->default('pending');
            $table->decimal('fine_amount', 10, 2)->default(0);
            $table->text('admin_note')->nullable();
            $table->text('user_note')->nullable();
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('borrowings'); }
};
