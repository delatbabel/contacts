<?php

namespace Delatbabel\Contacts\Http\Controllers;

use Carbon\Carbon;
use DDPro\Admin\Http\Controllers\AdminModelController;
use DDPro\Admin\Http\ViewComposers\ModelViewComposer;
use Delatbabel\Contacts\Http\Requests\ContactAddressFormRequest;
use Delatbabel\Contacts\Models\Address;
use Delatbabel\Contacts\Models\Contact;
use Delatbabel\Keylists\Models\Keytype;
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

        $contact = null;
        if (Request::has('contact_id')) {
            $contact = Contact::where('company_id', $itemId)
                ->where('id', Request::get('contact_id'))
                ->firstOrFail();
            $mode = 'contact';
        }
        $arrData['contact'] = $contact;

        // Keep current mode
        $arrData['mode'] = $mode;

        return $this->view = view($bladeName, $arrData);
    }
}
