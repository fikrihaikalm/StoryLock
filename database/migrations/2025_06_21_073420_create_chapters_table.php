<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('chapters', function (Blueprint $table) {
            $table->id();
            $table->foreignId('story_id')->constrained()->onDelete('cascade');
            $table->string('judul');
            $table->string('slug');
            $table->longText('isi');
            $table->string('gambar_pendukung')->nullable();
            $table->timestamps();
            $table->unique(['story_id', 'slug']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('chapters');
    }
};