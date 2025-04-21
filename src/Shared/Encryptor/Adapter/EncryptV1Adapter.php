<?php

declare(strict_types=1);

namespace App\Shared\Encryptor\Adapter;

use Random\RandomException;

class EncryptV1Adapter implements EncryptAdapterInterface
{

  // TODO get key, initializationVector and ciphering from .env
  private readonly string $key;
  private readonly string $ciphering;

  public function __construct()
  {
    // Thought:
    // at this moment we use a static encryption key, we could also use parts of the lookup key to make it more dynamic
    $this->key = "UKQ0GhrS3duIyuvjbEDqYWAnkwUPZtiQUblB5dN2VHVqk3xIiT0VRVsXgerpkeu";
    $this->ciphering = "AES-256-CTR";
  }

  /**
   * @throws RandomException
   */
  public function encrypt(string $data): string|bool
  {
    $iv_length = openssl_cipher_iv_length($this->ciphering);
    $encryption_iv = random_bytes($iv_length);

    $encryptedText = openssl_encrypt(
      $data,
      $this->ciphering,
      $this->key,
      0,
      $encryption_iv
    );

    // add the random bytes to the encrypted string, so we can use them to decrypt
    // base64 because random bytes can not be stored in the database as text
    return base64_encode(sprintf('%1$s%2$s', $encryption_iv, $encryptedText));
  }

  public function decrypt(string $encrypted): string|bool
  {
    $iv_length = openssl_cipher_iv_length($this->ciphering);

    $textDecoded = base64_decode($encrypted);

    // random bytes used during encryption are added to the string. so we remove them here
    $encryption_iv = substr($textDecoded, 0, $iv_length);
    $encryptedText = substr($textDecoded, $iv_length);

    return openssl_decrypt(
      $encryptedText,
      $this->ciphering,
      $this->key,
      0,
      $encryption_iv
    );
  }


}
