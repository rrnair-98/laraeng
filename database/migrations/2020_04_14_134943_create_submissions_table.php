<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubmissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('submissions', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('unit_id');
            $table->uuid('cart_course_id');
            $table->integer("status");
            $table->timestamps();
            $table->uuid('created_by');
            $table->uuid('updated_by')->nullable();
            $table->softDeletes();
            $table->json("file_urls");
            $table->json("comments");
            $table->jsonb("marks");
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
        Schema::dropIfExists('submissions');
    }
}
