<?php

namespace AppBundle\Entity;

use AppBundle\Exception\DinosaursAreRunningRampanException;
use AppBundle\Exception\NotABuffetException;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="enclosure")
 */
class Enclosure
{
    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity=Dinosaur::class, mappedBy="enclosure", cascade={"persist"})
     */
    private $dinosaurs;

    /**
     * @var Collection|Security[]
     * @ORM\OneToMany(targetEntity=Security::class, mappedBy="enclosure", cascade={"persist"})
     */
    private $securities;

    public function __construct(bool $withBasicSecurity = false)
    {
        $this->dinosaurs = new ArrayCollection();
        $this->securities = new ArrayCollection();

        if ($withBasicSecurity){
            $this->addSecurity(new Security('Fence', true, $this));
        }
    }

    /**
     * @return Collection|Dinosaur[]
     */
    public function getDinosaurs(): Collection
    {
        return $this->dinosaurs;
    }

    public function addDinosaur(Dinosaur $dinosaur)
    {
        if (!$this->canAddDinosaur($dinosaur)) {
            throw new NotABuffetException();
        }

        if (!$this->isSecurityActive()) {
            throw new DinosaursAreRunningRampanException("Are you craaazy?!?");
        }

        $this->dinosaurs[] = $dinosaur;
    }

    public function isSecurityActive(): bool
    {
        foreach ($this->securities as $security){
            if ($security->getIsActive()){
                return true;
            }
        }

        return false;
    }

    private function canAddDinosaur(Dinosaur $dinosaur): bool
    {
        return count($this->dinosaurs) === 0
            || $this->dinosaurs->first()->isCarnivorous() === $dinosaur->isCarnivorous();
    }

    public function addSecurity(Security $security)
    {
        $this->securities[] = $security;
    }


}