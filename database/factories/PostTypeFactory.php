<?php

use Faker\Generator as Faker;

$factory->define(Model::class, function (Faker $faker) {
    $postTypes = ['AUDIO', 'TEXT', 'VIDEO', 'IMAGE'];
    return [
        'post_type' => $faker->randomElement($postTypes)
    ];
});
