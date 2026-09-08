<?php

return [

    /*
    |-----------------------------------------------------------------------------
    | Admin User Name
    |-----------------------------------------------------------------------------
    |
    | This value is the name of the default admin user. If this value is not empty
    | and the email and password values are not empty, the admin user will be
    | created or updated when you run the artisan command to seed the database.
    |
    */
    'name' => env('ADMIN_NAME'),

    /*
    |------------------------------------------------------------------------------
    | Admin User Email
    |------------------------------------------------------------------------------
    |
    | This value is the email of the default admin user. If this value is not empty
    | and the name and password values are not empty, the admin user will be
    | created or updated when you run the artisan command to seed the database.
    |
    */
    'email' => env('ADMIN_EMAIL'),

    /*
    |---------------------------------------------------------------------------------
    | Admin User Password
    |---------------------------------------------------------------------------------
    |
    | This value is the password of the default admin user. If this value is not empty
    | and the name and email values are not empty, the admin user will be created or
    | updated when you run the artisan command to seed the database.
    |
    */
    'password' => env('ADMIN_PASSWORD'),
];
