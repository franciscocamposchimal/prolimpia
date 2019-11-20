<?php
use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $rootUser = new User();
        $rootUser->name ="admin";
        $rootUser->email ="admin@gmail.com";
        $rootUser->password = Hash::make('admin');
        $rootUser->rol = "ADMIN";
        $rootUser->created_at = date('Y-m-d H:m:s');
        $rootUser->updated_at = date('Y-m-d H:m:s');
        $rootUser->save();

        $userAdmin = new User();
        $userAdmin->name ="franko";
        $userAdmin->email ="franko@gmail.com";
        $userAdmin->password = Hash::make('12345678');
        $userAdmin->rol = "ROOT";
        $userAdmin->created_at = date('Y-m-d H:m:s');
        $userAdmin->updated_at = date('Y-m-d H:m:s');
        $userAdmin->save();
    }
}
