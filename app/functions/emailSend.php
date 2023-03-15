<?php

declare(strict_types=1);

function email_send(string $username, string $email): void
{
    sleep(random_int(1, 10));

    echo "{$username} ({$email}), your subscription is expiring soon\n";
}
