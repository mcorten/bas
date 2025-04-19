<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ReadController extends AbstractController
{
  #[Route('/read', name: 'app_read', methods: ['GET'])]
  public function page(): Response
  {
    return $this->render('read.html.twig', []);
  }

  #[Route('/read', name: 'api_read', methods: ['POST'])]
  public function number(): Response
  {
    // TODO validate request
    // TODO process request
    return $this->json([]);
  }
}
