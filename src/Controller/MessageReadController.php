<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class MessageReadController extends AbstractController
{
  #[Route('/message/read/{recipient}/{token}', name: 'presenter_message_read', methods: ['GET'])]
  public function readMessage(): Response
  {
    throw new \Exception("not implemented");
  }
}
