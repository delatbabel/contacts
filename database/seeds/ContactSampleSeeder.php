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

        // Find category
        $contact_lead = Category::where('slug', '=', 'lead')->first();

        $company = Company::create([
            'company_name'  => "Prime Minister's Office",
            'contact_name'  => 'David Cameron',
            'website'       => 'https://en.wikipedia.org/wiki/Prime_Minister_of_the_United_Kingdom',
            'category_id'   => $contact_lead->id,
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
            'category_id'   => $contact_lead->id,
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

        // Something to demonstrate name sorting
        $address_sa = Address::create([
            'street'        => '163 Uys Krige Drive',
            'suburb'        => 'Plattekloof',
            'city'          => 'Cape Town',
            'country_name'  => 'South Africa',
        ]);

        $company_sa = Company::create([
            'company_name'  => 'South African Rugby Union',
            'website'       => 'http://www.sarugby.net/',
            'category_id'   => $contact_lead->id,
        ]);

        $contact_sa = Contact::create([
            'first_name'    => 'Joost',
            'last_name'     => 'van der Westhuizen',
            'sort_order'    => 'nl',
            'company_id'    => $company_sa->id,
            'position'      => 'Scrum Half',
            'category_id'   => $contact_lead->id,
        ]);

        $company_sa->addresses()->attach($address_sa->id);

        $contact_sa->addresses()->attach($address_sa->id, [
            'address_type'  => 'office',
            'status'        => 'previous',
            'start_date'    => '1993-02-11',
            'end_date'      => '2003-09-09',
        ]);
    }
}
