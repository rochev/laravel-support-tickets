<?php

return [
    'delete_older' => 3, // hours
    'cron' => '*/15 * * * *', // every 15 minute as default
    'queue' => [
        'name' => null, // if null, use default Laravel queue name
        'connection' => null,// if null, use default Laravel queue connection
    ],
];
