<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index()
    {
        $user = new User();

        $form = $this->createForm(UserType::class, $user);
        return $this->render('home/index.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("/inscription", name="inscription")
     */

    public function inscription()
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        return $this->render('home/inscription.html.twig', ['form' => $form->createView()]);
    }
}


