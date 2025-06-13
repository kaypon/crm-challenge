<?php

function isValidCustomer($customer) {
    // Only letters and spaces
    if (!preg_match("/^[a-zA-Z\s]+$/", $customer['name'])) return false;

    // Valid email
    if (!filter_var($customer['email'], FILTER_VALIDATE_EMAIL)) return false;

    // Phone: XXX-XXX-XXXX
    if (!preg_match("/^\d{3}-\d{3}-\d{4}$/", $customer['phone_number'])) return false;

    return true;
}

function formatCustomer($customer) {
    $customer['email'] = strtolower($customer['email']);
    return $customer;
}
