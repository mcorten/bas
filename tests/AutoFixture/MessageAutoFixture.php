<?php

declare(strict_types=1);

namespace App\Tests\AutoFixture;

use App\Contract\ExpireMode;
use App\Entity\Message;

class MessageAutoFixture {

  public static function withPresets(string $text, string $recipient): Message {
    $message = new Message();
    $message->setText($text);
    $message->setRecipient($recipient);
    $message->setExpiryMode(ExpireMode::READ_ONE_TIME->value);

    return $message;

  }
}
