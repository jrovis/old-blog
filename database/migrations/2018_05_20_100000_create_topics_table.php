 <?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTopicsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('topics', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title')->comment('文章标题');
            $table->text('body')->comment('文章内容');
            $table->text('body_original')->comment('原始内容');
            $table->integer('user_id')->unsigned()->index()->comment('用户id');
            $table->integer('last_reply_user_id')->unsigned()->index()->comment('最后回复人id');
            $table->integer('views_count')->unsigned()->default(0)->index()->comment('查看数');
            $table->integer('replies_count')->unsigned()->default(0)->index()->comment('回复数');
            $table->integer('votes_count')->unsigned()->default(0)->index()->comment('点赞数');
            $table->tinyInteger('close_reply')->unsigned()->default(0)->comment('是否关闭回复');
            $table->tinyInteger('is_hot')->unsigned()->default(0)->index()->comment('是否热门文章');
            $table->tinyInteger('is_hidden')->unsigned()->default(0)->index()->comment('是否隐藏文章');
            $table->text('excerpt')->nullable()->comment('文章摘录');
            $table->string('slug', 1000)->nullable()->comment('SEO友好的URI');
            $table->tinyInteger('is_delete')->unsigned()->default(0)->index();
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
        Schema::dropIfExists('topics');
    }
}
