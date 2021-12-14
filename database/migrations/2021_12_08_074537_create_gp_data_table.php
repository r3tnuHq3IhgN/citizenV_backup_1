<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGpDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gp_data', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->integer('id_card')->unsigned()->nullable();
            $table->string('full_name');
            $table->date('date_of_birth');
            $table->integer('age')->nullable();
            $table->enum('gender',['male','female']);
            $table->string('native_place');
            $table->string('address');
            $table->string('address1');
            $table->string('religion');
            $table->string('edu_level'); 
            $table->string('career');
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
        Schema::dropIfExists('gp_data');
    }
}
