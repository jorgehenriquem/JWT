<?php

use Illuminate\Database\Seeder;

class CompaniesSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       App\Company::create([
       	'name'=> str_random(10),
       	'email'=> str_random(10).'@email.com',
       	'password'=> bcrypt('senha'),
       	'website'=> str_random(10),
       	'logo'=> str_random(10),
       	]);
    }
}
