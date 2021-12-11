<?php

namespace App\Entity;

use App\Repository\GenderRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: GenderRepository::class)]
class Gender
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\OneToMany(mappedBy: 'gender', targetEntity: Flashlight::class, orphanRemoval: true)]
    private Collection $flashlights;

    #[ORM\OneToMany(mappedBy: 'gender', targetEntity: Trip::class, orphanRemoval: true)]
    private Collection $trips;

    public function __construct()
    {
        $this->flashlights = new ArrayCollection();
        $this->trips = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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
     * @return Collection<int, Flashlight>
     */
    public function getFlashlights(): Collection
    {
        return $this->flashlights;
    }

    public function addFlashlight(Flashlight $flashlight): self
    {
        if (!$this->flashlights->contains($flashlight)) {
            $this->flashlights->add($flashlight);
            $flashlight->setGender($this);
        }

        return $this;
    }

    public function removeFlashlight(Flashlight $flashlight): self
    {
        if ($this->flashlights->removeElement($flashlight)) {
            // set the owning side to null (unless already changed)
            if ($flashlight->getGender() === $this) {
                $flashlight->setGender(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Trip>
     */
    public function getTrips(): Collection
    {
        return $this->trips;
    }

    public function addTrip(Trip $trip): self
    {
        if (!$this->trips->contains($trip)) {
            $this->trips->add($trip);
            $trip->setGender($this);
        }

        return $this;
    }

    public function removeTrip(Trip $trip): self
    {
        if ($this->trips->removeElement($trip)) {
            // set the owning side to null (unless already changed)
            if ($trip->getGender() === $this) {
                $trip->setGender(null);
            }
        }

        return $this;
    }
}
