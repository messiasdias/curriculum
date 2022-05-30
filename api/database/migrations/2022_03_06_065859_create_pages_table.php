<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pages', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique('page_name');
            $table->string('slug')->unique('page_slug');
            $table->longText('content')->nullable();
            $table->string('breadcrumb')->nullable();
            $table->boolean('breadcase')->default(true);
            $table->boolean('show_home')->default(false);
            $table->boolean('is_default_page')->default(false);
            $table->boolean('active')->default(true);
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
        Schema::dropIfExists('pages');
    }
}
