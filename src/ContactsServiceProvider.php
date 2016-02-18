<?php
/**
 * Class ContactsServiceProvider
 *
 * @author Del
 */
namespace Delatbabel\Contacts;

use Illuminate\Support\ServiceProvider;

/**
 * Class ContactsServiceProvider
 *
 * Service providers are the central place of all Laravel application bootstrapping.
 * Your own application, as well as all of Laravel's core services are bootstrapped
 * via service providers.
 *
 * @see  Illuminate\Support\ServiceProvider
 * @link http://laravel.com/docs/5.1/providers
 */
class ContactsServiceProvider extends ServiceProvider
{

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../database/migrations' => $this->app->databasePath() . '/migrations'
        ], 'migrations');
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
