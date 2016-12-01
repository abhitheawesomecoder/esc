<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Eloquent\Model;

class CreateTransactionsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Model::unguard();
        Schema::create('transactions',function(Blueprint $table){
            $table->increments("id");
            $table->string("gateway_name");
            $table->integer("user_id")->references("id")->on("user");
            $table->decimal("amount", 15, 2);
            $table->string("transation_id");
            $table->tinyInteger("status")->default(0);
            $table->string("type");
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
        Schema::drop('transactions');
    }

}