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
        Schema::create('landing_programs', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('icon')->nullable()->comment('opsional: nama file/icon class atau url');
            $table->integer('position')->default(0)->index()->comment('urutan manual');
            $table->boolean('status')->default(true)->index()->comment('true = aktif, false = nonaktif tanpa hapus');
            $table->timestamps();
            $table->softDeletes(); // optional: enalble delete
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('landing_programs');
    }
};