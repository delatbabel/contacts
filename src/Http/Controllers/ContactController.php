<?php

namespace Delatbabel\Contacts\Http\Controllers;

use Carbon\Carbon;
use DDPro\Admin\Http\Controllers\AdminModelController;
use DDPro\Admin\Http\ViewComposers\ModelViewComposer;
use Delatbabel\Contacts\Http\Requests\ContactAddressFormRequest;
use Delatbabel\Contacts\Models\Address;
use Delatbabel\Contacts\Models\Contact;
use Delatbabel\Keylists\Models\Keytype;

/**
 * Custom Contact Page
 *      Mange Contacts, Addresses
 *
 * Class ContactController
 * @package Delatbabel\Contacts\Controllers
 */
class ContactController extends AdminModelController
{
    /**
     * Show item for Edit/create
     *
     * * **route method**: GET
     * * **route name**: admin_get_item | admin_new_item
     * * **route URL**: admin/contacts/{id} | admin/{model}/new
     *
     * @param string $modelName
     * @param int    $itemId
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function item($modelName, $itemId = 0)
    {
        $bladeName = 'admin.model.contact.form';
        \View::composer($bladeName, ModelViewComposer::class);

        // Get data from parent
        parent::item($modelName, $itemId);

        // Custom Data
        $arrData                = $this->view->getData();
        // $arrData['addressList'] = Address::lists('formatted_address', 'id')->toArray();

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

        return $this->view = view($bladeName, $arrData);
    }

    /**
     * Save Handle
     *
     * * **route method**: POST
     * * **route name**: admin_save_item
     * * **route URL**: admin/contacts/{id?}/save
     *
     * @param string $modelName
     * @param int    $id
     *
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function save($modelName, $id = null)
    {
        if ($this->request->mode == 'address') {
            /** @var Contact $contact */
            $contact = Contact::findOrFail($id);

            if ($this->request->delete) {

                // Delete Address
                $contact->addresses()->detach($this->request->address_id);
            } elseif ($this->request->expire) {

                // Expire Address
                $contact->addresses()->updateExistingPivot($this->request->address_id, [
                    'status'        => 'previous',
                    'end_date'      => Carbon::yesterday(),
                ]);
            } else {

                // Validate Contact Address
                app(ContactAddressFormRequest::class);

                // Create Address
                $address = app(AddressController::class)->saveAddress($this->request->address_id);

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

            return redirect()->route('admin_get_item', [$modelName, $id])
                ->withInput($this->request->only(['mode']));
        }

        return parent::save($modelName, $id);
    }

    /**
     * Share save contact process for another page (Company, ...)
     *
     * @param $id
     * @return Contact
     */
    public function saveContact($id)
    {
        $model = $id ? Contact::findOrFail($id) : new Contact();
        $model->fill($this->request->only([
            'first_name',
            'last_name',
            'email',
            'category_id',
            'position',
            'phone',
            'mobile',
            'fax',
            'timezone',
            'notes',
            'extended_data',
        ]));
        $model->save();

        return $model;
    }
}
