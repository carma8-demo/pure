<?php

declare(strict_types=1);

require __DIR__.'/../database.php';

$dbh = getDb();

$stmt = $dbh->prepare('update emails
    set checked = ?,
        valid = ?
    where id in (select emails.id
    from emails
             inner join users on users.id = emails.user_id and users.confirmed = ?
    where emails.valid = ?)');

$stmt->execute([1, 1, 1, 0]);

$count = $stmt->rowCount();

printf("Found %d confirmed emails and promoted as checked and validated\n", $count);
