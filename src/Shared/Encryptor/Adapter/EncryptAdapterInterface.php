<?php

declare(strict_types=1);

namespace App\Shared\Encryptor\Adapter;

interface EncryptAdapterInterface {
  public function encrypt(string $data): string|bool;
  public function decrypt(string $encrypted): string|bool;
}
