<?php

declare(strict_types=1);

require_once __DIR__.'/database.php';
require_once __DIR__.'/jobs/jobEmailCheck.php';
require_once __DIR__.'/jobs/jobEmailSend.php';

$dbh = getDb();

$stmt_email_check = $dbh->prepare("select id, json_extract(payload, '$.email') as email
    from jobs
    where queue = ?
    order by created_at",
    [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);

$stmt_email_send = $dbh->prepare("select id, json_extract(payload, '$.username') as username, json_extract(payload, '$.email') as email
    from jobs
    where queue = ?
    order by created_at",
    [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);

while (true) {
    $stmt_email_check->execute(['checks']);

    while ($row = $stmt_email_check->fetch(PDO::FETCH_ASSOC)) {
        job_email_check($dbh, $row['id'], $row['email']);
    }

    $stmt_email_send->execute(['sends']);

    while ($row = $stmt_email_send->fetch(PDO::FETCH_ASSOC)) {
        job_email_send($dbh, $row['id'], $row['username'], $row['email']);
    }
}
