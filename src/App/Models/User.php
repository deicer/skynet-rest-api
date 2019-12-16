<?php


namespace App\Models;


use PDO;

class User extends Model
{
    public function findTarif($userId, $serviceId): array
    {
        $query = 'select tarifs.* from services inner join tarifs
            on tarifs.ID= services.tarif_id where user_id = ? and services.ID = ?';

        $psql = $this->db->prepare($query);

        $psql->execute([$userId, $serviceId]);

        $userTarif [] = $psql->fetch(PDO::FETCH_ASSOC);

        return empty($userTarif) ? [] : $userTarif;
    }
}