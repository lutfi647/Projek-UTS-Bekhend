<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Menjalankan migration untuk membuat tabel 'news'.
     */
    public function up(): void
    {
        Schema::create('news', function (Blueprint $table) {
            // Menambahkan kolom id sebagai primary key
            $table->id();
            // Kolom untuk judul berita
            $table->string('title');
            // Kolom untuk penulis berita
            $table->string('author');
            // Kolom untuk deskripsi singkat berita
            $table->string('description');
            // Kolom untuk konten berita
            $table->text('content');
            // Kolom untuk URL berita
            $table->string('url');
            // Kolom untuk URL gambar berita
            $table->string('url_image');
            // Kolom untuk tanggal dan waktu diterbitkannya berita
            $table->dateTime('published_at');
            // Kolom untuk kategori berita
            $table->string('category');
            // Kolom untuk menyimpan tanggal pembuatan dan pembaruan data
            $table->timestamps();
        });
    }

    /**
     * Membalikkan perubahan yang dilakukan pada migration (drop tabel 'news').
     */
    public function down(): void
    {
        Schema::dropIfExists('news');
    }
};
