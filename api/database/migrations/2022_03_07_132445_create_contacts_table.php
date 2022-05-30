<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contacts', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->string('phone');
            $table->string('state');
            $table->string('city');
            $table->string('subject');
            $table->longText('message');
            $table->boolean('star')->default(false);
            $table->boolean('archived')->default(false); 
            $table->enum('status', ['new', 'readed', 'resolved'])->default('new');
            $table->unsignedBigInteger('readed_by')->nullable();
            $table->timestamp('readed_at')->nullable();
            $table->unsignedBigInteger('resolved_by')->nullable();
            $table->timestamp('resolved_at')->nullable();
            $table->timestamp('email_confirmed_at')->nullable();
            $table->timestamp('phone_confirmed_at')->nullable();
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
        Schema::dropIfExists('contacts');
    }
}
