<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Database\seeders\UserSeeder;
 
class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeders.
     * The class populates the users table of the default 
     * user administrator with credentials:
     * username:demouser
     * password:canteen
     * 
     * @return void
     * @author Marino Giudice
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Demo User',
            'username' => 'demouser',
            'password' => Hash::make('canteen'),
        ]);
    }
        
}
