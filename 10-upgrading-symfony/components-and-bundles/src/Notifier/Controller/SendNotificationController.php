<?php

declare(strict_types=1);

namespace App\Notifier\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Notifier\Notification\Notification;
use Symfony\Component\Notifier\NotifierInterface;
use Symfony\Component\Notifier\Recipient\Recipient;

final class SendNotificationController
{
    public function __construct(private NotifierInterface $notifier)
    {
    }

    public function __invoke(): Response
    {
        $notification = (new Notification('New Invoice', ['email']))
            ->subject('New course published')
            ->content('We just published Kotlin course.');

        $recipient = new Recipient(
            'user@codely.tv',
            '600000000'
        );

        $this->notifier->send($notification, $recipient);

        return new Response('<body>ok</body>');
    }
}