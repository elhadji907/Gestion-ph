<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'categories';
    public function up()
    {
        /* Schema::create('categories', function (Blueprint $table) { */
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->id();
            $table->string('categorie');
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
        /* Schema::dropIfExists('categories'); */
        Schema::dropIfExists($this->tableName);
    }
}
