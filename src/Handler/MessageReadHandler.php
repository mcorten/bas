<?php

declare(strict_types=1);

namespace App\Handler;

use App\Contract\ExpireMode;
use App\Entity\Message;
use App\Entity\MessageReadModel;
use App\persistence\DeleteMessage;
use App\persistence\FindMessageByLookupId;
use App\persistence\MessageRepository;
use App\Shared\Encryptor\Encrypt;

readonly class MessageReadHandler {

  public function __construct(
    private Encrypt $encrypt,
    private FindMessageByLookupId $byLookupId,
    private DeleteMessage $delete,
  ) {
  }

  public function handle(
    string $recipient,
    string $token,
  ): MessageReadModel|null {

    $message = ($this->byLookupId)(
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
      ($this->delete)($message);
    }

    return new MessageReadModel(
      recipient: $decryptedRecipient,
      text: $decryptedText,
      expiry_mode: $message->getExpiryMode()
    );



  }
}
