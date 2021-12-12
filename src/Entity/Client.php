<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiProperty;
use App\Repository\ClientRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use ApiPlatform\Core\Annotation\ApiResource;
use DateTime;


/**
 * @ORM\Entity(repositoryClass=ClientRepository::class)
 * @ApiResource(
 * attributes={"security" = "is_granted('ROLE_USER')" },
 * collectionOperations = {"get",
 * "post"={"messenger" = true,
 *  "output"=false,
 * "status"=202,
 *  "security" = "is_granted('ROLE_USER')"}}
 * )
 */
class Client implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @ApiProperty(identifier=true)
     */
    private $id;


    /**
     * @ORM\Column(type="string", length=255, unique=false)
     */
    private $name;


    /**
     * @ORM\Column(type="string", length=255, unique=false)
     */
    private $firstName;


    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;


    /**
     * @ORM\Column(type="datetime")
     * @ApiProperty(security= "is_granted('ROLE_ADMIN')")
     */
    protected $created;


    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Partner", inversedBy="clientCollection")
     */
    private $partner;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    /**
     * Get the value of name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the value of name
     *
     * @return  self
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }


    /**
     * Get the value of created
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set the value of created
     *
     * @return  self
     */
    public function setCreated($created = null)
    {
        $created = new \DateTime();
        $this->created = $created;

        return $this;
    }

    /**
     * Get the value of firstName
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set the value of firstName
     *
     * @return  self
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Get the value of partner
     */
    public function getPartner()
    {
        return $this->partner;
    }

    /**
     * Set the value of partner
     *
     * @return  self
     */
    public function setPartner($partner)
    {
        $this->partner = $partner;

        return $this;
    }
}
