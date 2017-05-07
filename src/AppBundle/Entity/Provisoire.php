<?php

namespace AppBundle\Entity;

use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;

/**
 * Provisoire
 *
 * @ORM\Table(name="provisoire")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ProvisoireRepository")
 */
class Provisoire
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=25, unique=true)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="designation", type="text", nullable=true)
     */
    private $designation;

    /**
     * @var string
     *
     * @Gedmo\Slug(fields={"nom"})
     * @ORM\Column(name="slug", type="string", length=25)
     */
    private $slug;

    /**
     * @var string
     *
     * @Gedmo\Blameable(on="create")
     * @ORM\Column(name="publie_par", type="string", length=25, nullable=true)
     */
    private $publiePar;

    /**
     * @var string
     *
     * @Gedmo\Blameable(on="update")
     * @ORM\Column(name="modifie_par", type="string", length=25, nullable=true)
     */
    private $modifiePar;

    /**
     * @var \DateTime
     *
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(name="publie_le", type="datetimetz", nullable=true)
     */
    private $publieLe;

    /**
     * @var \DateTime
     *
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(name="modifie_le", type="datetimetz", nullable=true)
     */
    private $modifieLe;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Conservation", inversedBy="provisoires")
     * @ORM\JoinColumn(name="conservation_id", referencedColumnName="id")
     */
    private $conservation;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Sousserie", inversedBy="provisoires")
     * @ORM\JoinColumn(name="sousserie_id", referencedColumnName="id")
     */
    private $sousserie;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Definitive", mappedBy="provisoire")
     */
     private $definitives;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set nom
     *
     * @param string $nom
     *
     * @return Provisoire
     */
    public function setNom($nom)
    {
        $this->nom = strtoupper($nom);

        return $this;
    }

    /**
     * Get nom
     *
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set designation
     *
     * @param string $designation
     *
     * @return Provisoire
     */
    public function setDesignation($designation)
    {
        $this->designation = $designation;

        return $this;
    }

    /**
     * Get designation
     *
     * @return string
     */
    public function getDesignation()
    {
        return $this->designation;
    }

    /**
     * Set slug
     *
     * @param string $slug
     *
     * @return Provisoire
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get slug
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Set publiePar
     *
     * @param string $publiePar
     *
     * @return Provisoire
     */
    public function setPubliePar($publiePar)
    {
        $this->publiePar = $publiePar;

        return $this;
    }

    /**
     * Get publiePar
     *
     * @return string
     */
    public function getPubliePar()
    {
        return $this->publiePar;
    }

    /**
     * Set modifiePar
     *
     * @param string $modifiePar
     *
     * @return Provisoire
     */
    public function setModifiePar($modifiePar)
    {
        $this->modifiePar = $modifiePar;

        return $this;
    }

    /**
     * Get modifiePar
     *
     * @return string
     */
    public function getModifiePar()
    {
        return $this->modifiePar;
    }

    /**
     * Set publieLe
     *
     * @param \DateTime $publieLe
     *
     * @return Provisoire
     */
    public function setPublieLe($publieLe)
    {
        $this->publieLe = $publieLe;

        return $this;
    }

    /**
     * Get publieLe
     *
     * @return \DateTime
     */
    public function getPublieLe()
    {
        return $this->publieLe;
    }

    /**
     * Set modifieLe
     *
     * @param \DateTime $modifieLe
     *
     * @return Provisoire
     */
    public function setModifieLe($modifieLe)
    {
        $this->modifieLe = $modifieLe;

        return $this;
    }

    /**
     * Get modifieLe
     *
     * @return \DateTime
     */
    public function getModifieLe()
    {
        return $this->modifieLe;
    }

    /**
     * Set conservation
     *
     * @param \AppBundle\Entity\Conservation $conservation
     *
     * @return Provisoire
     */
    public function setConservation(\AppBundle\Entity\Conservation $conservation = null)
    {
        $this->conservation = $conservation;

        return $this;
    }

    /**
     * Get conservation
     *
     * @return \AppBundle\Entity\Conservation
     */
    public function getConservation()
    {
        return $this->conservation;
    }

    /**
     * Set sousserie
     *
     * @param \AppBundle\Entity\Sousserie $sousserie
     *
     * @return Provisoire
     */
    public function setSousserie(\AppBundle\Entity\Sousserie $sousserie = null)
    {
        $this->sousserie = $sousserie;

        return $this;
    }

    /**
     * Get sousserie
     *
     * @return \AppBundle\Entity\Sousserie
     */
    public function getSousserie()
    {
        return $this->sousserie;
    }

    public function __toString() {
        return $this->getNom();
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->definitives = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add definitive
     *
     * @param \AppBundle\Entity\Definitive $definitive
     *
     * @return Provisoire
     */
    public function addDefinitive(\AppBundle\Entity\Definitive $definitive)
    {
        $this->definitives[] = $definitive;

        return $this;
    }

    /**
     * Remove definitive
     *
     * @param \AppBundle\Entity\Definitive $definitive
     */
    public function removeDefinitive(\AppBundle\Entity\Definitive $definitive)
    {
        $this->definitives->removeElement($definitive);
    }

    /**
     * Get definitives
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getDefinitives()
    {
        return $this->definitives;
    }
}
