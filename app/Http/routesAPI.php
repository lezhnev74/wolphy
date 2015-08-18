<?php

/*
 * THIS FILE IS FOR API ROUTES
 */

APIRoute::group(['version'=>'v1', 'namespace' => '\Wolphy\Http\Controllers\Api\v1'],function($api){

    $api->post('oauth/access_token', function() {
        try {
            return \Response::json(Authorizer::issueAccessToken());
        } catch(\Exception $e) {
            //If autharization failed I answer with 401 Code
            return app('Dingo\Api\Http\Response\Factory')->errorUnauthorized($e->getMessage());
        }
    });

    //use Dingo's middleware to protect routes with configured AUTH subsystem
    $api->group( [ 'middleware'=>'api.auth' ] , function($api){
        $api->get('client', 'ClientController@index');
        $api->get('client/{client_id}/appointments', 'ClientController@appointments')->where('client_id','[0-9]+');

        $api->get('appointment', 'AppointmentController@index');
    });

});
