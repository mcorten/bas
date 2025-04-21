<?php

declare(strict_types=1);

namespace App\Tests\feature;

use App\Handler\MessageReadHandler;
use App\Repository\MessageRepository;
use App\Shared\Encryptor\Adapter\EncryptAdapterInterface;
use App\Shared\Encryptor\Adapter\EncryptV1Adapter;
use App\Shared\Encryptor\Encrypt;
use App\Tests\AutoFixture\EncryptTestAdapter;
use App\Tests\AutoFixture\MessageAutoFixture;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class ReadMessageTest extends KernelTestCase {


  protected function setUp(): void
  {

  }

  /**
   * For now build a unit test,
   * I rather build a feature test, need to do more research how to get this to work with doctrine
   * @return void
   */
  public function testMessageShouldBeDecryptedAndCorrectlyMappedToReadModel(): void {
    // Given
    $recipient = "unit-test";
    $text = "this is a unit test";
    $token = "";

    // use a custom decrypt adapter especially made for unit testing
    $encryptAdapter = new EncryptTestAdapter();
    $encrypt = new Encrypt([$encryptAdapter]);
    $this->getContainer()->set(Encrypt::class, $encrypt);

    $message = MessageAutoFixture::withPresets(
      text: $encryptAdapter->encrypt($text),
      recipient: $encryptAdapter->encrypt($recipient),
    );
    $messageRepository = $this->createMock(MessageRepository::class);
    $messageRepository->expects($this->once())
      ->method('byLookup')
      ->will($this->returnValue($message));
    $this->getContainer()->set(MessageRepository::class, $messageRepository);

    // When
    /** @var MessageReadHandler $messageRead */
    $messageRead =  $this->getContainer()->get('App\Handler\MessageReadHandler');
    $result = $messageRead->handle(recipient: $recipient, token: $token);

    // Then
    $this->assertEquals($result->recipient, $recipient);
    $this->assertNotEquals($result->recipient, $message->getRecipient()); // $message->recipient = still encrypted

    $this->assertEquals($result->text, $text);
    $this->assertNotEquals($result->text, $message->getText()); // $message->text = still encrypted

    $this->assertEquals($result->expiry_mode, $message->getExpiryMode());
  }
}
