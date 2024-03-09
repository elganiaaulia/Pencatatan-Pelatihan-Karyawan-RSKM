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
        Schema::create('riwayat_pelatihan', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('karyawan_per_periode')
            ->constrained('karyawan_per_periode')->onUpdate('cascade');
            $table->unsignedBigInteger('periode_id')->nullable();
            $table->foreign('periode_id')->references('id')->on('periode')
            ->constrained('periode')->onUpdate('cascade');
            $table->string('nama_pelatihan');
            $table->string('nama_penyelenggara');
            $table->string('bukti_pelatihan');
            $table->dateTime('tgl_mulai');
            $table->dateTime('tgl_selesai');
            $table->integer('durasi');
            $table->boolean('wajib');
            $table->boolean('verified');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('riwayat_pelatihan');
    }
};
