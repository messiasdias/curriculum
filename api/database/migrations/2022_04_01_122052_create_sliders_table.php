<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSlidersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sliders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('images_id')->nullable();
            $table->string('title');
            $table->string('subtitle')->nullable();
            $table->string('link_url')->nullable();
            $table->string('link_text')->nullable();
            $table->timestamp('broadcast_start')->nullable();
            $table->timestamp('broadcast_end')->nullable();
            $table->enum('type', ['slider', 'box'])->default('slider');
            $table->boolean('active')->default(false);
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
        Schema::dropIfExists('sliders');
    }
}
