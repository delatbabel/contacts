<?php
/**
 * Class Geocode
 *
 * @author del
 */

namespace Delatbabel\Contacts\Commands;

use Delatbabel\Contacts\Models\Address;
use Illuminate\Console\Command;
use Log;

/**
 * Class Geocode
 *
 * This artisan command geocodes addresses.
 *
 * Example
 *
 * <code>
 * php artisan address:geocode
 * </code>
 */
class Geocode extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'address:geocode';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Geocode a batch of addresses';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // Get my process ID
        $mypid = getmypid();

        if (empty($mypid)) {
            Log::error(__CLASS__ . ':' . __TRAIT__ . ':' . __FILE__ . ':' . __LINE__ . ':' . __FUNCTION__ . ':' .
                "Oops, I don't appear to have a process ID");
            exit(1);
        }
        Log::debug(__CLASS__ . ':' . __TRAIT__ . ':' . __FILE__ . ':' . __LINE__ . ':' . __FUNCTION__ . ':' .
            "My process ID is $mypid");

        // Process campaign messages.
        $count = Address::get_count();
        Log::debug(__CLASS__ . ':' . __TRAIT__ . ':' . __FILE__ . ':' . __LINE__ . ':' . __FUNCTION__ . ':' .
            "There are $count addresses pending geocoding.");

        if ($count == 0) {
            exit(0);
        }

        $count = Address::claim($mypid);
        Log::debug(__CLASS__ . ':' . __TRAIT__ . ':' . __FILE__ . ':' . __LINE__ . ':' . __FUNCTION__ . ':' .
            "I just claimed $count addresses.");

        if ($count == 0) {
            exit(0);
        }

        $count = Address::process_claim($mypid);
        Log::debug(__CLASS__ . ':' . __TRAIT__ . ':' . __FILE__ . ':' . __LINE__ . ':' . __FUNCTION__ . ':' .
            "I just processed $count addresses from my claim.");
    }
}
