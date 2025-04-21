<?php

declare(strict_types=1);

namespace App\Shared\Encryptor;

use App\Shared\Encryptor\Adapter\EncryptAdapterInterface;
use App\Shared\Encryptor\Adapter\EncryptV1Adapter;

readonly class Encrypt {

  /**
   * @var EncryptAdapterInterface[]
   *
   * Used to encrypt / decrypt data
   * Array/multiple adapters, so we can stay backwards compatible if we ever upgrade the algorithm
   * The first should always be the newest encryption method.
   * The second (and more) are only for decrypting old messages (or we could upgrade them in a migration using this)
   *
   * We could also store the encryption algorithm in the database, this way we would not have to brute force decryption
   */
  private array $adapters;

  public function __construct()
  {
    // TODO inject adapters with factory
    $this->adapters = [
      new EncryptV1Adapter()
    ];
  }

  public function encrypt(string $data): string {
    return $this->adapters[0]->encrypt($data);
  }

  public function decrypt(string $encrypted): string {
    $decrypted = "";
    foreach ($this->adapters as $adapter) {
      $decrypted = $adapter->decrypt($encrypted);
      if (is_string($decrypted)) {
        break;
      }
    }

    if (is_string($decrypted)) {
      return $decrypted;
    }

    // TODO custom exception
    throw new \Exception("No adapter found for decrypting the current string");
  }
}
