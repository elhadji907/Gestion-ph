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
            $table->foreignId('purchase_id')->nullable()->constrained()->onDelete("cascade");
            $table->decimal('price');
            $table->decimal('discount')->default(0);
            $table->string('description')->nullable();
            $table->string('item1')->nullable();
            $table->string('item2')->nullable();
            $table->string('created_by', 200)->nullable();
            $table->string('updated_by', 200)->nullable();
            $table->string('deleted_by', 200)->nullable();
            $table->softDeletes();
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
