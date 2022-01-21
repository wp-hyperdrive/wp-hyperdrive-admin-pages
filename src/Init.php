<?php

use Hyperdrive\AdminPages\Bootstrap;

add_filter(
    'wp_hyperdrive_services',
    static function (array $services) {
        $services[] = Bootstrap::class;
        return $services;
    }
);
