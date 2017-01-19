<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSaleTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sale_items_transactions', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('sale_item_id');
            $table->unsignedInteger('in_stock');
            $table->unsignedInteger('on_board');
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
        Schema::dropIfExists('sale_items_transactions');
    }
}
