<?php
// src/Controller/DebugController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class DebugController extends AbstractController
{
    #[Route('/_debug/session', name: 'debug_session')]
    public function sessionProbe(SessionInterface $session): Response
    {
        $count = $session->get('probe_count', 0) + 1;
        $session->set('probe_count', $count);

        return new Response("Session OK. probe_count=" . $count);
    }

    #[Route('/_debug/csrf', name: 'debug_csrf')]
    public function csrfProbe(CsrfTokenManagerInterface $tm): Response
    {
        $t = $tm->getToken('probe')->getValue(); // génère un token
        return new Response("CSRF token generated: ".$t);
    }
}
