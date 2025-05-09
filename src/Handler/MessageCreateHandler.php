<?php

declare(strict_types=1);

namespace App\Handler;

use App\Contract\ExpireMode;
use App\Entity\Message;
use App\persistence\CreateMessage;
use App\persistence\MessageRepository;
use App\Shared\Encryptor\Encrypt;

readonly class MessageCreateHandler {

  public function __construct(
    private Encrypt $encrypt,
    private CreateMessage $createMessage
  ) {
  }

  public function handle(
    string $text,
    string $recipient,
    ExpireMode $mode
  ): Message {
    // Discuss: we could make a text / recipient value object that is always encrypted
    $encryptedText = $this->encrypt->encrypt($text);
    $encryptedRecipient = $this->encrypt->encrypt($recipient);

    return ($this->createMessage)(
      text: $encryptedText,
      recipient: $encryptedRecipient,
      mode: $mode
    );
  }
}
