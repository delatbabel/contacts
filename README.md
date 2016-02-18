# contacts

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
php artisan vendor:publish --tag=migrations --force
php artisan migrate
```

# Example

TODO

# Architecture

This has been ported across from an old Laravel 3 package that handled contact management
inside an e-commerce system of sorts.
