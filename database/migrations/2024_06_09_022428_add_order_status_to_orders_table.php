<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddOrderStatusToOrdersTable extends Migration
{
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->unsignedBigInteger('order_status_id')->default(1); // Memberikan nilai default 1
            $table->foreign('order_status_id')->references('id')->on('order_statuses');
        });
    }

    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign(['order_status_id']);
            $table->dropColumn('order_status_id');
        });
    }
};

