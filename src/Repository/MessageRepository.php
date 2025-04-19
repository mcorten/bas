<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Message;
use App\Shared\Encryptor\Encrypt;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
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
    string $mode // TODO enum
  ): Message
  {
    $message = new Message();
    $message->setText($text);
    $message->setRecipient($recipient);
    $message->setExpiryMode($mode);

    $this->em->persist($message);
    $this->em->flush();

    return $message;
  }

  public function byLookup(string $lookupId): Message|null
  {
    return $this->findOneBy(['lookupId' => $lookupId]);
  }
}
