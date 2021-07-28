<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePropertiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('properties', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid');
            $table->unsignedBigInteger('property_type_id');
            $table->foreign('property_type_id')->references('id')->on('property_types');
            $table->string('county');
            $table->string('country');
            $table->string('town');
            $table->text('description');
            $table->string('address');
            $table->string('image_full');
            $table->string('image_thumbnail');
            $table->string('latitude');
            $table->string('longitude');
            $table->integer('num_bedrooms');
            $table->integer('num_bathrooms');
            $table->decimal('price', 11, 2);
            $table->string('type');
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
        Schema::dropIfExists('properties');
    }
}
