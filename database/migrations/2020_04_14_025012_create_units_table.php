<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUnitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('units', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('course_id');
            $table->string('unit_name', 255);
            $table->double('marks');
            $table->integer('duration'); // in minutes
            $table->tinyInteger('is_scheduled');
            $table->dateTime('start_date')->nullable();
            $table->tinyInteger('is_draft');
            $table->timestamps();
            $table->uuid('created_by');
            $table->uuid('updated_by')->nullable();
            $table->softDeletes();
            $table->text('active_doc_url')->nullable(); // the active test document
            $table->json('file_urls')->nullable();
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
        Schema::dropIfExists('units');
    }
}
