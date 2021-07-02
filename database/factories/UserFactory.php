<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Constants\Constants;
use App\Models\Profile;
use App\Models\User;
use Faker\Generator as Faker;

$factory->define(User::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'username' => $faker->userName,
        'email' => $faker->email,
        'password' => $faker->password(),
    ];
});

$factory->afterCreatingState(User::class, Constants::PROFILE_ADMIN, function(User $user){
    $profile = Profile::where('name', Constants::PROFILE_ADMIN)->first();
    if(!$profile){
        $profile = factory(Profile::class)->states('admin')->create();
    }
    $user->profile_id = $profile->id;
    $user->save();
});

$factory->afterCreatingState(User::class, Constants::PROFILE_USER, function(User $user){
    $profile = Profile::where('name', Constants::PROFILE_USER)->first();
    if(!$profile){
        $profile = factory(Profile::class)->states('user')->create();
    }
    $user->profile_id = $profile->id;
    $user->save();
});
