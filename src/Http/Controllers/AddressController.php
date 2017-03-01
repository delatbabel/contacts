<?php

namespace Delatbabel\Contacts\Http\Controllers;

use Delatbabel\Contacts\Http\Requests\AddressFormRequest;
use DDPro\Admin\Http\Controllers\AdminModelController;
use DDPro\Admin\Http\ViewComposers\ModelViewComposer;
use Delatbabel\Contacts\Models\Address;
use Delatbabel\Keylists\Models\Keytype;

/**
 * Manage Address information
 *
 * Class AddressController
 * @package Delatbabel\Contacts\Http\Controllers;
 */
class AddressController extends AdminModelController
{
    /**
     * Show item for Edit/create
     *
     * * **route method**: GET
     * * **route name**: admin_get_item | admin_new_item
     * * **route URL**: admin/address/{id} | admin/{model}/new
     *
     * @param string $modelName
     * @param int    $itemId
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function item($modelName, $itemId = 0)
    {
        $bladeName = 'admin.model.address.form';
        \View::composer($bladeName, ModelViewComposer::class);

        // Get data from parent
        parent::item($modelName, $itemId);

        // Custom Data
        $arrData = $this->view->getData();

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
     * * **route URL**: admin/address/{id?}/save
     *
     * @param string $modelName
     * @param int    $id
     *
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function save($modelName, $id = null)
    {
        $this->request = app(AddressFormRequest::class);
        $this->saveAddress($id);

        return redirect()->route('admin_index', [$modelName]);
    }

    /**
     * Share save address process for another page (Contacts, ...)
     *
     * @param $id
     * @return Address
     */
    public function saveAddress($id)
    {
        $model = $id ? Address::findOrFail($id) : new Address();
        $model->fill($this->request->only([
            'street',
            'suburb',
            'city',
            'state_name',
            'state_code',
            'postal_code',
            'country_name',
            'country_code',
            'contact_name',
            'contact_phone',
        ]));
        $model->geocode();
        $model->save();

        return $model;
    }
}
