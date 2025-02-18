<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('family_members', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->date('birth_date');
            $table->enum('gender', ['Laki-Laki', 'Perempuan']);
            $table->string('address')->nullable();
            $table->unsignedBigInteger('tree_id');
            $table->unsignedBigInteger('parent_id')->nullable(); // Tambahkan parent_id
            $table->timestamps();

            $table->string('photo')->nullable();

            $table->foreign('tree_id')->references('id')->on('trees')->onDelete('cascade');
            $table->foreign('parent_id')->references('id')->on('family_members')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('family_members');
    }
};

