<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('ticket_tickets', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('CASCADE');
            $table->string('subject');
            $table->text('content');
            $table->string('status', 16);
            $table->unsignedBigInteger('type_id');
            $table->foreign('type_id')->references('id')->on('ticket_types')->onDelete('cascade');
            $table->json('attached_files')->nullable();
            $table->timestamps();
        });

        Schema::create('ticket_statuses', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('ticket_id');
            $table->foreign('ticket_id')->references('id')->on('ticket_tickets')->onDelete('CASCADE');
            $table->unsignedInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('CASCADE');
            $table->string('status', 16);
            $table->timestamps();
        });

        Schema::create('ticket_types', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Add any additional attributes for ticket types
            $table->timestamps();
        });

        Schema::create('ticket_messages', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('ticket_id');
            $table->foreign('ticket_id')->references('id')->on('ticket_tickets')->onDelete('CASCADE');
            $table->unsignedInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('CASCADE');
            $table->text('message');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ticket_messages');
        Schema::dropIfExists('ticket_statuses');
        Schema::dropIfExists('ticket_tickets');
        Schema::dropIfExists('ticket_types');

    }
};
