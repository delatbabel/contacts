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
use App;

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
        $this->publishes([
            __DIR__ . '/../database/seeds' => $this->app->databasePath() . '/seeds'
        ], 'seeds');

        // Register other providers required by this provider, which saves the caller
        // from having to register them each individually.
        App::register(DebugServiceProvider::class);
        App::register(NestedCategoriesServiceProvider::class);
        App::register(KeylistsServiceProvider::class);
        App::register(SiteConfigServiceProvider::class);
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
