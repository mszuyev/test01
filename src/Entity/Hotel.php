<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\HotelRepository")
 */
class Hotel implements \JsonSerializable
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=127)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=511)
     */
    private $address;

    /**
     * @ORM\Column(type="integer")
     */
    private $rooms = 0;

    /**
     * @ORM\Column(type="integer", nullable=false)
     */
    private $chain_id = 0;

    /**
     * @ORM\Column(type="string", length=63)
     */
    private $uuid;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\HotelChain", inversedBy="hotels",cascade={"persist"})
     */
    private $chain;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(string $id): self
    {
        $this->id = $id;

        return $this;
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

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getRooms(): ?int
    {
        return $this->rooms;
    }

    public function setRooms(int $rooms): self
    {
        $this->rooms = $rooms;

        return $this;
    }

    public function getChainId(): ?int
    {
        return $this->chain_id;
    }

    public function setChainId(int $chain_id): self
    {
        $this->chain_id = $chain_id;

        return $this;
    }

    public function getUuid()
    {
        return $this->uuid;
    }

    public function setUuid($uuid): self
    {
        $this->uuid = $uuid;

        return $this;
    }

    public function jsonSerialize()
    {
        return array(
            'id'       => $this->id,
            'name'     => $this->name,
            'address'  => $this->address,
            'rooms'    => $this->rooms,
            'chain_id' => $this->chain_id,
            'uuid'     => $this->uuid,
        );
    }

    public function getChain(): ?HotelChain
    {
        return $this->chain;
    }

    public function setChain(?HotelChain $chain): self
    {
        $this->chain = $chain;

        return $this;
    }

}
