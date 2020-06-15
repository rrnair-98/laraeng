<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('sid', 255)->unique();
            $table->integer('user_role'); // teacher, student, ops, admin
            $table->timestamp('email_verified_at')->nullable();
            $table->string('phone', 15)->unique();
            $table->integer('otp')->nullable();
            $table->dateTime('otp_expires_at')->nullable();
            $table->string('password', 255);
            $table->rememberToken();
            $table->timestamps();
            $table->json('description')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
