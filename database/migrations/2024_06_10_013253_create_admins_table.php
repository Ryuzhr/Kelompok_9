<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdminsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admins', function (Blueprint $table) {
            $table->id(); // This creates an auto-incrementing unsigned BIGINT primary key
            $table->string('name');
            $table->string('email')->unique();
            $table->string('address');
            $table->string('password');
            $table->string('image')->nullable();
            $table->timestamps(); // This creates created_at and updated_at columns
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('admins');
    }
}
