<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChatTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('conversations', function (Blueprint $table) {
            $table->increments('id');
            $table->boolean('private')->default(true);
            $table->text('data')->nullable();
            $table->timestamps();
        });

        Schema::create('messages', function (Blueprint $table) {
            $table->increments('id');
            $table->text('body');
            $table->integer('conversation_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->string('type')->default('text');
            $table->timestamps();

            $table->foreign('user_id')
                ->references('id')
                ->on('users');

            $table->foreign('conversation_id')
                ->references('id')
                ->on('conversations');
        });

        Schema::create('conversation_user', function (Blueprint $table) {
            $table->integer('user_id')->unsigned();
            $table->integer('conversation_id')->unsigned();
            $table->primary(['user_id', 'conversation_id']);
            $table->timestamps();

            $table->foreign('conversation_id')
                ->references('id')->on('conversations')
                ->onDelete('cascade');

            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade');
        });

        Schema::create('message_notification', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('message_id')->unsigned();
            $table->integer('conversation_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->boolean('is_seen')->default(false);
            $table->boolean('is_sender')->default(false);
            $table->boolean('flagged')->default(false);
            $table->timestamps();
            $table->softDeletes();

            $table->index(['user_id', 'message_id']);

            $table->foreign('message_id')
                ->references('id')->on('messages')
                ->onDelete('cascade');

            $table->foreign('conversation_id')
                ->references('id')->on('conversations')
                ->onDelete('cascade');

            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('conversations');
        Schema::dropIfExists('messages');
        Schema::dropIfExists('conversation_user');
        Schema::dropIfExists('message_notification');
    }
}
