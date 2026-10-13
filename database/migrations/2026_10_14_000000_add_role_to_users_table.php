<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // Menambah kolom peran dan identitas pada tabel users bawaan Laravel
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('role', 20)->default('mahasiswa')->after('password'); // mahasiswa | dosen_tendik | admin
            $table->string('identity_number', 30)->nullable()->unique()->after('role'); // NIM / NIP / NIDN
            $table->string('phone', 20)->nullable()->after('identity_number');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropUnique(['identity_number']);
            $table->dropColumn(['role', 'identity_number', 'phone']);
        });
    }
};
