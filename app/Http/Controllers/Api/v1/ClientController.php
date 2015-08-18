<?php namespace Wolphy\Http\Controllers\Api\v1;

use Illuminate\Http\Request;
use Wolphy\Http\Requests;
use Wolphy\Http\Controllers\Controller;
use Wolphy\Client;
use Wolphy\Appointment;
use Dingo\Api\Routing\Helpers;

class ClientController extends Controller
{
    use Helpers;

    /**
     * Get the list of all my clients
     *
     * @return Response
     */
    public function index()
    {
        return Client::query()->get();
    }


    /**
     * Get the list of client's appointments
     *
     * @return Response
     */
    public function appointments($client_id)
    {
        $client = Client::query()->where('per_account_id',$client_id)
                                 ->where('account_id',\Auth::user()->id)
                                 ->first();

        if(!$client) {
            throw new \Symfony\Component\HttpKernel\Exception\NotFoundHttpException('Client #'.$client_id.' not found on your account');
        }


        $appointments = $client->appointments()->get();
        //I hide ID attribute and show per_client_id as real ID
        $appointments->map(function($appointment){
                            $appointment->id = $appointment->per_client_id;
                            $appointment->setHidden(['per_client_id']);
                      });

        return $appointments;
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        //
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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
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
