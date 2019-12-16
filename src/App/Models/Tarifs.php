<?php


namespace App\Models;


use PDO;

class Tarifs extends Model
{

    public function findByUserServices($userId, $serviceId): array
    {
        $tarifGroupIdQuery = 'SELECT tarifs.tarif_group_id
    FROM services  LEFT JOIN tarifs  ON (tarifs.ID = services.tarif_id)
                        WHERE services.ID=? AND services.user_id=?';
        $query = "SELECT * FROM tarifs WHERE tarif_group_id IN  ( $tarifGroupIdQuery )";

        $psql = $this->db->prepare($query);

        $psql->execute([$userId, $serviceId]);

        $serviceTarifs = $psql->fetchAll(PDO::FETCH_ASSOC);

        return empty($serviceTarifs) ? [] : $serviceTarifs;
    }
}
