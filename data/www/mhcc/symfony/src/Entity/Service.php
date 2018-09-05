<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ServiceRepository")
 */
class Service
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\CustomerJob", mappedBy="service")
     */
    private $customerJobs;

    public function __construct()
    {
        $this->customerJobs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection|CustomerJob[]
     */
    public function getCustomerJobs(): Collection
    {
        return $this->customerJobs;
    }

    public function addCustomerJob(CustomerJob $customerJob): self
    {
        if (!$this->customerJobs->contains($customerJob)) {
            $this->customerJobs[] = $customerJob;
            $customerJob->setService($this);
        }

        return $this;
    }

    public function removeCustomerJob(CustomerJob $customerJob): self
    {
        if ($this->customerJobs->contains($customerJob)) {
            $this->customerJobs->removeElement($customerJob);
            // set the owning side to null (unless already changed)
            if ($customerJob->getService() === $this) {
                $customerJob->setService(null);
            }
        }

        return $this;
    }
}
