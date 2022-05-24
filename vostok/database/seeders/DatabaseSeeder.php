<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            // StationPartTwoSeeder::class,
            RolesTableSeeder::class,
            PermissionsTableSeeder::class,
            ConnectRelationshipsSeeder::class,
            ProjectsTableSeeder::class,
            WorksTableSeeder::class,
            PositionsTableSeeder::class,
            TypesTableSeeder::class,
            StatusesTableSeeder::class,
            DivisionsTableSeeder::class,
            AreasTableSeeder::class,
            StatesTableSeeder::class,
            ProgressTypesTableSeeder::class,
            ProgressTableSeeder::class,
            ActivitiesTableSeeder::class,
            UsersTableSeeder::class,
            RoleUserTableSeeder::class,
            UserStatusesTableSeeder::class,
            StationTypeSeeder::class,
            StocktakingSeeder::class,
            StationsTableSeeder::class,
            SensorSeeder::class,
            GroupSeeder::class,
            BatterySeeder::class,
            InventoriesTableSeeder::class,
            AddressesTableSeeder::class,
            VehiclesTableSeeder::class,
            ConsumablesTableSeeder::class,
            PlacesTableSeeder::class,
            DocumentsSeeder::class,
            StepsTableSeeder::class,
            StepsProgressTableSeeder::class,
            VehicleTypeSeeder::class,
        ]);
        if (app()->isLocal()) {
            $this->call([
                ApplicationsTableSeeder::class,
                ApplicationUserTableSeeder::class,
                ApplicationAcceptsTableSeeder::class,
                ApplicationProgressTableSeeder::class,
                RoutesTableSeeder::class,
            ]);
        }
        Artisan::call('passport:install');
    }
}
