<?php

use Faker\Generator as Faker;

$factory->define(App\Post::class, function (Faker $faker) {
    return [
        'post_type_id' => 1,
        'post' => $faker->text(200),
        'caption' => $faker->text(100)
    ];
});
