<?php

namespace Wolphy;

use Dingo\Api\Routing\Helpers;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{

    /**
     * Override default(Laravel) way of storing DATETIME of created_at, updated_at, deleted_at in LARAVEL
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
     * Return Query Builder with scope to one account
     *
     * @param $query
     * @param $client_id
     *
     * @return $query
     */
    public function scopeAccount($query,$account_id) {
        $query->where('account_id',$account_id);
        return $query;
    }

    /**
     * Override saving function to set the `per_account_id` value on the first save
     *
     * @param array $options
     * @return void
     */
    public function save(array $options = []) {

        //if this is the first time saving - set per_account_id
        if(!$this->per_account_id) {
            //get the most number from this account's data
            $this->per_account_id = static::query()->account($this->account_id)->count() + 1;
        }

        parent::save($options);
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


    /**
     * Get clients who did not attend services at least $days_till_last_appointment days at get cold clients
     * Sorts by most fresh clients (who can be returned with some marketing effort)
     *
     * @param string $last_appointment_datetime DATETIME format
     * @param int $count
     * @return Illuminate\Database\Eloquent\Collection $collection of Clients
     */
    static public function getCold($last_appointment_datetime,$count=3) {

        //select clients joined with their appointments
        $users = Client::join('appointments', 'appointments.client_id', '=', 'clients.id')
            //set datetime limits
            ->where('datetime','>',$last_appointment_datetime)
            //group rows by client ID (if client has multiple appointments then client would appear multiple times in the result set
            ->groupBy('clients.id')
            //sort them by date of last appointment in descending order
            ->orderByRaw('MAX(appointments.datetime)')
            ->get();

        return $users;
    }

}
