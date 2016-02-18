<?php

use Illuminate\Database\Seeder;
use Delatbabel\Contacts\Models\Address;
use Delatbabel\Contacts\Models\Company;
use Delatbabel\Contacts\Models\Contact;

class ContactSampleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Example address
        /** @var Address $address_pm */
        $address_pm = new Address([
            'street'        => '10 Downing Street',
            'city'          => 'London',
            'postcode'      => 'SW1A 2AB',
            'country_name'  => 'United Kingdom',
        ]);
        $address_pm->geocode();
        $address_pm->save();

        $company = Company::create([
            'company_name'  => "Prime Minister's Office",
            'contact_name'  => 'David Cameron',
            'website'       => 'https://en.wikipedia.org/wiki/Prime_Minister_of_the_United_Kingdom',
        ]);

        $contact = Contact::create([
            'first_name'    => 'David',
            'last_name'     => 'Cameron',
            'company_id'    => $company->id,
            'position'      => 'Prime Minister',
            'timezone'      => 'Europe/London',
            'dob'           => '1966-10-09',
            'gender'        => 'M',
            'email'         => 'pm@number10.gov.uk',
        ]);

        // Attachments
        $company->addresses()->attach($address_pm->id, [
            'address_type'  => 'head-office',
            'status'        => 'current',
        ]);

        $contact->addresses()->attach($address_pm->id, [
            'address_type'  => 'office',
            'status'        => 'current',
            'start_date'    => '2010-05-11',
        ]);
    }
}
