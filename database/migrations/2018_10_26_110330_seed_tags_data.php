<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SeedTagsData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $tags = [
            [
                'name' => 'PHP',
                'image' => config('app.url') . '/images/tags/php.png',
                'description' => 'PHP',
            ],
            [
                'name' => 'Nginx',
                'image' => config('app.url') . '/images/tags/nginx.jpeg',
                'description' => 'Nginx',
            ],
            [
                'name' => 'MySQL',
                'image' => config('app.url') . '/images/tags/mysql.png',
                'description' => 'MySQL',
            ],
            [
                'name' => 'Linux',
                'image' => config('app.url') . '/images/tags/linux.png',
                'description' => 'Linux',
            ],
            [
                'name' => 'Git',
                'image' => config('app.url') . '/images/tags/git.png',
                'description' => 'Git',
            ],
            [
                'name' => 'Redis',
                'image' => config('app.url') . '/images/tags/redis.jpeg',
                'description' => 'Redis',
            ],
        ];

        DB::table('tags')->insert($tags);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('tags')->truncate();
    }
}
