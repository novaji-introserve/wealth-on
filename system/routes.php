<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
use Wealthon\System\Models\Commission;
 
Route::group(['prefix' => 'api'], function () {
    Route::match(['get', 'post'], '/hello', function () {
        return 'Hello World';
    });
    
     Route::match(['get', 'post'], '/commissions', function () {
       $commission =  Commission::find(1);
       return $commission->type;
    });
    
});
