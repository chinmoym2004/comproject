<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNewForums extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('forums', function (Blueprint $table) {
            $table->id();
            $table->string("name")->nullable();

            $table->string("campus")->nullable();
            $table->string("school")->nullable();
            $table->string("program")->nullable();

            $table->longText('details')->nullable();

            $table->integer("topic_count")->default(0);
            $table->integer("post_count")->default(0);
            
            $table->unsignedBigInteger("user_id");

            $table->boolean('is_public')->default(0); // Forum type 

            $table->unsignedBigInteger('group_id')->nullable();
            $table->unsignedBigInteger('category_id');

            $table->boolean('published')->default(0);
            $table->unsignedBigInteger('published_by')->nullable();
            $table->timestamp('published_at')->nullable();

            $table->string('slug');

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
        Schema::dropIfExists('forums');
    }
}
