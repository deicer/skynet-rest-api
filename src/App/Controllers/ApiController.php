<?php


namespace App\Controllers;


use App\Models\Service;
use App\Models\Tarifs;
use App\Models\User;
use DateInterval;
use DateTime;
use DateTimeZone;
use Exception;

class ApiController
{
    /**
     * @route GET /users/{user_id}/services/{service_id}/tarifs
     *
     * @param int $userId
     * @param int $serviceId
     *
     * @throws Exception
     */
    public function getTarifs(int $userId, int $serviceId): void
    {
        $userTarif = $this->getUserTarif($userId, $serviceId);

        if (empty($userTarif)) {
            $this->notFound();
        }

        $serviceTarifs = $this->getServiceTarifs($userId, $serviceId);

        if (empty($serviceTarifs)) {
            $this->notFound();
        }

        $this->jsonResponse(
            'HTTP/1.1 200 OK',
            [
                'result' => 'ok',
                'title' => $userTarif['title'],
                'link' => $userTarif['link'],
                'speed' => $userTarif['speed'],
                'tarifs' => $this->addNewPayDay($serviceTarifs)
            ]
        );
    }

    /**
     * @route PUT /users/{user_id}/services/{service_id}/tarif'
     *
     * @param int $userId
     * @param int $serviceId
     */
    public function putTarif(int $userId, int $serviceId): void
    {
        $jsonData = json_decode(
            file_get_contents('php://input'),
            true
        );

        $tarifId = $jsonData['tarif_id'] ?? null;

        if (!is_numeric($tarifId)) {
            $this->badRequest();
        }

        if ((new Service())->updateServiceTarif(
            $userId,
            $serviceId,
            $tarifId
        )) {
            $this->ok();
        }

        $this->notFound();
    }

    /**
     * @param array $data
     */
    public function ok(array $data): void
    {
        $this->jsonResponse(
            'HTTP/1.1 200 OK',
            array_merge(
                [
                    'result' => 'ok',
                ],
                $data
            )
        );
    }

    /**
     *
     */
    public function badRequest(): void
    {
        $this->jsonResponse(
            'HTTP/1.0 400 Bad Request',
            [
                'result' => 'error',
            ]
        );
    }

    /**
     *
     */
    public function notFound(): void
    {
        $this->jsonResponse(
            'HTTP/1.1 404 Not Found',
            [
                'result' => 'error',
            ]
        );
    }

    /**
     * @param string $header
     * @param array $bodyResponse
     */
    private function jsonResponse(string $header, array $bodyResponse): void
    {
        header($header);

        echo json_encode(
            $bodyResponse,
            JSON_THROW_ON_ERROR | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES
        );
        exit();
    }


    /**
     * @param int $userId
     * @param int $serviceId
     * @return array
     */
    private function getUserTarif(int $userId, int $serviceId): array
    {
        return $this->convertToUtf8(
            (new User())->findTarif($userId, $serviceId)
        )[0];
    }

    /**
     * @param int $userId
     * @param int $serviceId
     * @return array
     */
    private function getServiceTarifs(int $userId, int $serviceId): array
    {
        return $this->convertToUtf8(
            (new Tarifs())->findByUserServices($userId, $serviceId)
        );
    }


    /**
     * @param      $payPeriod
     *
     * @return string
     * @throws Exception
     */
    private function getNewPayDate($payPeriod): string
    {
        $newPayDate = new DateTime(
            date('Y-m-d 00:00:00'),
            new DateTimeZone('Europe/Moscow')
        );
        $newPayDate->add(new DateInterval('P' . $payPeriod . 'M'));
        return $newPayDate->format('UO');
    }

    /**
     * @param array $serviceTarifs
     *
     * @return array
     * @throws Exception
     */
    private function addNewPayDay(array $serviceTarifs): array
    {
        $tarifs = [];
        foreach ($serviceTarifs as $serviceTarif) {
            $tarifs[] = [
                'title' => $serviceTarif['title'],
                'price' => $serviceTarif['price'],
                'pay_period' => $serviceTarif['pay_period'],
                'new_payday' => $this->getNewPayDate(
                    $serviceTarif['pay_period']
                ),
                'speed' => $serviceTarif['speed'],
            ];
        }


        return $tarifs;
    }

    /**
     * @param array $array
     * @return array
     */
    private function convertToUtf8(array $array): array
    {
        foreach ($array as $index => $item) {
            $array[$index] = array_map(
                static function ($value) {
                    return mb_convert_encoding($value, 'UTF-8', 'CP1251');
                },
                $item
            );
        }
        return $array;
    }
}