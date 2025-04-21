<?php

declare(strict_types=1);

namespace App\Entity;

class MessageReadModel {
  public function __construct(
    public readonly string $recipient,
    public readonly string $text,
    public readonly string $expiry_mode,
  ) {}
}
