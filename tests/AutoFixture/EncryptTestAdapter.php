<?php

declare(strict_types=1);

namespace App\Tests\AutoFixture;

use App\Shared\Encryptor\Adapter\EncryptAdapterInterface;

class EncryptTestAdapter implements EncryptAdapterInterface {

  private string $prefix = '__encrypted-unit-test__';

  public function encrypt(string $data): string|bool
  {
    return sprintf('%s%s', $this->prefix, $data);
  }

  public function decrypt(string $encrypted): string|bool
  {
    return substr($encrypted, strlen($this->prefix));
  }

}
