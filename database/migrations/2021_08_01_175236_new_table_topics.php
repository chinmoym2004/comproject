<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class NewTableTopics extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('topics', function (Blueprint $table) {
            $table->id();

            $table->string('title')->nullable(); 
            $table->longText('body')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->string('status')->nullable()->comment("0=> unpublished, 1 => published");
            $table->boolean('is_spam')->default(0);
            $table->boolean('category_id')->default(0);
            
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
        Schema::dropIfExists('topics');
    }
}
