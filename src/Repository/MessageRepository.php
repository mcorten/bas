<?php

declare(strict_types=1);

namespace App\Repository;

use App\Contract\ExpireMode;
use App\Entity\Message;
use App\Shared\Encryptor\Encrypt;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\DBAL\Types\ConversionException;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Message>
 */
class MessageRepository extends ServiceEntityRepository
{
  public function __construct(
    readonly ManagerRegistry $registry,
    private readonly EntityManagerInterface $em,
  )
  {
    parent::__construct($registry, Message::class);
  }

  public function create(
    string $text,
    string $recipient,
    ExpireMode $mode
  ): Message
  {
    $message = new Message();
    $message->setText($text);
    $message->setRecipient($recipient);
    $message->setExpiryMode($mode->value);

    $this->em->persist($message);
    $this->em->flush();

    return $message;
  }

  public function byLookup(string $lookupId): Message|null
  {
    try {
      return $this->findOneBy(['lookup' => $lookupId]);
    } catch(ConversionException $e) {
      // happens when the wrong lookup key is given
      return null;
    }
  }

  public function delete(Message $message): void
  {
    $this->em->remove($message);
    $this->em->flush();
  }
}
