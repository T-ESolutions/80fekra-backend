<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->references('id')->on('users')->onDelete('restrict');
            $table->json('address');
            $table->json('coupon')->nullable();
            $table->double('subtotal')->default(0);
            $table->double('discount')->default(0);
            $table->double('shipping_cost')->default(0);
            $table->double('total')->default(0);
            $table->enum('payment_status',['paid','not_paid'])->default('not_paid');
            $table->enum('payment_type',['cash','visa'])->default('cash');
            $table->enum('status',['pending','on_progress','shipped','delivered','rejected','canceled_by_user','canceled_by_admin'])->default('pending');
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
        Schema::dropIfExists('orders');
    }
}
