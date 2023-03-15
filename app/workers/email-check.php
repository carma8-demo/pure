<?php

declare(strict_types=1);

require_once __DIR__.'/../database.php';
require_once __DIR__.'/../jobs/jobEmailCheck.php';

const QUEUE = 'checks';

$dbh = getDb();

$stmt = $dbh->prepare("select id, json_extract(payload, '$.email') as email
    from jobs
    where queue = ?
    order by created_at",
    [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);

while (true) {
    $stmt->execute([QUEUE]);

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        job_email_check($dbh, $row['id'], $row['email']);
    }

    sleep(random_int(1, 10));
}
