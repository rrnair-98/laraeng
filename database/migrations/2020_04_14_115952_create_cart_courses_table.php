<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCartCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cart_courses', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('cart_id');
            $table->uuid('course_id');
            $table->dateTime('valid_till'); // to be copied from associated course, this is essentially the cycle
            $table->double('cost_price'); // to be copied from associated course, this is the cp of the course at that point in time
            $table->timestamps();
            $table->uuid('created_by'); // id of the student
            $table->uuid('updated_by')->nullable();
            $table->softDeletes();
            $table->json('description')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cart_courses');
    }
}
