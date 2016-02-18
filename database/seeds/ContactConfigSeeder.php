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
        SiteConfigSaver::set('contacts.geocode.enable', true);
        SiteConfigSaver::set('contacts.geocode.api_key', 'GET-YOUR-OWN-API-KEY');
        SiteConfigSaver::set('contacts.geocode.use_api_key', false);
        SiteConfigSaver::set('contacts.geocode.url', 'https://maps.google.com/maps/api/geocode/json');
        SiteConfigSaver::set('contacts.geocode.method', 'GET');
    }
}
