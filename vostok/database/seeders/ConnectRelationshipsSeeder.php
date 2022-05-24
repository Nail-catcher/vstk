<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use jeremykenedy\LaravelRoles\Models\Permission;
use jeremykenedy\LaravelRoles\Models\Role;

class ConnectRelationshipsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /**
         * Get Available Permissions.
         */
        $permissions = Permission::where('slug', 'not like', "division.%")->get();

        /**
         * Attach Permissions to Roles.
         */
        $roleAdmin = Role::where('slug', '=', 'admin')->first();
        foreach ($permissions as $permission) {
            $roleAdmin->attachPermission($permission);
        }

        $permissions = Permission::whereIn('slug', [
            'index.users',
            'view.users',
            'index.applications',
            'view.applications',
            'create.applications',
            'edit.applications',
            'delete.applications',
            'index.stations',
            'view.stations',
            'create.stations',
            'edit.stations',
            'delete.stations',
            'index.routes',
            'view.routes',
            'create.routes',
            'edit.routes',
            'delete.routes',
        ])->get();
        $roleDispatcher = Role::where('slug', '=', 'dispatcher')->first();
        foreach ($permissions as $permission) {
            $roleDispatcher->attachPermission($permission);
        }

        $permissions = Permission::whereIn('slug', [
            'index.users',
            'view.users',
            'edit.accept.applications',
            'division.applications',
            'view.applications',
            'create.applications',
            'edit.applications',
            'delete.applications',
            'division.stations',
            'view.stations',
            'create.stations',
            'edit.stations',
            'delete.stations',
            'division.routes',
            'view.routes',
        ])->get();
        $roleHeadDivision = Role::where('slug', '=', 'head.division')->first();
        foreach ($permissions as $permission) {
            $roleHeadDivision->attachPermission($permission);
        }
        $permissions = Permission::whereIn('slug', [
            'index.users',
            'view.users',
            'division.applications',
            'accept.applications',
            'view.applications',
            'create.applications',
            'index.stations',
            'view.stations',
            'create.stations',
            'edit.stations',
            'delete.stations',
            'division.routes',
            'view.routes',
            'create.routes',
            'edit.routes',
            'delete.routes',
            'index.inventories',
            'view.inventories',
            'create.inventories',
            'location.routes'
        ])->get();
        $engineer = Role::where('slug', '=', 'engineer')->first();
        foreach ($permissions as $permission) {
            $engineer->attachPermission($permission);
        }

    }
}
