<?php

namespace App\Controller;

use App\Entity\Ticket;
use App\Form\TicketType;
use App\Repository\TicketRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Security;

class ClientController extends AbstractController
{

    /**
     * @var Security
     */
    private $security;
    /**
     * @var TicketRepository
     */
    private $ticketRepository;
    /**
     * @var UrlGeneratorInterface
     */
    private $urlGenerator;

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
            return $this->ticketRepository->findClientTickets($user);
        } else return new RedirectResponse($this->urlGenerator->generate('app_login'));
    }

    public function create(Request $request): Response
    {
        $user = $this->security->getUser();

        $ticket = new Ticket();
        $form = $this->createForm(TicketType::class, $ticket);
        $form->handleRequest($request);
        $ticket->setDemandeur($user->getUsername());

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($ticket);
            $entityManager->flush();

            return $this->redirectToRoute('home');
        }

        return $this->render('client/new.html.twig', [
            'ticket' => $ticket,
            'form' => $form->createView(),
        ]);
    }
}
