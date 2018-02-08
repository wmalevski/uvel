<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(LaratrustSeeder::class);
        // $owner = new Role();
        // $owner->name         = 'admin';
        // $owner->display_name = 'Админ'; // optional
        // $owner->description  = 'Пълни права в сайта'; // optional
        // $owner->save();
        
        // $admin = new Role();
        // $admin->name         = 'employee';
        // $admin->display_name = 'Служител'; // optional
        // $admin->description  = 'Ограничени права в сайта'; // optional
        // $admin->save();
    }
}
