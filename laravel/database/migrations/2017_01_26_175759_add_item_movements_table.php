<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddItemMovementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('item_movements', function (Blueprint $table) {
            $table->increments('id');
            $table->string('tran_type');//add_sale/add_purchase/delete_sale/delete_purchase/opening_blanace
            $table->unsignedInteger('tran_type_id')->nullable();
            $table->unsignedInteger('qty');
            $table->unsignedInteger('in_stock');
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
        Schema::dropIfExists('item_movements');
    }
}
