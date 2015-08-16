<?php

namespace Wolphy;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    //

    /**
     * Get all the appointments for the client
     */
    public function appointments()
    {
        return $this->hasMany('Wolphy\Appointment');
    }

    public function delete() {
        parent::delete();

        //Delete all linked appointments for this client
        $this->appointments()->delete();

    }

    



}
