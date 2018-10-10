<?php

use Faker\Generator as Faker;

$factory->define(Model::class, function (Faker $faker) {
    $postTypes = ['AUDIO', 'TEXT', 'VIDEO'];
    return [
        'post_type' => $faker->randomElement($postTypes)
    ];
});
