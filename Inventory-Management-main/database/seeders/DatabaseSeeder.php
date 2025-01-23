<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run(): void
    {
        $this->call(CreateAdminUserSeeder::class);
        $this->call(CreateCdtCode:: class);
        $this->call(CreateBrands:: class);
        $this->call(CreateItems:: class);
        $this->call(CreateProcedureTemplate:: class);
        $this->call(CreateProcedureTemplateItem:: class);
        $this->call(CreateInventory:: class);
    }
}
