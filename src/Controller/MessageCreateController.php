<?php

declare(strict_types=1);

namespace App\Controller;

use App\Handler\MessageCreateHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class MessageCreateController extends AbstractController
{

  public function __construct(private readonly MessageCreateHandler $create)
  {
  }

  #[Route('/message', name: 'api_message_create', methods: ['POST'])]
  public function number(Request $request): Response
  {
    // TODO validate request by framework
    $recipient = $request->get('recipient');
    $text = $request->get('text');

    if (!is_string($recipient) || strlen($recipient) < 1 ||  strlen($recipient) > 128) {
      return $this->json([
        'error' => "invalid recipient, can not be empty or longer then 128 characters"
      ], Response::HTTP_BAD_REQUEST);
    }

    if (!is_string($text) || strlen($text) < 1) {
      return $this->json([
        'error' => "invalid recipient, can not be empty"
      ], Response::HTTP_BAD_REQUEST);
    }


    // TODO create enum for mode
    $message = $this->create->handle(text: $text, recipient: $recipient, mode: 'one_time');

    return $this->json([
      'key' => $message->getLookup(),
    ]);
  }
}
