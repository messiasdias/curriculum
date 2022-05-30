<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePageNavegationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('page_navegations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pages_id');
            $table->unsignedBigInteger('items_id')->nullable();
            $table->string('user_device_uuid');
            $table->string('user_device_ip')->nullable();
            $table->string('user_device_vendor')->default('outher');
            $table->string('user_device_type')->default('outher');
            $table->string('user_device_platform')->default('outher');
            $table->string('user_name')->nullable();
            $table->string('user_email')->nullable();
            $table->string('user_phone')->nullable();
            $table->float('user_location_lat')->default(0);
            $table->float('user_location_long')->default(0);
            $table->integer('views')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('page_navegations');
    }
}
