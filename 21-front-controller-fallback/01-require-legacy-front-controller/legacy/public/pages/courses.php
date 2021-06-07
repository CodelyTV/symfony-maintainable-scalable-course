<?php

$courses = [
    [
        'id' => 1,
        'title' => 'LEGACY: Arquitectura Hexagonal'
    ],
    [
        'id' => 2,
        'title' => 'LEGACY: JS Moderno'
    ]
];

header('Content-Type: application/json');
http_response_code(200);
echo json_encode($courses);