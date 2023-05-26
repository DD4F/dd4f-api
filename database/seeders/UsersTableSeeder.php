<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        # Manager
        $manager = \App\Models\User::create([
            'name'      => 'dd4f',
            'username'  => 'dd4f',
            'email'     => 'dd4f@app.com',
            'password'  => bcrypt('dd4f'),
        ]);
        $manager->addRole('manager');

        # Agent
        $agent = \App\Models\User::create([
            'name'      => 'badbios',
            'username'  => 'badbios',
            'email'     => 'badbios@app.com',
            'password'  => bcrypt('badbios'),
        ]);
        $agent->addRole('agent');
    }
}
