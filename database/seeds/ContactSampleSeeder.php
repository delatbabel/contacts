<?php

use Illuminate\Database\Seeder;
use Delatbabel\Contacts\Models\Address;
use Delatbabel\Contacts\Models\Company;
use Delatbabel\Contacts\Models\Contact;
use Delatbabel\NestedCategories\Models\Category;

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
        $address_pm = Address::create([
            'street'        => '10 Downing Street',
            'city'          => 'London',
            'country_name'  => 'United Kingdom',
        ]);

        $company = Company::create([
            'company_name'  => "Prime Minister's Office",
            'contact_name'  => 'David Cameron',
            'website'       => 'https://en.wikipedia.org/wiki/Prime_Minister_of_the_United_Kingdom',
        ]);

        $contact = Contact::create([
            'first_name'    => 'David',
            'last_name'     => 'Cameron',
            'sort_order'    => 'en',
            'company_id'    => $company->id,
            'position'      => 'Prime Minister',
            'timezone'      => 'Europe/London',
            'dob'           => '1966-10-09',
            'gender'        => 'M',
            'email'         => 'pm@number10.gov.uk',
        ]);

        // Find categories
        $company_lead = Category::where('description', '=', 'Company Types > Lead')->first();
        $contact_lead = Category::where('description', '=', 'Contact Types > Lead')->first();

        // Attachments
        $company->addresses()->attach($address_pm->id, [
            'address_type'  => 'head-office',
            'status'        => 'current',
        ]);
        $company->categories()->attach($company_lead->id);

        $contact->addresses()->attach($address_pm->id, [
            'address_type'  => 'office',
            'status'        => 'current',
            'start_date'    => '2010-05-11',
        ]);
        $contact->categories()->attach($contact_lead->id);
    }
}
