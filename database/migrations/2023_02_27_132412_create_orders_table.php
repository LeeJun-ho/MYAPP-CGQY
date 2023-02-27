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
            $table->id()->comment('ID');
            $table->char('code', 12)->charset('utf8')->unique()->comment('주문번호');
            $table->foreignId('user_id')->references('id')->on('users')->comment('사용자 ID');
            $table->string('product_name', 100)->comment('상품명');
            $table->dateTimeTz('payment_at')->comment('결제일시');
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
