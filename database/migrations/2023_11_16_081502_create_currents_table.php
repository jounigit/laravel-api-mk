<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('currents', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->string('slug');
            $table->string('place');
            $table->string('address');
            $table->text('content');
            $table->string('en_title');
            $table->string('en_slug');
            $table->text('en_content');
            $table->date('from_date');
            $table->date('to_date');
            $table->boolean('is_published');
            $table->boolean('is_expired');
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
        Schema::dropIfExists('currents');
    }
};
