<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use jeremykenedy\LaravelRoles\Models\Permission;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /*
         * Permission Types
         *
         */
        $Permissionitems = [
            [
                'name' => 'Can view index Users',
                'slug' => 'index.users',
                'description' => 'Can view index users',
                'model' => 'Permission',
            ],
            [
                'name' => 'Can View Users',
                'slug' => 'view.users',
                'description' => 'Can view users',
                'model' => 'Permission',
            ],
            [
                'name' => 'Can Create Users',
                'slug' => 'create.users',
                'description' => 'Can create new users',
                'model' => 'Permission',
            ],
            [
                'name' => 'Can Edit Users',
                'slug' => 'edit.users',
                'description' => 'Can edit users',
                'model' => 'Permission',
            ],
            [
                'name' => 'Can Delete Users',
                'slug' => 'delete.users',
                'description' => 'Can delete users',
                'model' => 'Permission',
            ],
            [
                'name' => 'Can accept applications',
                'slug' => 'edit.accept.applications',
                'description' => 'Can accept applications',
                'model' => 'Permission',
            ],
            [
                'name' => 'Can accept applications',
                'slug' => 'accept.applications',
                'description' => 'Can accept applications',
                'model' => 'Permission',
            ],
            [
                'name' => 'Can view applications by division',
                'slug' => 'division.applications',
                'description' => 'Can accept applications',
                'model' => 'Permission',
            ],
            [
                'name' => 'Can view index applications',
                'slug' => 'index.applications',
                'description' => 'Can view index applications',
                'model' => 'Permission',
            ],
            [
                'name' => 'Can View applications',
                'slug' => 'view.applications',
                'description' => 'Can view applications',
                'model' => 'Permission',
            ],
            [
                'name' => 'Can Create applications',
                'slug' => 'create.applications',
                'description' => 'Can create new applications',
                'model' => 'Permission',
            ],
            [
                'name' => 'Can Edit applications',
                'slug' => 'edit.applications',
                'description' => 'Can edit applications',
                'model' => 'Permission',
            ],
            [
                'name' => 'Can Delete applications',
                'slug' => 'delete.applications',
                'description' => 'Can delete applications',
                'model' => 'Permission',
            ],

            [
                'name' => 'Can view stations by division',
                'slug' => 'division.stations',
                'description' => 'Can accept stations',
                'model' => 'Permission',
            ],
            [
                'name' => 'Can view index stations',
                'slug' => 'index.stations',
                'description' => 'Can view index stations',
                'model' => 'Permission',
            ],
            [
                'name' => 'Can View stations',
                'slug' => 'view.stations',
                'description' => 'Can view stations',
                'model' => 'Permission',
            ],
            [
                'name' => 'Can Create stations',
                'slug' => 'create.stations',
                'description' => 'Can create new stations',
                'model' => 'Permission',
            ],
            [
                'name' => 'Can Edit stations',
                'slug' => 'edit.stations',
                'description' => 'Can edit stations',
                'model' => 'Permission',
            ],
            [
                'name' => 'Can Delete stations',
                'slug' => 'delete.stations',
                'description' => 'Can delete stations',
                'model' => 'Permission',
            ],
            [
                'name' => 'Can view index routes',
                'slug' => 'index.routes',
                'description' => 'Can view index routes',
                'model' => 'Permission',
            ],
            [
                'name' => 'Can View routes',
                'slug' => 'view.routes',
                'description' => 'Can view routes',
                'model' => 'Permission',
            ],
            [
                'name' => 'Can Create routes',
                'slug' => 'create.routes',
                'description' => 'Can create new routes',
                'model' => 'Permission',
            ],
            [
                'name' => 'Can Edit routes',
                'slug' => 'edit.routes',
                'description' => 'Can edit routes',
                'model' => 'Permission',
            ],
            [
                'name' => 'Can Delete routes',
                'slug' => 'delete.routes',
                'description' => 'Can delete routes',
                'model' => 'Permission',
            ],
            [
                'name' => 'Can view index inventories',
                'slug' => 'index.inventories',
                'description' => 'Can view index inventories',
                'model' => 'Permission',
            ],
            [
                'name' => 'Can View inventories',
                'slug' => 'view.inventories',
                'description' => 'Can view inventories',
                'model' => 'Permission',
            ],
            [
                'name' => 'Can Create inventories',
                'slug' => 'create.inventories',
                'description' => 'Can create new inventories',
                'model' => 'Permission',
            ],
            [
                'name' => 'Can Edit inventories',
                'slug' => 'edit.inventories',
                'description' => 'Can edit inventories',
                'model' => 'Permission',
            ],
            [
                'name' => 'Can Delete inventories',
                'slug' => 'delete.inventories',
                'description' => 'Can delete inventories',
                'model' => 'Permission',
            ],
            [
                'name' => 'Can send location to route',
                'slug' => 'location.routes',
                'description' => 'Can send location',
                'model' => 'Permission',
            ],
        ];

        /*
         * Add Permission Items
         *
         */
        foreach ($Permissionitems as $Permissionitem) {
            $newPermissionitem = Permission::where('slug', '=', $Permissionitem['slug'])->first();
            if ($newPermissionitem === null) {
                $newPermissionitem = Permission::create([
                    'name' => $Permissionitem['name'],
                    'slug' => $Permissionitem['slug'],
                    'description' => $Permissionitem['description'],
                    'model' => $Permissionitem['model'],
                ]);
            }
        }
    }
}
