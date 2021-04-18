<?php

namespace Database\Seeders;

use App\Models\Message;
use App\Models\User;
use Illuminate\Database\Seeder;

class MessagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    /**
     * Run the database seeds.
     */
    public function run()
    {
//        Message::truncate();
        Message::unguard();
        $faker = \Faker\Factory::create();
        User::all()->each(function ($user) use ($faker) {
            foreach (range(1, 5) as $i) {
                Message::create([
                    'user_id' => $user->id,
                    'content' => $faker->paragraphs(3, true),
                ]);
            }
        });
    }
}
