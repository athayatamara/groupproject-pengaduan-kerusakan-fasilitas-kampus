<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();      // pelapor
            $table->foreignId('category_id')->constrained();
            $table->foreignId('location_id')->constrained();
            $table->string('title');
            $table->text('description');
            $table->string('urgency', 10)->default('sedang'); // rendah | sedang | tinggi
            $table->string('status', 15)->default('menunggu'); // menunggu | diverifikasi | diproses | selesai | ditolak
            $table->string('photo')->nullable();               // foto kerusakan
            $table->text('rejection_reason')->nullable();      // alasan jika ditolak
            $table->text('admin_note')->nullable();            // catatan perbaikan
            $table->string('repair_photo')->nullable();        // foto hasil perbaikan
            $table->unsignedTinyInteger('rating')->nullable(); // 1-5 dari pelapor
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};
