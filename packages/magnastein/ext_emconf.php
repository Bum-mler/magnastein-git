<?php

$EM_CONF[$_EXTKEY] = [
    'title' => 'Magna',
    'description' => 'Template Magna',
    'category' => 'templates',
    'constraints' => [
        'depends' => [
            'bootstrap_package' => '13.0.0-14.9.99',
        ],
        'conflicts' => [
        ],
    ],
    'autoload' => [
        'psr-4' => [
            'Simplesigns\\Magnastein\\' => 'Classes'
        ],
    ],
    'state' => 'stable',
	'author' => 'simpel signs',
    'author_email' => 'page@simplesigns.de',
    'author_company' => 'simplesigns',
    'version' => '12.4.14',
];
