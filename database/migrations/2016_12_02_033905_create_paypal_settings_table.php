<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Eloquent\Model;

class CreatePaypalSettingsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Model::unguard();
        Schema::create('paypalsettings',function(Blueprint $table){
            $table->increments("id");
            $table->string("paypal_mode");
            $table->string("paypal_api_username");
            $table->string("paypal_api_password");
            $table->string("paypal_api_signature");
            $table->string("paypal_app_id");
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
        Schema::drop('paypalsettings');
    }

}