<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNewTopicActions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('topic_actions', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('topic_id');
            $table->unsignedBigInteger('user_id');
            $table->integer('action_type')->nullable()->comment('1=>upvote,2=>accepted,3=>spam');

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
        Schema::dropIfExists('topic_actions');
    }
}
