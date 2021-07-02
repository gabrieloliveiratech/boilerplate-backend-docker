<?php

use App\Models\Profile;
use Illuminate\Database\Seeder;

class ProfileTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Profile::class)->create(['name' => 'admin']);
        factory(Profile::class)->create(['name' => 'user']);  
    }
}
