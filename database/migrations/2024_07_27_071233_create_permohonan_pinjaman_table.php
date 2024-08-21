<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePermohonanPinjamanTable extends Migration
{
    public function up()
    {
        Schema::create('permohonan_pinjaman', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('divisi');
            $table->unsignedBigInteger('barang_id');
            $table->integer('jumlah_barang');
            $table->date('tanggal_pinjam');
            $table->date('tanggal_dikembalikan');
            $table->text('alasan');
            $table->unsignedBigInteger('user_id');
            $table->enum('status_pengembalian', ['0', '1', '2', '3'])->default('0');
            // ['menunggu ', 'belum dikembalikan', 'sudah dikembalikan', 'dikembalikan terlambat'])->default('menunggu persetujuan');
            $table->date('tanggal_pengembalian')->nullable();
            $table->foreign('barang_id')->references('id')->on('barang')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('permohonan_pinjaman');
    }
}