<?php
declare(strict_types=1);

return [
    \Simplesigns\MlStonelexicon\Domain\Model\Page::class => [
        'tableName' => 'pages',  // Tabellenname in der Datenbank für das Page-Modell
        'properties' => [
            'title' => ['fieldName' => 'title'],
            'subtitle' => ['fieldName' => 'subtitle'],
            'abstract' => ['fieldName' => 'abstract'],
            'rocktype' => ['fieldName' => 'rocktype'],
            'subgroup' => ['fieldName' => 'subgroup'],
            'age' => ['fieldName' => 'age'],
            'origin' => ['fieldName' => 'origin'],
            'color' => ['fieldName' => 'color'],
            'structure' => ['fieldName' => 'structure'],
            'indoordry' => ['fieldName' => 'indoordry'],
            'indoorwet' => ['fieldName' => 'indoorwet'],
            'outdoor' => ['fieldName' => 'outdoor'],
            'pid' => ['fieldName' => 'pid'],
            'uid' => ['fieldName' => 'uid'],
            'thumbnail' => ['fieldName' => 'images'],
            'doktype' => ['fieldName' => 'doktype'],
        ],
    ],
];
