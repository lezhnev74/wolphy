<?php

namespace Wolphy\Http\Controllers;

use Wolphy\Client;
use Illuminate\Http\Request;

use Wolphy\Http\Requests;
use Wolphy\Http\Controllers\Controller;

class ClientController extends Controller
{


    /**
     * Get all clients
     *
     *
     * @return Response
     */
    public function index()
    {
        $clients = Client::all();

        return $clients;
    }



    /**
     * Store a newly created client model
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request)
    {

        $client = new Client();

        //$client->save();

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
