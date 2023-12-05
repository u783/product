<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('image')->nullable();
            $table->string('product_name');
            $table->decimal('price', 10, 2);
            $table->integer('stock');
            $table->unsignedBigInteger('company_id')->nullable();
            $table->text('comment')->nullable();
            $table->timestamps();


            $table->string('company_name')->nullable();
            $table->foreign('company_id')->references('id')->on('companies');
        });
    }

    public function down()
    {
        Schema::dropIfExists('products');
    }
}


