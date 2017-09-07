<?php

namespace Delatbabel\Contacts\Models;

use Carbon\Carbon;
use Delatbabel\Applog\Models\Auditable;
use Delatbabel\Fluents\Fluents;
use Delatbabel\NestedCategories\Models\Category;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Fluent;
use Illuminate\Support\Str;

/**
 * Company Model
 *
 * Contains companies, which may have many contacts and addresses.
 */
class Company extends Model
{
    use SoftDeletes, Fluents, Auditable;

    /** @var array */
    protected $guarded = ['id'];

    protected $casts = [
        'extended_data'         => 'array',
        'current_project_list'  => 'array',
        'past_project_list'     => 'array',
    ];

    /**
     * Many:Many relationship with Address
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function addresses()
    {
        return $this->belongsToMany('Delatbabel\Contacts\Models\Address')
            ->withPivot(['address_type', 'status', 'start_date', 'end_date']);
    }

    /**
     * Many:Many relationship with Category
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo('Delatbabel\NestedCategories\Models\Category');
    }

    /**
     * Many:Many relationship with Category
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function categories()
    {
        return $this->belongsToMany('Delatbabel\NestedCategories\Models\Category');
    }

    /**
     * 1:Many relationship with Contact
     *
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function contacts()
    {
        return $this->hasMany('Delatbabel\Contacts\Models\Contact');
    }

    /**
     * Get the current address for the company.
     *
     * @param array $addressTypes
     * @return Address|null
     */
    public function getCurrentAddress($addressTypes = null)
    {
        // Provide some sensible default for addressTypes
        if (empty($addressTypes)) {
            $addressTypes = ['head-office', 'office', 'contact', 'branch-office', 'billing', 'shipping'];
        }

        // Cycle through the address types until we get a hit
        foreach ($addressTypes as $addressType) {
            $address = $this->addresses()
                ->wherePivot('address_type', '=', $addressType)
                ->wherePivot('status', '=', 'current')
                ->first();
            if (! empty($address)) {
                return $address;
            }
        }

        // No hits, return null
        return null;
    }

    /**
     * Set the current address for the company
     *
     * This sets the current address for the company to be $address_id and expires
     * any previous address of that same type.
     *
     * @param        $address_id
     * @param string $addressType
     * @return $this
     */
    public function setCurrentAddress($address_id, $addressType='head-office')
    {
        $current_address = $this->getCurrentAddress([$addressType]);

        // If there is a current address then we may need to expire it.
        if (! empty($current_address)) {
            // If this is already the current address, do nothing and return.
            if ($current_address->id == $address_id) {
                return $this;
            }

            // Set the old address to be previous
            $this->addresses()->updateExistingPivot($current_address->id, [
                'status'    => 'previous',
                'end_date'  => Carbon::yesterday(),
            ]);
        }

        // Make this the current address
        $this->addresses()->attach($address_id, [
            'address_type'  => $addressType,
            'status'        => 'current',
            'start_date'    => Carbon::today(),
        ]);

        return $this;
    }

    /**
     * Add a current address for the company
     *
     * This sets the current address for the company to be $address_id but does not
     * expire any previous address of that same type.
     *
     * @param        $address_id
     * @param string $addressType
     * @return $this
     */
    public function addCurrentAddress($address_id, $addressType='head-office')
    {
        $current_address = $this->getCurrentAddress([$addressType]);

        // If this is already the current address, do nothing and return.
        if (! empty($current_address) && ($current_address->id == $address_id)) {
            return $this;
        }

        // Make this the current address
        $this->addresses()->attach($address_id, [
            'address_type'  => $addressType,
            'status'        => 'current',
            'start_date'    => Carbon::today(),
        ]);

        return $this;
    }

    /**
     * Return the invoice name and email address.
     *
     * Due to some confusion as to which email address and name to use for sending invoices,
     * this function returns a fluent with the attributes name and email for the correct
     * address to send invoices to.  It uses the invoice_email as a priority, then the
     * accounts_email, then the name and email address of the main contact of the company.
     *
     * @return Fluent|null
     */
    public function getInvoiceDetails()
    {
        if (! empty($this->invoice_email)) {
            return new Fluent([
                'name'  => $this->company_name,
                'email' => $this->invoice_email
            ]);
        }

        if (! empty($this->accounts_email)) {
            return new Fluent([
                'name'  => $this->company_name,
                'email' => $this->accounts_email
            ]);
        }

        /** @var Category $mainContactCategory */
        $mainContactCategory = Category::where('description', '=', 'Contact Types > Main')->first();

        /** @var Builder $contact_query */
        $contact_query = Contact::where('company_id', '=', $this->id);
        if (! empty($mainContactCategory)) {
            $contact_query->where('category_id', '=', $mainContactCategory->id);
        }

        /** @var Contact $contact */
        $contact = $contact_query->first();
        if (empty($contact)) {
            return null;
        }

        return new Fluent([
            'name'  => $contact->full_name,
            'email' => $contact->email,
        ]);
    }

    /**
     * Get all of the company types (categories).
     *
     * Returns a id => value array, e.g.
     * 31 => Customer
     * Suitable for use in pull-down lists, and for storage as category_id
     * in the foreign key field in the pivot tables.
     *
     * @return array
     */
    public static function getCompanyTypes()
    {
        $categories = Category::where('slug', '=', 'company-types')
            ->first()
            ->getLeaves();
        /** @var array $result */
        $result = [];

        /** @var Category $category */
        foreach ($categories as $category) {
            $result[$category->id] = $category->name;
        }

        return $result;
    }

    //
    // Social Media Links
    //
    // Format the social media links so that they are usable as clickable links
    //

    /**
     * Get the facebook link URL
     *
     * @return mixed|string in the form https://www.facebook.com/name
     */
    public function getFacebookLinkAttribute()
    {
        if (Str::is('http*', $this->facebook)) {
            return $this->facebook;
        }

        if (Str::is('*facebook.com*', $this->facebook)) {
            return 'https://' . $this->facebook;
        }

        return 'https://www.facebook.com/' . $this->facebook;
    }

    /**
     * Get the LinkedIn link URL
     *
     * @return mixed|string in the form https://www.linkedin.com/in/name
     */
    public function getLinkedinLinkAttribute()
    {
        if (Str::is('http*', $this->linkedin)) {
            return $this->linkedin;
        }

        if (Str::is('*linkedin.com*', $this->linkedin)) {
            return 'https://' . $this->linkedin;
        }

        return 'https://www.linkedin.com/in/' . $this->linkedin;
    }

    /**
     * Get the instagram link URL
     *
     * @return mixed|string in the form https://www.instagram.com/name
     */
    public function getInstagramLinkAttribute()
    {
        if (Str::is('http*', $this->instagram)) {
            return $this->instagram;
        }

        if (Str::is('*instagram.com*', $this->instagram)) {
            return 'https://' . $this->instagram;
        }

        return 'https://www.instagram.com/' . $this->instagram;
    }
}
