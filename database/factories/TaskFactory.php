<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Task as Task;
use Faker\Generator as Faker;

$factory->define(Task::class, function (Faker $faker) {
    return [
        'title' => $faker->text($maxNbChars = 50),
        'description' => $faker->paragraph,
        'completed' => $faker->boolean,
        'user_id' => function () {
            return factory(App\Models\User::class)->create()->id;
        }
    ];
});
