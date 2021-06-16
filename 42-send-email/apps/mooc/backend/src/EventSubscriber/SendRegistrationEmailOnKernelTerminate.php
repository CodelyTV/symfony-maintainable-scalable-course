<?php

declare(strict_types=1);

namespace CodelyTv\Apps\Mooc\Backend\EventSubscriber;

use CodelyTv\Mooc\Users\Infrastructure\Email\MailtrapRegistrationEmailSender;
use CodelyTv\Mooc\Users\Infrastructure\Email\InMemoryRegistrationEmailSender;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\TerminateEvent;

final class SendRegistrationEmailOnKernelTerminate implements EventSubscriberInterface
{
    public function __construct(
        private InMemoryRegistrationEmailSender $inMemorySender,
        private MailtrapRegistrationEmailSender $awsSesSender
    ) {
    }

    public static function getSubscribedEvents()
    {
        return [TerminateEvent::class => 'onKernelTerminate'];
    }

    public function onKernelTerminate(TerminateEvent $event)
    {
        if (!$event->isMasterRequest()) {
            return;
        }

        foreach ($this->inMemorySender->userWithPendingRegistrationEmail() as $users) {
            $this->awsSesSender->sendTo($users);
        }
    }
}