<?php

namespace App\DataPersister;

use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;
use App\Entity\Partner;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

final class PartnerDataPersister implements ContextAwareDataPersisterInterface
{

    private $em;
    private $encoder;

    public function __construct(EntityManagerInterface $em, UserPasswordEncoderInterface $encoder)
    {
        $this->em = $em;
        $this->encoder = $encoder;
    }

    public function supports($data, array $context = []): bool
    {
        return $data instanceof Partner;
    }

    public function persist($data, array $context = [])
    {
        $password = $this->encoder->encodePassword($data,$data->getPassword());
        $data->setPassword($password);
        $this->em->persist($data);
        $this->em->flush();
        return $data;
    }

    public function remove($data, array $context = [])
    {
        $this->em->remove($data);
        $this->em->flush();
    }
}