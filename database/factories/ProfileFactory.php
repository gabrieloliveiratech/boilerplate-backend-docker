<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Constants\Constants;
use App\Models\Profile;
use Faker\Generator as Faker;

$factory->define(Profile::class, function (Faker $faker) {
    return [
        'name' => $faker->jobTitle
    ];
});

$factory->afterCreatingState(Profile::class, Constants::PROFILE_ADMIN, function (Profile $profile) {
    $profile->name = Constants::PROFILE_ADMIN;
    $profile->save();
});

$factory->afterCreatingState(Profile::class, Constants::PROFILE_USER, function (Profile $profile) {
    $profile->name = Constants::PROFILE_USER;
    $profile->save();
});
