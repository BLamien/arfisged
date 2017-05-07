<?php

namespace AppBundle\Entity;

use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;

/**
 * Epi
 *
 * @ORM\Table(name="epi")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\EpiRepository")
 */
class Epi
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
     * @ORM\Column(name="nom", type="string", length=125)
     */
    private $nom;

    /**
     * @var int
     *
     * @ORM\Column(name="face", type="integer", nullable=true)
     */
    private $face;

    /**
     * @var int
     *
     * @ORM\Column(name="rayon", type="integer", nullable=true)
     */
    private $rayon;

    /**
     * @var string
     *
     * @Gedmo\Slug(fields={"nom","face","rayon"})
     * @ORM\Column(name="slug", type="string", length=125)
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
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Rayonnage", inversedBy="epis")
     * @ORM\JoinColumn(name="rayonnage_id", referencedColumnName="id")
     */
    private $rayonnage;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Definitive", mappedBy="epi")
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
     * @return Epi
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
     * Set face
     *
     * @param integer $face
     *
     * @return Epi
     */
    public function setFace($face)
    {
        $this->face = $face;

        return $this;
    }

    /**
     * Get face
     *
     * @return int
     */
    public function getFace()
    {
        return $this->face;
    }

    /**
     * Set rayon
     *
     * @param integer $rayon
     *
     * @return Epi
     */
    public function setRayon($rayon)
    {
        $this->rayon = $rayon;

        return $this;
    }

    /**
     * Get rayon
     *
     * @return int
     */
    public function getRayon()
    {
        return $this->rayon;
    }

    /**
     * Set slug
     *
     * @param string $slug
     *
     * @return Epi
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
     * @return Epi
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
     * @return Epi
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
     * @return Epi
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
     * @return Epi
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
     * Set rayonnage
     *
     * @param \AppBundle\Entity\Rayonnage $rayonnage
     *
     * @return Epi
     */
    public function setRayonnage(\AppBundle\Entity\Rayonnage $rayonnage = null)
    {
        $this->rayonnage = $rayonnage;

        return $this;
    }

    /**
     * Get rayonnage
     *
     * @return \AppBundle\Entity\Rayonnage
     */
    public function getRayonnage()
    {
        return $this->rayonnage;
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
     * @return Epi
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
