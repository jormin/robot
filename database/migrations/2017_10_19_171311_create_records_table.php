<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('records', function (Blueprint $table) {
            $table->increments('id')->comment('主键ID');
            $table->string('userID')->comment('用户ID');
            $table->string('message')->comment('消息内容');
            $table->string('reply')->nullable()->comment('回复内容');
            $table->string('audio')->nullable()->comment('语音文件');
            $table->string('config')->nullable()->comment('配置');
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
        Schema::dropIfExists('records');
    }
}
