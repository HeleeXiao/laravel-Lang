<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLangTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if ( ! Schema::hasTable('lang')) {
            Schema::create('lang', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('file_id')->comment("关联的附件")->nullable();
                $table->string('title');
                $table->string('url')->comment("url");
                $table->text('description')->nullable();
                $table->tinyInteger('person')->comment("责任人")->default('1');
                $table->tinyInteger('sponsor')->comment("发起人")->default('4');
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
        Schema::dropIfExists('lang');
    }
}
