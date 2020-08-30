<?php

namespace App\Entity;

use App\Repository\JugadorRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=JugadorRepository::class)
 */
class Jugador
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $nombre;

    /**
     * @ORM\Column(type="integer")
     */
    private $equipoId;

    /**
     * @ORM\Column(type="integer")
     */
    private $posicionId;

    /**
     * @ORM\Column(type="float")
     */
    private $precio;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNombre(): ?string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre): self
    {
        $this->nombre = $nombre;

        return $this;
    }

    public function getEquipoId(): ?int
    {
        return $this->equipoId;
    }

    public function setEquipoId(int $equipoId): self
    {
        $this->equipoId = $equipoId;

        return $this;
    }

    public function getPosicionId(): ?int
    {
        return $this->posicionId;
    }

    public function setPosicionId(int $posicionId): self
    {
        $this->posicionId = $posicionId;

        return $this;
    }

    public function getPrecio(): ?float
    {
        return $this->precio;
    }

    public function setPrecio(float $precio): self
    {
        $this->precio = $precio;

        return $this;
    }
}
