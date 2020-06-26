<?php

namespace App\Controller;

use App\Repository\TicketRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Security;

class ChefController extends AbstractController
{
    /**
     * @var UrlGeneratorInterface
     */
    private $urlGenerator;
    /**
     * @var TicketRepository
     */
    private $ticketRepository;
    /**
     * @var Security
     */
    private $security;

    public function __construct(UrlGeneratorInterface $urlGenerator, TicketRepository $ticketRepository, Security $security)
    {
        $this->urlGenerator = $urlGenerator;
        $this->ticketRepository = $ticketRepository;
        $this->security = $security;
    }

    public function index()
    {
        $user = $this->security->getUser();

        if ($user) {
            dump($this->ticketRepository->findAll());
            return $this->ticketRepository->findAll();
        } else return new RedirectResponse($this->urlGenerator->generate('app_login'));
    }
}
