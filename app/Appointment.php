<?php

namespace Wolphy;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    /**
     * return Query builder with scope of today's appointments
     *
     * @param $query
     */
    function scopeToday($query) {
        return $this->scopeDates($query , date('Y-m-d 00:00:00') , date('Y-m-d 00:00:00',strtotime('tomorrow')));
    }

    /**
     * return Query builder with scope to given dates (Includng $datetime_from, excluding $datetime_to)
     *
     * @param $query
     * @param $datetime_from in format Y-m-d H:i:s
     * @param $datetime_to in format Y-m-d H:i:s
     */
    function scopeDates($query,$datetime_from,$datetime_to) {
        $query->where('datetime' , '>=' , $datetime_from)
              ->where('datetime' , '<' , $datetime_to);

        return $query;
    }
}
