<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
//        所有的一起执行而且按照顺序
         $this->call(UsersTableSeeder::class);
        $this->call(TopicsTableSeeder::class);
		$this->call(RepliesTableSeeder::class);

    }
}
