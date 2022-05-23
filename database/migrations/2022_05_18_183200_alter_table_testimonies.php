<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableTestimonies extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table("testimonies", function(Blueprint $table){
            $table->foreignId("testifier_id")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::table("testimonies", function(Blueprint $table){
            $table->dropForeign("testimonies_testifier_id_foreign");
            $table->dropColumn("testifier_id");
        });
    }
}
