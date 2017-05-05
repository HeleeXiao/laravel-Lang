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
                $table->integer('keyword_id')->comment("关联的语言词汇");
                $table->integer('file_id')->comment("关联的附件");
                $table->string('title');
                $table->text('description');
                $table->tinyInteger('person')->comment("责任人")->default('1');
                $table->tinyInteger('sponsor')->comment("发起人")->default('4');
                $table->integer('status')->comment("状态：0正常，1待处理，2已处理，3弃用")->nullable()->default(0);
                $table->integer('type')->comment("类型：1后台，0前台")->nullable()->default(1);
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
