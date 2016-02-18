<?php

use Illuminate\Database\Seeder;
use Delatbabel\SiteConfig\Facades\SiteConfigSaver;

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
        SiteConfigSaver::set('geocode.api_key', 'GET-YOUR-OWN-API-KEY');
        SiteConfigSaver::set('geocode.url', 'https://maps.google.com/maps/api/geocode/json');
        SiteConfigSaver::set('geocode.method', 'GET');
    }
}
