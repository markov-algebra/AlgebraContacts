<?php

return [

        'fetch'   => PDO::FETCH_OBJ,
        'driver'  => 'mysql',
        'mysql'   => [
            'host'      => '127.0.0.1', //ili localhost
            'user'      => 'root',
            'pass'      => '',
            'db'        => 'algebra_contacts',
            'carset'    => 'utf8',
            'collation' => 'utf8_general_ci'
        ],
        'sqlite'  => [
            'db'            =>''
        ],
        'pgsql'   => [
            'host'      => '',
            'user'      => '',
            'pass'      => '',
            'db'        => '',
            'carset'    => 'utf8',
            'collation' => 'utf8_general_ci'
        ]
        
    
]


?>