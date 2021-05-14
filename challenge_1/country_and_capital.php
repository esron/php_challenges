<?php

$locations = [
    [
        'preposition' => 'do',
        'country' => 'Brasil',
        'capital' => 'Brasilia',
    ],
    [
        'preposition' => 'do',
        'country' => 'Canadá',
        'capital' => 'Ottawa',
    ],
    [
        'preposition' => 'do',
        'country' => 'Peru',
        'capital' => 'Lima'
    ],
    [
        'preposition' => 'da',
        'country' => 'Índia',
        'capital' => 'Nova Delhi',
    ],
    [
        'preposition' => 'do',
        'country' => 'Marrocos',
        'capital' => 'Rabat',
    ],
    [
        'preposition' => 'do',
        'country' => 'Iraque',
        'capital' => 'Bagdá',
    ],
];

$compare = function ($a, $b) {
    if ($a['capital'] == $b['capital']) {
        return 0;
    }

    return $a['capital'] > $b['capital'] ? 1 : -1;
};

usort($locations, $compare);

foreach ($locations as $location) {
        echo "A capital {$location['preposition']} {$location['country']} é {$location['capital']}\n";
}
