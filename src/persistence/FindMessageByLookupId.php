<?php

declare(strict_types=1);

namespace App\persistence;

use App\Entity\Message;
use App\Repository\MessageRepository;
use Doctrine\DBAL\Types\ConversionException;

readonly class FindMessageByLookupId {
  public function __construct(private MessageRepository $repository) {
  }

  public function __invoke(string $lookupId): Message | null
  {
    try {
      return $this->repository->findOneBy(['lookup' => $lookupId]);
    } catch(ConversionException $e) {
      // happens when the wrong lookup key is given
      return null;
    }
  }
}
