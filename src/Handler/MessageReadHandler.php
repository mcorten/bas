<?php

declare(strict_types=1);

namespace App\Handler;

use App\Contract\ExpireMode;
use App\Entity\Message;
use App\Entity\MessageReadModel;
use App\Repository\MessageRepository;
use App\Shared\Encryptor\Encrypt;

readonly class MessageReadHandler {

  public function __construct(
    private Encrypt $encrypt,
    private MessageRepository $messageRepository
  ) {
  }

  public function handle(
    string $recipient,
    string $token,
  ): MessageReadModel|null {

    $message = $this->messageRepository->byLookup(
      lookupId: $token
    );

    if (!($message instanceof Message)) {
      return null;
    }

    try {
      $decryptedText = $this->encrypt->decrypt($message->getText());
      $decryptedRecipient = $this->encrypt->decrypt($message->getRecipient());
    } catch(\Exception $e) {
      return null;
    }

    if ($recipient !== $decryptedRecipient) {
      return null;
    }

    if ($message->getExpiryMode() === ExpireMode::READ_ONE_TIME->value) {
      $this->messageRepository->delete($message);
    }

    return new MessageReadModel(
      recipient: $decryptedRecipient,
      text: $decryptedText,
      expiry_mode: $message->getExpiryMode()
    );



  }
}
