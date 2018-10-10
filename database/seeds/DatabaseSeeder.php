<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->postTypeSeeder();
        $this->call(UsersTableSeeder::class);
        $this->call(PostsTableSeeder::class);
        $this->call(CommentsTableSeeder::class);
    }

    public function postTypeSeeder()
    {
        $postTypes = ['AUDIO', 'TEXT', 'VIDEO', 'IMAGE'];

        for ($i = 0; $i < 4; $i++) {
            DB::table('post_type')->insert([
                'post_type' => $postTypes[$i]
            ]);
        }
    }
}
