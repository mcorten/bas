<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class MessageController extends AbstractController
{
  #[Route('/message', name: 'app_message', methods: ['GET'])]
  public function page(): Response
  {
    return $this->render('message-create.html.twig', []);
  }
}
