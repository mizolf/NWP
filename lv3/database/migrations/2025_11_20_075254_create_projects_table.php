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
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->foreignId('leader_id') // voditelj projekta
                ->constrained('users')
                ->cascadeOnDelete();

            $table->string('name');                 // naziv projekta
            $table->text('description')->nullable();// opis projekta
            $table->decimal('price', 10, 2);        // cijena projekta
            $table->text('tasks_done')->nullable(); // obavljeni poslovi
            $table->date('start_date');             // datum početka
            $table->date('end_date')->nullable();   // datum završetka
            $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
