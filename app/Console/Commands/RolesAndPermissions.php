<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;


class RolesAndPermissions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:role-permission';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'create roles and permissions if they don\'t exist and assigned role admin to customer if not yet assigned';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $permissions = $this->addPermissionsIfNotExist();

        $roleAdmin = $this->addAdminRoleIfNotExist();

        $roleAdmin->permissions()->sync([]);
        $roleAdmin->givePermissionTo($permissions);

        $this->addAdminUserIfNotExist();

    }

    /**
     * @return \Illuminate\Config\Repository|mixed
     */
    public function addPermissionsIfNotExist()
    {
        $permissions = config('blog.permissions');

        foreach ($permissions as $permission) {
            $perExist = Permission::where('name', $permission)->first();
            if (!$perExist) {
                Permission::create(['name' => $permission]);
            }
        }
        return $permissions;
    }

    /**
     * @return mixed
     */
    public function addAdminRoleIfNotExist()
    {
        $roleAdmin = Role::where('name', '=', 'admin')->first();
        if (!$roleAdmin) {
            Role::create(['name' => 'admin']);
            $roleAdmin = Role::where('name', '=', 'admin')->first();
        }
        return $roleAdmin;
    }


    public function addAdminUserIfNotExist()
    {
        $user = User::where('email', config('blog.admin_mail'))->first();
        if (!$user) {
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
    }
}
