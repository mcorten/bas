<?php

declare(strict_types=1);

namespace App\Handler;

use App\Entity\Message;
use App\Repository\MessageRepository;

readonly class MessageCreateHandler {

  public function __construct(private MessageRepository $messageRepository)
  {
  }

  public function handle(
    string $text,
    string $recipient,
    string $mode
  ): Message {
    return $this->messageRepository->create(
      text: $text,
      recipient: $recipient,
      mode: $mode
    );
  }
}
