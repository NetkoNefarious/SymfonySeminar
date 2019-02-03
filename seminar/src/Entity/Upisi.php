<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Upisi
 *
 * @ORM\Table(name="upisi", indexes={@ORM\Index(name="predmet_id", columns={"predmet_id"}), @ORM\Index(name="student_id", columns={"student_id"})})
 * @ORM\Entity
 */
class Upisi
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="status", type="string", length=64, nullable=false)
     */
    private $status;

    /**
     * @var \Korisnici
     *
     * @ORM\ManyToOne(targetEntity="Korisnik")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="student_id", referencedColumnName="id")
     * })
     */
    private $student;

    /**
     * @var \Predmeti
     *
     * @ORM\ManyToOne(targetEntity="Predmet")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="predmet_id", referencedColumnName="id")
     * })
     */
    private $predmet;

    //region Getteri i setteri
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getStudent(): ?Korisnik
    {
        return $this->student;
    }

    public function setStudent(?Korisnik $student): self
    {
        $this->student = $student;

        return $this;
    }

    public function getPredmet(): ?Predmet
    {
        return $this->predmet;
    }

    public function setPredmet(?Predmet $predmet): self
    {
        $this->predmet = $predmet;

        return $this;
    }
    //endregion
}
