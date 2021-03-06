<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFieldsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fields', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('module_id');
            $table->string('name');
            $table->string('label');
            $table->string('type');
            $table->string('field_type');
            $table->boolean('relation')->default(0);
            $table->string('json_options')->nullable();
            $table->boolean('in_table')->default(1);
            $table->boolean('buided')->default(0);
            $table->boolean('migrated')->default(0);
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
        Schema::dropIfExists('fields');
    }
}
