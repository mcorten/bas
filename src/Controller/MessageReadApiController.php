<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\MessageReadModel;
use App\Handler\MessageReadHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class MessageReadApiController extends AbstractController
{
  public function __construct(private readonly MessageReadHandler $read)
  {
  }

  #[Route('/message/read/{recipient}/{token}', name: 'api_message_read', methods: ['GET'])]
  public function read(Request $request): Response
  {
    // TODO add brute force detection/API throttling to prevent users from guessing messages
    // TODO validate request by framework
    $recipient = $request->get('recipient');
    $token = $request->get('token');

    if (!is_string($recipient) || strlen($recipient) < 1 ||  strlen($recipient) > 128) {
      return $this->json([
        'error' => "invalid recipient, can not be empty or more then 128 characters"
      ], Response::HTTP_BAD_REQUEST);
    }

    if (!is_string($token) || strlen($token) < 1 || strlen($token) > 512) {
      return $this->json([
        'error' => "invalid token, can not be empty or more then 512 characters"
      ], Response::HTTP_BAD_REQUEST);
    }

    $message = $this->read->handle(recipient: $recipient, token: $token,);

    if (!($message instanceof MessageReadModel)) {
      return $this->json([
        'found' => false
      ]);
    }

    return $this->json([
      'found' => true,
      'text' => $message->text
    ]);
  }
}
