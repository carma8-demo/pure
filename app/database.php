<?php

declare(strict_types=1);

function getDb(): PDO
{
    global $db;

    if ($db === null) {
        $db = new PDO('sqlite:'.__DIR__.'/../database/database.sqlite');
    }

    return $db;
}
