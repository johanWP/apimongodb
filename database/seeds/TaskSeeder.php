<?php

use Illuminate\Database\Seeder;
use App\Task;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();

        for($i = 0; $i < 50; $i++) {
            $date = DateTime::createFromFormat ( 'Y-m-d H:i:sO' , $faker->date() . $faker->time('H:i:sO'));
            Task::create([
                'title' => $faker->sentence(),
                'description' => $faker->text(180),
                'due_date' => date_format($date, 'Y-m-d H:i:s'),
                'completed' => false,
                'created_at' => '2017-08-27 16:00:00',
                'updated_at' => '2017-08-27 16:00:00'
            ]);
        }
    }
}
