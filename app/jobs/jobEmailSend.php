<?php

declare(strict_types=1);

require_once __DIR__.'/../functions/emailSend.php';

function job_email_send(PDO $dbh, int $id, string $username, string $email): void
{
    email_send($username, $email);

    $dbh->beginTransaction();

    $stmt = $dbh->prepare('update users set notifiedts = ? where username = ?');
    $stmt->execute([time(), $username]);

    $stmt = $dbh->prepare('delete from jobs where id = ?');
    $stmt->execute([$id]);

    $dbh->commit();
}
