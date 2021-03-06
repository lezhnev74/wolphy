<?php

namespace Wolphy;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Appointment extends Model
{

    /**
     * Override saving function to set the `per_client_id` value on the first save
     *
     * @param array $options
     * @return void
     */
    public function save(array $options = []) {

        //if this is the first time saving - set per_account_id
        if(!$this->per_client_id) {
            //get the most number from this account's data
            $this->per_client_id = $this->client->appointments()->count() + 1;
        }

        parent::save($options);
    }

    /**
     * Get appointment's client
     */
    public function client()
    {
        return $this->hasOne('Wolphy\Client','id','client_id');
    }


    /**
     * return QueryBuilder scoped to a given client
     *
     * @param $client_id
     * @return $query
     */
    function scopeClient($query, $client_id) {

        $query->where('client_id',$client_id);

        return $query;
    }

    /**
     * return Query builder with scope of today's appointments
     *
     * @param $query
     * @return $query
     */
    function scopeToday($query) {
        return $this->scopeDates($query , date('Y-m-d 00:00:00') , date('Y-m-d 00:00:00' , strtotime('tomorrow') ) );
    }

    /**
     * return Query builder with scope to given dates (Includng $datetime_from, excluding $datetime_to)
     *
     * @param $query
     * @param $datetime_from in format Y-m-d H:i:s (including this datetime)
     * @param $datetime_to in format Y-m-d H:i:s (excluding this datetime)
     *
     * @throws InvalidArgumentException if datetime arguments are in wrong format
     * @return $query
     */
    function scopeDates($query,$datetime_from,$datetime_to=null) {

        $query->where('datetime' , '>=' , Carbon::createFromFormat("Y-m-d H:i:s",$datetime_from) );

        if($datetime_to)
            $query->where('datetime', '<', Carbon::createFromFormat("Y-m-d H:i:s",$datetime_to) );

        return $query;
    }

    /**
     * Limits appointments to one most recent
     *
     * @param $query
     * @return $query
     */
    function scopeLast($query) {

        $query->orderBy('datetime','desc')->take(1);

        return $query;
    }






}
