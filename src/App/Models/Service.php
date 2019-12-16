<?php


namespace App\Models;


class Service extends Model
{
    public function updateServiceTarif($userId, $serviceId, $tarifId): bool
    {
        $payday = date('Y-m-d', strtotime('today midnight'));

        $sql
            = 'UPDATE services SET tarif_id=?, payday=? WHERE user_id=? AND ID=?';
        $psql = $this->db->prepare($sql);

        return $psql->execute([$tarifId, $payday, $userId, $serviceId]);
    }
}