<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class HomeController extends AbstractController
{

    /**
     * @var UserRepository
     */
    private $userRepository;
    /**
     * @var ObjectManager
     */
    private $em;
    /**
     * @var Security
     */
    private $security;
    /**
     * @var ChefController
     */
    private $chefController;
    /**
     * @var ClientController
     */
    private $clientController;
    /**
     * @var TechnicienController
     */
    private $technicienController;
    /**
     * @var RequestStack
     */
    private $requestStack;

    /**
     * HomeController constructor.
     * @param UserRepository $userRepository
     * @param EntityManagerInterface $em
     * @param Security $security
     * @param ChefController $chefController
     * @param ClientController $clientController
     * @param TechnicienController $technicienController
     * @param RequestStack $requestStack
     */
    public function __construct(UserRepository $userRepository, EntityManagerInterface $em, Security $security, ChefController $chefController, ClientController $clientController, TechnicienController $technicienController, RequestStack $requestStack)
    {
        $this->userRepository = $userRepository;
        $this->em = $em;
        $this->security = $security;
        $this->chefController = $chefController;
        $this->clientController = $clientController;
        $this->technicienController = $technicienController;

        $this->requestStack = $requestStack;
    }

    /**
     * @Route("/", name="home")
     */

    public function index()
    {
        $user = $this->checkIfUserIsLoggedIn();
        if ($user) {
            switch ($user->getRole()) {
                case 'chef' :
                    $tickets = $this->chefController->index();
                    return $this->render('chef/index.html.twig', ['tickets' => $tickets]);
                case 'client' :
                    $tickets = $this->clientController->index();
                    return $this->render('client/index.html.twig', ['tickets' => $tickets]);
                case 'technicien' :
                    return $this->render('technicien/index.html.twig');
            }
        }

        return $this->render('home/index.html.twig');
    }

    /**
     * @Route("/new", name="new")
     */

    public function create()
    {
        $user = $this->checkIfUserIsLoggedIn();
        $request = $this->getRequest();
        if ($user) {
            switch ($user->getRole()) {
                case 'chef' :
                    $tickets = $this->chefController->index();
                    return $this->render('chef/index.html.twig', ['tickets' => $tickets]);
                case 'client' :
                    return $this->clientController->create($request);
                case 'technicien' :
                    return $this->render('technicien/index.html.twig');
            }
        }
    }

    private function checkIfUserIsLoggedIn()
    {
        return $this->security->getUser();
    }

    private function getRequest()
    {
        return $this->requestStack->getCurrentRequest();
    }


}


