<?php namespace Wolphy;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;

class ClientRepository {

    /**
     * Get clients who did not attend services at least $days_till_last_appointment days at get cold clients
     * Sorts by most fresh clients (who can be returned with some marketing effort)
     *
     * @param string $last_appointment_datetime DATETIME format
     * @param int $count
     * @return Illuminate\Database\Eloquent\Collection $collection of Clients
     */
    static public function getCold($last_appointment_datetime,$count=3) {

        $sql = "
            SELECT * FROM (
                SELECT clients.*, clients.id AS cli_id , appointments.datetime AS last_appointment_datetime
                FROM clients
                INNER JOIN appointments ON clients.id=appointments.client_id
                ORDER BY appointments.datetime ASC
            ) AS tmp_table
            WHERE last_appointment_datetime > ?
            GROUP BY cli_id
            ORDER BY last_appointment_datetime DESC
            LIMIT ?
        ";

        $users = \DB::select($sql , [ Carbon::createFromFormat("Y-m-d H:i:s",$last_appointment_datetime) , $count ] );
        foreach($users as $key=>$user) {
            $user_array = (array)$user;
            $users[$key] = new Client();
            $users[$key]->forceFill( $user_array );
        }
        $collection = new Collection($users);


        return $collection;
    }

}
