<?php

declare(strict_types=1);

namespace App\persistence;

use App\Contract\ExpireMode;
use App\Entity\Message;
use App\Repository\MessageRepository;

readonly class CreateMessage
{
  public function __construct(private MessageRepository $repository)
  {
  }

  public function __invoke(
    string $text,
    string $recipient,
    ExpireMode $mode) : Message
  {
    $message = new Message();
    $message->setText($text);
    $message->setRecipient($recipient);
    $message->setExpiryMode($mode->value);

    $this->repository->save($message);

    return $message;
  }
}
