<?php

namespace Database\Seeders;

use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Str;
use App\Models\USER;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // instance Facker class
        $faker = Faker::create();

        # permissions
        $permissions = config()->get('blog.permissions');

        foreach ($permissions as $permission){
            $perExist = Permission::where('name', $permission)->first();
            if(!$perExist){
                Permission::create(['name' => $permission]);
            }
        }
        # roles
        $roleSuperAdmin = Role::where('name', '=', 'admin')->first();
        if(!$roleSuperAdmin){
            Role::create(['name' => 'admin']);
            $roleSuperAdmin = Role::where('name', '=', 'admin')->first();
        }

        $roleSuperAdmin->permissions()->sync([]);
        $roleSuperAdmin->givePermissionTo($permissions);


        $user = USER::where('email', config('blog.admin_mail'))->first();
        if(!$user){
            USER::create([
                'name' => 'Customer',
                'email' => config('blog.admin_mail'),
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
                'created_at' => now(),
                'updated_at' => now(),
                'remember_token' => Str::random(10),
            ])->assignRole('admin');
        }


        $user = USER::where('email', config('blog.admin_mail'))->first();
        $userId = $user->id;




        for($i = 0; $i<10; $i++){
            //create cooperators
            DB::table('posts')->insert([
                'slug' =>  $faker->sentence,
                'title' => $faker->sentence,
                'description' => $faker->realText(),
                'created_at' => $faker->dateTimeBetween($startDate = '-5 years', $endDate = 'now'),
                'updated_at' => $faker->dateTimeBetween($startDate = '-5 years', $endDate = 'now'),
                'user_id' => $userId
            ]);


        }
    }
}
