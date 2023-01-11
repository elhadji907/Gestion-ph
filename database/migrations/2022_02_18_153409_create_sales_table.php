<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('code');
            $table->string('name');
            $table->integer('quantity');
            $table->integer('purchase_quantity');
            $table->decimal('total_price');
            $table->string('nom_client')->nullable();
            $table->string('telephone_client')->nullable();
            $table->string('item1')->nullable();
            $table->string('item2')->nullable();
            $table->string('item3')->nullable();
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
        Schema::dropIfExists('sales');
    }
}
