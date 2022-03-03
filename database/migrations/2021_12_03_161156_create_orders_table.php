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
            $table->integer('user_id')->comment('下单用户');
            $table->string('order_no')->comment('单号');
            $table->decimal('amount',14,2)->comment('订单价格');
            $table->tinyInteger('status')->default(1)->comment('订单状态: 1下单 2支付 3发货 4收货');
            $table->integer('address_id')->comment('收货地址');
            $table->string('express_type')->nullable()->comment('快递类型');
            $table->string('express_no')->nullable()->comment('快递单号');
            $table->timestamp('pay_time')->nullable()->comment('支付时间');
            $table->string('pay_type')->nullable()->comment('支付类型');
            $table->string('trade_no')->nullable()->comment('交易单号');
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
