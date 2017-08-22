<?php

namespace Delatbabel\Contacts\Http\Controllers;

use Carbon\Carbon;
use DDPro\Admin\Http\Controllers\AdminModelController;
use DDPro\Admin\Http\ViewComposers\ModelViewComposer;
use Delatbabel\Contacts\Http\Requests\CompanyContactFormRequest;
use Delatbabel\Contacts\Http\Requests\CompanyAddressFormRequest;
use Delatbabel\Contacts\Http\Requests\ContactAddressFormRequest;
use Delatbabel\Contacts\Models\Address;
use Delatbabel\Contacts\Models\Contact;
use Delatbabel\Contacts\Models\Company;
use Delatbabel\Keylists\Models\Keytype;
use Delatbabel\NestedCategories\Models\Category;
use Illuminate\Support\Facades\Request;

/**
 * Custom Company Page
 *      Manage Companies
 *
 * Class CompanyController
 * @package Delatbabel\Contacts\Controllers
 */
class CompanyController extends AdminModelController
{
    /**
     * Show item for Edit/create
     *
     * * **route method**: GET
     * * **route name**: admin_get_item | admin_new_item
     * * **route URL**: admin/companies/{id} | admin/companies/new
     *
     * @param string $modelName
     * @param int    $itemId
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function item($modelName, $itemId = 0)
    {
        $bladeName = 'admin.model.company.form';
        \View::composer($bladeName, ModelViewComposer::class);

        // Get data from parent
        parent::item($modelName, $itemId);

        // Custom Data
        $arrData = $this->view->getData();
        $mode = null;

        // Fetch the Address Type list.
        $arrData['addressTypeList'] = Address::getTypes();

        // Fetch the Status list.
        $arrData['addressStatusList'] = Address::getStatuses();

        // Fetch the country list.
        $arrData['countryList'] = Keytype::where('name', 'countries')
            ->firstOrFail()
            ->keyvalues()->orderBy('keyvalue')->get()
            ->lists('keyname', 'keyvalue')
            ->toArray();

        // Fetch the contact category list
        $arrData['contactCategories'] = Category::where('slug', 'contact-types')->first()->getDescendants(1)->lists('name', 'id')->all();

        $companyAddress = null;
        $contact = null;
        $contactAddress = null;

        if (Request::has('company_address_id')) {
            // Company address
            $companyAddress = $arrData['model']->addresses()->findOrFail(Request::get('company_address_id'));
            $mode = 'company_address';
        } elseif (Request::has('contact_id')) {
            $contact = $arrData['model']->contacts()->findOrFail(Request::get('contact_id'));
            $mode = 'contact';
            // Contact address
            if (Request::has('contact_address_id')) {
                $contactAddress = $contact->addresses()->findOrFail(Request::get('contact_address_id'));
                $mode = 'contact_address';
            }
        }

        // Pass data to view
        $arrData['contact'] = $contact;
        $arrData['contactAddress'] = $contactAddress;
        $arrData['companyAddress'] = $companyAddress;

        // Keep current mode
        $arrData['mode'] = $mode;

        return $this->view = view($bladeName, $arrData);
    }

    /**
     * Save Handle
     *
     * * **route method**: POST
     * * **route name**: admin_save_item
     * * **route URL**: admin/companies/{id?}/save
     *
     * @param string $modelName
     * @param int    $id
     *
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function save($modelName, $id = null)
    {
        if ($this->request->mode) {
            /** @var Company $company */
            $company = Company::findOrFail($id);
            switch ($this->request->mode) {
                case 'company_address':
                    if ($this->request->delete) {
                        // Delete Address
                        $company->addresses()->detach($this->request->company_address_id);
                    } elseif ($this->request->expire) {
                        // Expire Address
                        $company->addresses()->updateExistingPivot($this->request->company_address_id, [
                            'status'        => 'previous',
                            'end_date'      => Carbon::yesterday(),
                        ]);
                    } else {
                        // Validate Company Address
                        app(CompanyAddressFormRequest::class);

                        // Create Address
                        $address = app(AddressController::class)->saveAddress($this->request->company_address_id);

                        // Update/Create Address
                        $company->addresses()->sync([
                            $address->id => $this->request->only([
                                'address_type',
                                'status',
                                'start_date',
                                'end_date',
                            ]),
                        ], false);
                    }
                    break;
                case 'contact_address':
                    /** @var Contact $contact */
                    $contact = Contact::findOrFail($id);
                    if ($this->request->delete) {
                        // Delete Address
                        $contact->addresses()->detach($this->request->contact_address_id);
                    } elseif ($this->request->expire) {
                        // Expire Address
                        $contact->addresses()->updateExistingPivot($this->request->contact_address_id, [
                            'status'        => 'previous',
                            'end_date'      => Carbon::yesterday(),
                        ]);
                    } else {
                        // Validate Contact Address
                        app(ContactAddressFormRequest::class);

                        // Create Address
                        $address = app(AddressController::class)->saveAddress($this->request->contact_address_id);

                        // Update/Create Address
                        $contact->addresses()->sync([
                            $address->id => $this->request->only([
                                'address_type',
                                'status',
                                'start_date',
                                'end_date',
                            ]),
                        ], false);
                    }
                    break;
                case 'contact':
                    if ($this->request->delete) {
                        // Delete Contact
                        $company->contacts()->detach($this->request->contact_id);
                    } else {
                        // Validate Contact
                        app(CompanyContactFormRequest::class);

                        // Create Contact
                        app(ContactController::class)->saveContact($this->request->contact_id);
                    }

                    break;
            }
            // Redirect back
            return redirect()->back()->withInput($this->request->only(['mode']));
        } else {
            return parent::save($modelName, $id);
        }
    }
}
