<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class MessageReadPresenterController extends AbstractController
{
  #[Route('/message/read', name: 'presenter_message_read', methods: ['GET'])]
  public function page(): Response
  {
    return $this->render('message-read.html.twig', []);
  }
}
