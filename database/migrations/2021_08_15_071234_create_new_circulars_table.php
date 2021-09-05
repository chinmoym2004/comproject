<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNewCircularsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('circulars', function (Blueprint $table) {
            $table->id();
            $table->string("title")->nullable();
            $table->longText("details")->nullable();
            $table->boolean('need_confirmation')->default(1);
            $table->unsignedBigInteger('user_id');

            $table->boolean('need_approval')->default(1);
            $table->unsignedBigInteger('approved_by')->nullable();
            $table->timestamp('approved_at')->nullable();
            
            
            $table->unsignedBigInteger('published_by')->nullable();
            $table->boolean('published')->default(0);
            $table->timestamp('published_at')->nullable();

            $table->boolean('to_all')->default(0);
            $table->string('group_ids')->nullable();
            
            
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
        Schema::dropIfExists('circulars');
    }
}
