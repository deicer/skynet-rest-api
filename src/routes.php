<?php

return [
    'GET /users/{user_id}/services/{service_id}/tarifs' => 'Controllers\ApiController@getTarifs',
    'PUT /users/{user_id}/services/{service_id}/tarif' => 'Controllers\ApiController@putTarif',
];
