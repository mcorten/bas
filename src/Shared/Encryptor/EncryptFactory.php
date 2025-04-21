<?php

declare(strict_types=1);

namespace App\Shared\Encryptor;

use App\Shared\Encryptor\Adapter\EncryptAdapterInterface;
use App\Shared\Encryptor\Adapter\EncryptV1Adapter;

readonly class EncryptFactory {

  public static function create(): Encrypt {
    $adaptersEnabled = [
      new EncryptV1Adapter()
    ];

    return new Encrypt(adapters: $adaptersEnabled);
  }
}
