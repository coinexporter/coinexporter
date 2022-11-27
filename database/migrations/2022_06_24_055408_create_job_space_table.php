<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobSpaceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('job_space', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->text('campaign_name');
            $table->integer('campaign_category_id');
            $table->integer('campaign_subcategory_id');
            $table->string('campaign_req');
            $table->string('campaign_proof');
            $table->string('campaign_time');
            $table->string('campaign_job_no');
            $table->double('campaign_earning');
            $table->string('status');
            $table->string('country');
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
        Schema::dropIfExists('job_space');
    }
}
