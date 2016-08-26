<?php

class ContactSeeder extends \Illuminate\Database\Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(ContactConfigSeeder::class);
        $this->call(ContactCategoriesSeeder::class);
        $this->call(ContactKeyListsSeeder::class);

        // Test data only
        if (App::environment('local', 'staging', 'testing', 'test')) {
            $this->call(ContactSampleSeeder::class);
        }
    }
}
