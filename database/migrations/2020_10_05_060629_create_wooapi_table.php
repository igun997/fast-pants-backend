<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWooapiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wooapi', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('name', 100);
            $table->string('domain', 100)->unique('domain');
            $table->text('key_secret');
            $table->integer('user_id')->index('user_id');
            $table->tinyInteger('is_active');
            $table->date('created_at')->nullable();
            $table->date('updated_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wooapi');
    }
}
