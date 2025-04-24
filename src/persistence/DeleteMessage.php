<?php

declare(strict_types=1);

namespace App\persistence;

use App\Contract\ExpireMode;
use App\Entity\Message;
use App\Repository\MessageRepository;
use Doctrine\DBAL\Types\ConversionException;

readonly class DeleteMessage
{
  public function __construct(private MessageRepository $repository)
  {
  }

  public function __invoke(Message $message){
    $this->repository->delete($message);
  }
}
