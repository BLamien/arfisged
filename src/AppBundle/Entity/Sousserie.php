<?php

namespace AppBundle\Entity;

use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;

/**
 * Sousserie
 *
 * @ORM\Table(name="sousserie")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\SousserieRepository")
 */
class Sousserie
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
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Serie", inversedBy="sousseries")
     * @ORM\JoinColumn(name="serie_id", referencedColumnName="id")
     */
    private $serie;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Provisoire", mappedBy="sousserie")
     */
     private $provisoires;


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
     * @return Sousserie
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
     * @return Sousserie
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
     * @return Sousserie
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
     * @return Sousserie
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
     * @return Sousserie
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
     * @return Sousserie
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
     * @return Sousserie
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
     * Set serie
     *
     * @param \AppBundle\Entity\Serie $serie
     *
     * @return Sousserie
     */
    public function setSerie(\AppBundle\Entity\Serie $serie = null)
    {
        $this->serie = $serie;

        return $this;
    }

    /**
     * Get serie
     *
     * @return \AppBundle\Entity\Serie
     */
    public function getSerie()
    {
        return $this->serie;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->provisoires = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add provisoire
     *
     * @param \AppBundle\Entity\Provisoire $provisoire
     *
     * @return Sousserie
     */
    public function addProvisoire(\AppBundle\Entity\Provisoire $provisoire)
    {
        $this->provisoires[] = $provisoire;

        return $this;
    }

    /**
     * Remove provisoire
     *
     * @param \AppBundle\Entity\Provisoire $provisoire
     */
    public function removeProvisoire(\AppBundle\Entity\Provisoire $provisoire)
    {
        $this->provisoires->removeElement($provisoire);
    }

    /**
     * Get provisoires
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getProvisoires()
    {
        return $this->provisoires;
    }
}
