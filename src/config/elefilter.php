<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Main filters directory namespace
    |--------------------------------------------------------------------------
    |
    | Usually you don't have to change the App, but if you want to have a directory inside app folders other than Filters
    | you can set it. This will be the main root of filter classes holder
    |
    */

    'namespace'  => 'App\Filters',

    /*
    |--------------------------------------------------------------------------
    | Main path of filters directory
    |--------------------------------------------------------------------------
    |
    | The path key should be compatible with namespace, If you have changed the namespace
    | be careful to change path according to namespace too
    |
    */

    'path' => 'app/Filters',

    /*
    |--------------------------------------------------------------------------
    | This is for tests
    |--------------------------------------------------------------------------
    |
    | This config added to make the package testable easily.
    | The path you set to base_path method should be compatible with the path config value
    |
    */

    'full_path'  => base_path('app/Filters'), # this makes package to be testable more easily

    /*
    |--------------------------------------------------------------------------
    | Filter class suffix
    |--------------------------------------------------------------------------
    |
    | When you create a filter class with name of Status for example the suffic
    | will be added automaticaly to end of it, you can change it to whatever you want.
    | If you dont want suffix, just leave it to ""
    |
    */

    'suffix' => 'Filter',

    /*
    |--------------------------------------------------------------------------
    | Default filter class method name
    |--------------------------------------------------------------------------
    |
    | When creating class filter that needs passing argument, the method name comes from this config
    | For example for a SearchFilter class, you should define a method with this name, apply, otherwise that wont work
    | If you want to use another name , you can change the config and change the method name in classe
    |
    */

    'method'  => 'apply',
];
