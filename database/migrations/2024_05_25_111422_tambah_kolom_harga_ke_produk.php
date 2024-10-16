<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TambahKolomHargaKeProduk extends Migration
{
    public function up()
    {
        Schema::table('produks', function (Blueprint $table) {
            $table->decimal('harga', 10, 2)->after('gambar')->nullable();
        });
    }

    public function down()
    {
        Schema::table('produks', function (Blueprint $table) {
            $table->dropColumn('harga');
        });
    }
}


