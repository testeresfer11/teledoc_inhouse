<?php

return [

    "ERROR" => [
        "AUTHORIZATION"     => "Opps! You do not have permission to access.",
        "ACCOUNT_ISSUE"     => "Opps! Your account is not verified.Please check your email.",
        "INVALID_CREDENTIAL"=> "The entered credentials is incorrect.",
        "NOT_FOUND"         => "not found!",
        "SOMETHING_WRONG"   => "Opps! Something went wrong.",
        "TOKEN_EXPIRED"     => "Opps! Token Expired",
        "DELETED_ACCOUNT"   => "Your account is temporarily deleted . Please contact with Admin.",
        "NO_CARDS"          =>"No Cards Available.",
    ],
    "SUCCESS"   => [
        "UPDATE_DONE"       => "has been updated successfully.",
        "ADD_DONE"          => "has been added successfully.",
        "CREATE_DONE"       => "has been created successfully.",
        "CHANGED_DONE"      => "has been changed successfully.",
        "DELETE_DONE"       => "has been deleted successfully.",
        "FETCH_DONE"        => "fetched successfully.",
        "VERIFY_SEND"       => "has been created successfully.Please check your email and verify email address",
        "VERIFY_LOGIN"      => "has been not verified. Please check your email and verify email address",
        "VERIFY_DONE"       => "has been verified successfully.",
        "LOGIN"             => "Login successfully.",
        "SENT_DONE"         => "has been sent successfully.",
        "LOGOUT_DONE"       => "Logged out successfully.",
        "DONE"              => "has been done successfully.",
        "RESTORE_DONE"      => "has been restored successfully."
    ],
    "ROLES"     => [
        "ADMIN"     => "admin",
        "USER"      => "user",
        "DOCTOR"    => "doctor",
        "PATIENT"   => "patient",
    ],
    "APP_NAME"          => "TELEDOC",

    "COMPANYNAME"       => env('APP_NAME','TELEDOC'),
    "encryptionMethod"  => env('ENC_DEC_METHOD',''),
    "secrect"           => env('ENC_DEC_SECRET',''),
    "STRIPE_KEY"        => env('STRIPE_KEY',''),
    "STRIPE_SECRET"     => env('STRIPE_SECRET',''),
];
