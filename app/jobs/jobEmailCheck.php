<?php

declare(strict_types=1);

require_once __DIR__.'/../functions/emailCheck.php';

function job_email_check(PDO $dbh, int $id, string $email): void
{
    $value = email_check($email);

    $dbh->beginTransaction();

    $stmt = $dbh->prepare('update emails set checked = ?, valid = ? where email = ?');
    $stmt->execute([1, $value, $email]);

    $stmt = $dbh->prepare('delete from jobs where id = ?');
    $stmt->execute([$id]);

    $dbh->commit();
}
