<?php

/*
 * THIS FILE IS FOR API ROUTES
 */

APIRoute::group(['version'=>'v1', 'namespace' => '\Wolphy\Http\Controllers\Api\v1'],function($api){

    $api->get('client', 'ClientController@index');
    $api->get('client/{client_id}/appointments', 'ClientController@appointments')->where('client_id','[0-9]+');

    $api->get('appointment', 'AppointmentController@index');

});
