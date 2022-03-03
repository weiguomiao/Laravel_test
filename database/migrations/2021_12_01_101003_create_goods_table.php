<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGoodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('goods', function (Blueprint $table) {
            $table->id();
            $table->string('name')->comment('商品名称');
            $table->integer('user_id')->comment('创建者');
            $table->integer('category_id')->comment('分类id');
            $table->string('desc')->comment('商品描述');
            $table->decimal('price',14,2)->comment('价格');
            $table->integer('stock')->comment('库存');
            $table->string('cover')->comment('封面');
            $table->json('pics')->comment('小图集');
            $table->tinyInteger('is_on')->default(1)->comment('是否上架：1上架 2下架');
            $table->tinyInteger('is_recommend')->default(2)->comment('是否是否推荐：1推荐 2不推荐');
            $table->text('detail')->comment('商品详情');
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
        Schema::dropIfExists('goods');
    }
}
