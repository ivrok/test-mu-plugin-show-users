<?php
return [
    "version" => "1.0.0",
    "api_users_domain" => "https://jsonplaceholder.typicode.com",
    "debug" => defined("WP_DEBUG") ? WP_DEBUG : false,
    "cache_type" => "File", //Memcached|File
    "cache_expiration_time" => 60 * 60 * 24, //24 hours
    "file_cache" => [
        "cache_dir" => SU_BASE_DIR . "/cache",
    ],
    "memcached" => [
        "server" => "127.0.0.1",
        "port" => "11211"
    ]
];
