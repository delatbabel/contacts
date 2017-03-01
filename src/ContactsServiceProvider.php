<?php
/**
 * Class ContactsServiceProvider
 *
 * @author Del
 */
namespace Delatbabel\Contacts;

use Delatbabel\Applog\DebugServiceProvider;
use Delatbabel\Keylists\KeylistsServiceProvider;
use Delatbabel\NestedCategories\NestedCategoriesServiceProvider;
use Delatbabel\SiteConfig\SiteConfigServiceProvider;
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
            __DIR__ . '/../database/migrations' => database_path() . '/migrations'
        ], 'migrations');
        $this->publishes([
            __DIR__ . '/../database/seeds' => database_path() . '/seeds'
        ], 'seeds');
        $this->publishes([
            __DIR__ . '/../config' => config_path()
        ], 'config');
        // TODO: Instead of publishing the views, load them up into the database using a seeder.
        $this->publishes([
            __DIR__ . '/../resources/views' => base_path('resources/views')
        ], 'views');

        // Register other providers required by this provider, which saves the caller
        // from having to register them each individually.
        $this->app->register(DebugServiceProvider::class);
        $this->app->register(NestedCategoriesServiceProvider::class);
        $this->app->register(KeylistsServiceProvider::class);
        $this->app->register(SiteConfigServiceProvider::class);
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
