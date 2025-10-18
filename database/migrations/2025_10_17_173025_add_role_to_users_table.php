<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migrasi untuk menambahkan kolom 'role' ke tabel users.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Tambahkan kolom 'role' setelah kolom 'email'
            $table->enum('role', ['user', 'admin'])->default('user')->after('email');
        });
    }

    /**
     * Batalkan migrasi (hapus kolom 'role' jika rollback dijalankan).
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('role');
        });
    }
};
