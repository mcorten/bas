<?php

declare(strict_types=1);

namespace App\Shared\Encryptor\Adapter;

use Random\RandomException;

class EncryptV1Adapter implements EncryptAdapterInterface
{

  // TODO get key and ciphering from .env
  private readonly string $key;
  private readonly string $ciphering;

  private readonly int $cipheringLength;

  public function __construct()
  {
    // Thought:
    // at this moment we use a static encryption key, we could also use parts of the lookup key to make it more dynamic
    $this->key = "UKQ0GhrS3duIyuvjbEDqYWAnkwUPZtiQUblB5dN2VHVqk3xIiT0VRVsXgerpkeu";
    $this->ciphering = "AES-256-CTR";

    $this->cipheringLength = openssl_cipher_iv_length($this->ciphering);;
  }

  /**
   * @throws RandomException
   */
  public function encrypt(string $data): string|bool
  {
    $encryption_iv = random_bytes($this->cipheringLength);

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
    $textDecoded = base64_decode($encrypted);

    // random bytes used during encryption are added to the string. so we remove them here
    list($encryption_iv, $encryptedText) = $this->stripRandomBytesFromEncryptedString($textDecoded);

    return openssl_decrypt(
      $encryptedText,
      $this->ciphering,
      $this->key,
      0,
      $encryption_iv
    );
  }

  /**
   * @param string $encrypted
   * @return string[]
   *    1st: the random bytes
   *    2nd: the encrypted text
   */
  private function stripRandomBytesFromEncryptedString(string $encrypted): array {
    $encryptionRandomBytes = substr($encrypted, 0, $this->cipheringLength);
    $encryptedText = substr($encrypted, $this->cipheringLength);

    return [$encryptionRandomBytes, $encryptedText];
  }


}
