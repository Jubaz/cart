<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ItemRepository")
 */
class Item
{

    const TYPE_PHYSICAL = 'physical';
    const TYPE_SALE = 'sale';

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", columnDefinition="ENUM('physical', 'sale')")
     */
    private $type;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\Column(type="integer")
     */
    private $price;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\ItemSale", mappedBy="item", cascade={"persist", "remove"})
     */
    private $itemSale;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\ItemPhysical", mappedBy="item", cascade={"persist", "remove"})
     */
    private $itemPhysical;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        if (!in_array($type, array(self::TYPE_PHYSICAL, self::TYPE_SALE))) {
            throw new \InvalidArgumentException("Invalid status");
        }

        $this->type = $type;

        return $this;
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

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getItemSale(): ?ItemSale
    {
        return $this->itemSale;
    }

    public function setItemSale(ItemSale $itemSale): self
    {
        $this->itemSale = $itemSale;

        // set the owning side of the relation if necessary
        if ($this !== $itemSale->getItem()) {
            $itemSale->setItem($this);
        }

        return $this;
    }

    public function getItemPhysical(): ?ItemPhysical
    {
        return $this->itemPhysical;
    }

    public function setItemPhysical(ItemPhysical $itemPhysical): self
    {
        $this->itemPhysical = $itemPhysical;

        // set the owning side of the relation if necessary
        if ($this !== $itemPhysical->getItem()) {
            $itemPhysical->setItem($this);
        }

        return $this;
    }

}
