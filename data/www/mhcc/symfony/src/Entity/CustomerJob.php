<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CustomerJobRepository")
 */
class CustomerJob
{
    use TimestampableEntity;
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Title should not be blank")
     * @Assert\Length(
     *      min = 5,
     *      max = 50,
     *      minMessage = "Your title must be at least {{ limit }} characters long",
     *      maxMessage = "Your title cannot be longer than {{ limit }} characters"
     * )
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Zipcode should not be blank")
     * @Assert\Regex(
     *     pattern="/\d/",
     *     message="Your zipcode must be a number"
     * )
     * @Assert\Length(
     *      min = 5,
     *      max = 5,
     *      minMessage = "Your zipcode name must be at least {{ limit }} characters long",
     *      maxMessage = "Your zipcode name cannot be longer than {{ limit }} characters",
     *      exactMessage = "Your zipcode should have exactly {{ limit }} characters",
     * )
     */
    private $zipcode;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="The city should not be blank")
     */
    private $city;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="The description should not be blank")
     */
    private $description;

    /**
     * @ORM\Column(type="datetime")
     * @Assert\NotBlank(message="The delivery date should not be blank")
     */
    private $deliveryDate;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Service", inversedBy="customerJobs")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotBlank(message="The service should not be blank")
     */
    private $service;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getZipcode(): ?string
    {
        return $this->zipcode;
    }

    public function setZipcode(string $zipcode): self
    {
        $this->zipcode = $zipcode;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getDeliveryDate(): ?\DateTimeInterface
    {
        return $this->deliveryDate;
    }

    public function setDeliveryDate(\DateTimeInterface $deliveryDate): self
    {
        $this->deliveryDate = $deliveryDate;

        return $this;
    }

    public function getService(): ?Service
    {
        return $this->service;
    }

    public function setService(?Service $service): self
    {
        $this->service = $service;

        return $this;
    }
}
