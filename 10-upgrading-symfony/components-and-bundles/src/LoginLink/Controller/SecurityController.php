<?php

declare(strict_types=1);

namespace App\LoginLink\Controller;

use App\LoginLink\Security\User;
use App\LoginLink\Security\UserRepository;
use Exception;
use LogicException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Security\Http\LoginLink\LoginLinkHandlerInterface;

class SecurityController extends AbstractController
{
    public function __construct(
        private LoginLinkHandlerInterface $loginLinkHandler,
        private MailerInterface $mailer,
        private UserRepository $userRepository
    ) {
    }
    
    public function check(): void
    {
        throw new LogicException('This code should never be reached');
    }

    public function logout(): void
    {
        throw new Exception('Don\'t forget to activate logout in security.yaml');
    }

    public function loginLink(Request $request): Response
    {
        if ($request->isMethod('POST')) {
            $email = $request->request->get('email');
            $user = $this->userRepository->find($email);

            $loginLinkDetails = $this->loginLinkHandler->createLoginLink($user, $request);
            $loginLink = $loginLinkDetails->getUrl();

            $email = (new Email())
                ->from('info@codely.tv')
                ->to($email)
                ->text($loginLink)
                ->html($loginLink);
            $this->mailer->send($email);
        }

        return $this->render('login_link/login.html.twig');
    }
}