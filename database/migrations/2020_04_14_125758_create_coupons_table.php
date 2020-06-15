<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCouponsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coupons', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('coupon_code', 255);
            $table->tinyInteger('coupon_type'); // 0 flat, 1 percentage
            $table->double('upper_limit'); // max amount that can be deducted from the bill
            $table->double('minimum_cart_value'); // minimum amount of the cart to avail this coupon
            $table->unsignedInteger('max_count'); // max times this can be applied
            $table->timestamps();
            $table->uuid('created_by');
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
        Schema::dropIfExists('coupons');
    }
}
