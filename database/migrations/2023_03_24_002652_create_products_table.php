<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('title_ar');//
            $table->string('title_en');
            $table->text('description_ar');
            $table->text('description_en');
            $table->text('attributes_ar');
            $table->text('attributes_en');
            $table->tinyInteger('is_active')->default(1);
            $table->integer('sort_order')->default(1);
            $table->double('price')->default(0);
            $table->double('discount')->default(0);
            $table->json('tags')->nullable();
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
        Schema::dropIfExists('products');
    }
}
