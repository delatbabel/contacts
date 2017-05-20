<?php

namespace Delatbabel\Contacts\Helpers;

class ContactHelper {
    public static function getContactTypes($query) {
        $query->whereIn(
            'id', array_keys(\Delatbabel\Contacts\Models\Contact::getContactTypes())
        );
    }
}