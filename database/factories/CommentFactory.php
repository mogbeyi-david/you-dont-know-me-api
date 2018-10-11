<?php

use Faker\Generator as Faker;

$factory->define(App\Comment::class, function (Faker $faker) {

    return [
        'comment' => $faker->text(50),
        'post_id' => rand(3, 102)
    ];
});
