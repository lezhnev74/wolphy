<?php

namespace Wolphy;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;

class Client extends Model
{
    /**
     * Override default way of storing DATETIME of created_at, updated_at, deleted_at in LARAVEL
     *
     * @return string
     */
    protected function getDateFormat()
    {
        return 'Y-m-d H:i:s';
    }

    /**
     * Get all the appointments for the client
     */
    public function appointments()
    {
        return $this->hasMany('Wolphy\Appointment');
    }

    /**
     * Override Eloquent delete to also delete all linked Appointments
     *
     * @throws \Exception
     */
    public function delete() {
        parent::delete();

        //Delete all linked appointments for this client
        $this->appointments()->delete();
    }

}
