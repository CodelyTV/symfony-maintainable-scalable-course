<?php

$teachers = [
    [
        'id' => 1,
        'title' => 'Núria'
    ],
    [
        'id' => 2,
        'title' => 'Rafa'
    ]
];

header('Content-Type: application/json');
http_response_code(200);
echo json_encode($teachers);