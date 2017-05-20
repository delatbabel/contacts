<?php

namespace Delatbabel\Contacts\Helpers;

class CompanyHelper {
    public static function getCompanyTypes($query) {
        $query->whereIn(
            'id', array_keys(\Delatbabel\Contacts\Models\Company::getCompanyTypes())
        );
    }
}