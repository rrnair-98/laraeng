<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCartsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('carts', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->integer('payment_status');
            $table->double('total_discount')->nullable();
            $table->uuid('coupon_id')->nullable();// id of the coupon being applied
            $table->timestamps();
            $table->uuid('created_by'); // id of the student
            $table->uuid('updated_by')->nullable();
            $table->softDeletes();
            $table->json('payment_information')->nullable();
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
        Schema::dropIfExists('carts');
    }
}
