<?php

namespace Wolphy;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Appointment extends Model
{

    /**
     * Get appointment's client
     */
    public function client()
    {
        return $this->hasOne('Wolphy\Client','id','client_id');
    }

    /**
     * return Query builder with scope of today's appointments
     *
     * @param $query
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
     */
    function scopeDates($query,$datetime_from,$datetime_to=null) {

        $query->where('datetime' , '>=' , Carbon::createFromFormat("Y-m-d H:i:s",$datetime_from) );

        if($datetime_to)
            $query->where('datetime', '<', Carbon::createFromFormat("Y-m-d H:i:s",$datetime_to) );

        return $query;
    }


}
