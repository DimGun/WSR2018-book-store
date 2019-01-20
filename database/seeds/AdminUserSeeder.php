<?php

use Illuminate\Database\Seeder;
use App\User;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $admin = new User();
      $admin->name = 'admin';
      $admin->email = 'admin';
      $admin->password = Hash::make('moscow2018');
      $admin->save();
    }
}
