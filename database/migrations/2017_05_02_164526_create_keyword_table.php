<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKeywordTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if ( ! Schema::hasTable('keywords')) {
            Schema::create('keywords', function (Blueprint $table) {
                $table->increments('id');
                $table->string('var_name',255)->comment("变量名");
                $table->integer('lang_id')->comment("table->lang : id")->nullable();
                $table->text('chinese')->comment("中文词汇");
                $table->text('japanese')->comment("日文词汇");
                $table->tinyInteger('person')->comment("责任人")->default('1');
                $table->tinyInteger('sponsor')->comment("发起人")->default('4');
                $table->string('description')->comment("详解")->nullable();
                $table->string('comment')->comment("修改说明")->nullable();
                $table->integer('status')->comment("状态：0正常，1待处理，2已处理，3弃用")->nullable()->default(0);
                $table->integer('type')->comment("类型：1后台，0前台")->nullable()->default(1);
                $table->integer('order')->comment("排序：ASC")->nullable()->default(5);
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('keywords');
    }
}
