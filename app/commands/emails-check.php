<?php

declare(strict_types=1);

require __DIR__.'/../database.php';

const QUEUE = 'checks';

$dbh = getDb();

$stmt = $dbh->prepare("insert or ignore into jobs (queue, payload, created_at)
    select ?, json_object('email', email), ?
    from emails
    where checked = ?");

$stmt->execute([QUEUE, time(), 0]);

$count = $stmt->rowCount();

printf("Found %d emails and dispatched to %s queue\n", $count, QUEUE);
