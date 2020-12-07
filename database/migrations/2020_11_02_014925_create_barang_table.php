<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBarangTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('barang', function (Blueprint $table) {
            $table->id('product_id');
            $table->string('upc', 64)->index()->nullable();
            $table->string('nama');
            $table->longText('deskripsi')->nullable();
            $table->string('gambar')->nullable();
            $table->unsignedInteger('jumlah')->index()->default(0);
            $table->unsignedInteger('jumlah_minimal')->default(0);
            $table->boolean('status')->index()->default(1);
            $table->timestamps();
            $table->softDeletes('deleted_at', 0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('barang');
    }
}
