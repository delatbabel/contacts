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
[Top 10 Open Source CRM Systems](http://www.crmsearch.com/top-10-open-source-crm-systems.php])
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

## Incorporate and Run the Migrations

Finally, incorporate and run the migration scripts to create the database tables as follows:

```php
php artisan vendor:publish --provider='Delatbabel\Contacts\ContactsServiceProvider' --force
php artisan migrate
```

# Example

TODO

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

## Geocoding

See the
[Geocoding Intro on Google](https://developers.google.com/maps/documentation/geocoding/intro)
for more information.

Geocoding is mostly implemented.  Here is a sample URL for the geocoder:

https://maps.google.com/maps/api/geocode/json?address=10+Downing+Street,London,United+Kingdom

The geocoder works within the Address model class to automatically use the Google API
to get the components of the address from a partial address.

You can disable the geocoder by setting the config variable geocode.enable to false.

You can set up the geocoder to use an API key (which means you can go over the limit of
2500 requests per day) by setting geocode.use_api_key to true, and setting geocode.api_key
to the API key.  See the ContactConfigSeeder for a seeder that sets these config variables
in the database (in the configs table).

Usage limits:

* https://developers.google.com/maps/documentation/geocoding/usage-limits

API Keys:

* https://developers.google.com/maps/documentation/geocoding/get-api-key
* https://support.google.com/cloud/answer/6310037

Geocoding is free up to 2500 requests per day, if you need to go over that limit per server
IP address then you need to obtain an API key.

# Architecture

This has been ported across from an old Laravel 3 package that handled contact management
inside an e-commerce system of sorts.

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
