<?php
/**
 * The development database settings. These get merged with the global settings.
 *203.195.195.231
 *3306
 *wxstudio
 *
 */
return array(
    'default' => array(
        'type'           => 'mysqli',
        'connection'     => array(
            'hostname'   => 'localhost',
            'port'       => '3306',
            'database'   => 'ticket',
            'username'   => 'root',
            'password'   => '',
            'persistent' => false,
            'compress'   => false,
        ),
        'identifier'     => '`',
        'table_prefix'   => '',
        'charset'        => 'utf8',
        'enable_cache'   => true,
        'profiling'      => false,
    ),
    'redis' => array(
        'default'     => array(
            'hostname'   => '127.0.0.1',
            'port'       => '6379',
            'database'   => '0',
            'password'   => ''
        )
    ),
);