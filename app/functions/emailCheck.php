<?php

declare(strict_types=1);

function email_check(string $email): bool
{
    sleep(random_int(1, 60));

    $value = (bool) random_int(0, 1);
    echo "Check {$email}: {$value}\n";

    return $value;
}
