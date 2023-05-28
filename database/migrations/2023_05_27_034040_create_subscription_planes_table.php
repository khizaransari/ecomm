<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subscription_planes', function (Blueprint $table) {
            $table->id();
            $table->string('name', 254);
            $table->text('description')->nullable();
            $table->float('price');
            $table->string('billing_cycle');
            $table->string('currency')->default('$');
            $table->boolean('status')->default(1); // active inactive
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
        Schema::dropIfExists('subscription_planes');
    }
};
