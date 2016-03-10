# Contacts

A package to do simple contact management and storage for Laravel.

Ideal for use for e-commerce, CRM or other systems where contact management needs to be done.

This is not a full CRM system, but the idea is to be able to synchronise the contact list
with a separate CRM system.

## Goals

Storage of:

* Contacts
* Companies
* Addresses

Interface with external CRM systems. Target systems include anything that provides a reasonable
API, starting with the open source systems. There is a list of
[Top 10 Open Source CRM Systems](http://www.crmsearch.com/top-10-open-source-crm-systems.php)
that we plan to integrate to. 
Other systems that have an API that we plan interfacing to include:

* [SalesForce](http://www.salesforce.com/)
* [Zoho](https://www.zoho.com/)

# Installation

Add these lines to your composer.json file:

```
    "require": {
        "delatbabel/contacts": "~1.0"
    },
```

Once that is done, run the composer update command:

```
    composer update
```

Alternatively just run this:

```
    composer require delatbabel/contacts
```

## Register Service Provider

After composer update completes, add this line to your config/app.php file in the 'providers' array:

```
    Delatbabel\Contacts\ContactsServiceProvider::class,
```

## Incorporate and Run the Migrations and Seeders

Finally, incorporate and run the migration scripts to create and seed the database tables as follows:

```php
php artisan vendor:publish --force
php artisan migrate
php artisan db:seed
```

I have included a ContactSeeder which incorporates seeders for categories, config and keylists in the
correct order.  You can use this or not at your leisure.  To use it, include ContactSeeder into your
normal DatabaseSeeder class or whatever else you use to seed your database.

I have also included a ContactSampleSeeder which will seed the contacts database with a few sample
companies (organisations) and individuals.  You can take a look at this to create your own seeder, or
maybe you want to seed by pulling data from a CSV file or importing from a CRM or something.  It's
up to you.

# Usage Examples

General usage example: TODO, although see the ContactSampleSeeder for simple examples for
creating addresses, companies and contacts.

## Geocoding

See the
[Geocoding Intro on Google](https://developers.google.com/maps/documentation/geocoding/intro)
for more information.

Geocoding is mostly implemented.  Here is a sample URL for the geocoder:

https://maps.google.com/maps/api/geocode/json?address=10+Downing+Street,London,United+Kingdom

The geocoder works within the Address model class to automatically use the Google API
to get the components of the address from a partial address.

You can disable the geocoder by setting the config variable contacts.geocode.enable to false.

You can set up the geocoder to use an API key (which means you can go over the limit of
2500 requests per day) by setting contacts.geocode.use_api_key to true, and setting contacts.geocode.api_key
to the API key.  See the ContactConfigSeeder for a seeder that sets these config variables
in the database (in the configs table).

Usage limits:

* https://developers.google.com/maps/documentation/geocoding/usage-limits

API Keys:

* https://developers.google.com/maps/documentation/geocoding/get-api-key
* https://support.google.com/cloud/answer/6310037

Geocoding is free up to 2500 requests per day, if you need to go over that limit per server
IP address then you need to obtain an API key.

# TODO

## Zoho Integration

Build integraton with Zoho.  This seems to have a simple to use API.

example:

* POST URL https://crm.zoho.com/crm/private/json/Leads/getRecords
* POST DATA authtoken = (authtoken -- get one from Zoho), scope = crmapi
* Responds with a JSON structure -- examine this using postman.

Tasks:

* Build a generic call interface.
* Build a data mapper between the Zoho CRM API fields and our fields.
* Build the service to upload and download each record type.

Read this:

* [Zoho CRM Modules and Fields](https://www.zoho.com/crm/help/api/modules-fields.html) -- note
  that in Zoho they have the concept of "Modules", e.g. Leads, Accounts, Contacts, Potentials, etc
  for different types of contact (this is common in CRM systems) whereas in this package we have
  one contact table with different contact categories.  E.g. in the sample data we set up the UK
  PM Office and David Cameron as "Lead" contact types.  Also Zoho mixes company and contact data,
  whereas we keep it in separate tables.

These links are active when logged into Zoho CRM:

* [List of Leads](https://crm.zoho.com/crm/ShowTab.do?module=Leads)
* [Auth Tokens](https://accounts.zoho.com/u/h#sessions/userauthtoken)
* [Generate Auth Token](https://crm.zoho.com/crm/ShowSetup.do?tab=developerSpace&subTab=api)

## Salesforce.com Integration

* Much the same tasks as above.
* [Force.com REST API](https://developer.salesforce.com/docs/atlas.en-us.api_rest.meta/api_rest/)

## Others

Other integrations will probably happen on demand but the top ones would probably be:

* [SugarCRM](http://www.sugarcrm.com/)
* [vTiger](https://www.vtiger.com/)
* [CiviCRM](https://civicrm.org/)
* [X2CRM](http://www.x2crm.com/) -- created by [John Roberts](https://en.wikipedia.org/wiki/John_Roberts_%28software_entrepreneur%29)
  after he left SugarCRM.

## More Features

Without crossing the line into full CRM, this is what I think we should be implementing:

* Contact, Company and Address deduplication.
* i18n, including better name handling and name sort order generation ("Last, First" or "First Last" or "Last van der, First")
  (in progress).

# Architecture

This has been ported across from an old Laravel 3 package that handled contact management
inside an e-commerce system.  An early idea was to turn this into a fully fledged CRM system,
but there are already several good CRM systems out there and I felt no need to re-invent the
wheel.

However as a basic starting point for any e-commerce site, contact and customer management
is a requirement.  Being able to synchronise data from the e-commerce system to the CRM
system would be an advantage.

## Data Structures

Base Tables:

* addresses
* companies
* contacts
* crms

Relations:

* companies many:many addresses
* contacts many:many addresses
* companies 1:many contacts
* contacts many:many categories (from delatbabel/nestedcategories)
* companies many:many categories

The many:many pivot tables on addresses have start_date and end_date fields so that past and
current addresses can be stored if required.

## Dependencies

These are automatically handled by composer:

* [Applog](https://github.com/delatbabel/applog) for auditing and application logging to the database.
* [NestedCategories](https://github.com/delatbabel/nestedcategories) for contact and company categories.
* [Keylists](https://github.com/delatbabel/keylists) for key/value list storage such as address types and statuses.
* [NestedCategories](https://github.com/delatbabel/nestedcategories) for contact and company categories.
* [SiteConfig](https://github.com/delatbabel/site-config) for database backed configuration, e.g. geolocation keys.
* [Eloquent ORM](https://github.com/illuminate/database) for database access.
