<?php

use Illuminate\Database\Seeder;
use Delatbabel\SiteConfig\Models\Config as ConfigModel;

class ContactConfigSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Base configuration data
        ConfigModel::create([
            'group'         => 'config',
            'key'           => 'geocode_api_key',
            'value'         => 'GET-YOUR-OWN-API-KEY',
            'type'          => 'string',
        ]);
    }
}
