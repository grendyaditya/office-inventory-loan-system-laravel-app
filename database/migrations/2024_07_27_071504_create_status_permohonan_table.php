<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStatusPermohonanTable extends Migration
{
    public function up()
    {
        Schema::create('status_permohonan', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('permohonan_pinjaman_id');
            $table->enum('status', [0, 1, 2])->default(0); // 0 = pending, 1 = disetujui, 2 = ditolak
            $table->text('izin_user_ids')->nullable();
            $table->text('tolak_user_ids')->nullable();
            $table->timestamps();

            $table->foreign('permohonan_pinjaman_id')->references('id')->on('permohonan_pinjaman')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('status_permohonan');
    }
}