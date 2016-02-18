<?php

use Illuminate\Database\Seeder;
use Delatbabel\Keylists\Models\Keytype;
use Delatbabel\Keylists\Models\Keyvalue;

class ContactKeyListsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        // Create all of the address types
        //
        /** @var Keytype $keytype */
        $keytype = Keytype::create([
            'name'          => 'address-types',
            'description'   => 'Address Types',
        ]);

        Keyvalue::create([
            'keytype_id'    => $keytype->id,
            'keyvalue'      => 'billing',
            'keyname'       => 'Billing Address',
        ]);
        Keyvalue::create([
            'keytype_id'    => $keytype->id,
            'keyvalue'      => 'shipping',
            'keyname'       => 'Shipping Address',
        ]);
        Keyvalue::create([
            'keytype_id'    => $keytype->id,
            'keyvalue'      => 'contact',
            'keyname'       => 'Contact Address',
        ]);
        Keyvalue::create([
            'keytype_id'    => $keytype->id,
            'keyvalue'      => 'office',
            'keyname'       => 'Office Address',
        ]);
        Keyvalue::create([
            'keytype_id'    => $keytype->id,
            'keyvalue'      => 'home',
            'keyname'       => 'Home Address',
        ]);
        Keyvalue::create([
            'keytype_id'    => $keytype->id,
            'keyvalue'      => 'head-office',
            'keyname'       => 'Head Office Address',
        ]);
        Keyvalue::create([
            'keytype_id'    => $keytype->id,
            'keyvalue'      => 'branch-office',
            'keyname'       => 'Branch Office Address',
        ]);

        //
        // Create all of the address statuses
        //
        /** @var Keytype $keytype */
        $keytype = Keytype::create([
            'name'          => 'address-statuses',
            'description'   => 'Address Statuses',
        ]);

        Keyvalue::create([
            'keytype_id'    => $keytype->id,
            'keyvalue'      => 'current',
            'keyname'       => 'Current Address',
        ]);
        Keyvalue::create([
            'keytype_id'    => $keytype->id,
            'keyvalue'      => 'previous',
            'keyname'       => 'Previous Address',
        ]);
        Keyvalue::create([
            'keytype_id'    => $keytype->id,
            'keyvalue'      => 'future',
            'keyname'       => 'Future Address',
        ]);
    }
}
