<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class TechnicienController extends AbstractController
{
    /**
     * @Route("/technicien", name="technicien")
     */
    public function index()
    {
        return $this->render('technicien/index.html.twig', [
            'controller_name' => 'TechnicienController',
        ]);
    }
}
