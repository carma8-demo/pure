<?php

declare(strict_types=1);

require __DIR__.'/../database.php';

const QUEUE = 'sends';

$dbh = getDb();

$stmt = $dbh->prepare("insert or ignore into jobs (queue, payload, created_at)
    select ?, json_object('username', users.username, 'email', emails.email), ?
    from users
             inner join emails on users.id = emails.user_id
    where users.validts <= ?
      and (users.notifiedts is null or users.notifiedts <= ?)
      and emails.valid = ?
    order by users.validts");

$stmt->execute([QUEUE, time(), date('Y-m-d H:i:s', strtotime('+3 days')), date('Y-m-d H:i:s', strtotime('-3 days')), 0]);

$count = $stmt->rowCount();

printf("Found %d emails and dispatched to %s queue\n", $count, QUEUE);
