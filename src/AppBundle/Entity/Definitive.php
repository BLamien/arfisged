<?php

namespace AppBundle\Entity;

use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;

/**
 * Definitive
 *
 * @ORM\Table(name="definitive")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\DefinitiveRepository")
 */
class Definitive
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
     * @ORM\Column(name="libelle", type="string", length=255)
     */
    private $libelle;

    /**
     * @var string
     *
     * @ORM\Column(name="designation", type="text", nullable=true)
     */
    private $designation;

    /**
     * @var int
     *
     * @ORM\Column(name="rayon", type="integer", nullable=true)
     */
    private $rayon;

    /**
     * @var int
     *
     * @ORM\Column(name="position", type="integer", nullable=true)
     */
    private $position;

    /**
     * @var string
     *
     * @ORM\Column(name="extreme", type="string", length=15, nullable=true)
     */
    private $extreme;

    /**
     * @var string
     *
     * @ORM\Column(name="vie", type="string", length=255, nullable=true)
     */
    private $vie;

    /**
     * @var string
     *
     * @Gedmo\Slug(fields={"libelle","vie","extreme","position"})
     * @ORM\Column(name="slug", type="string", length=255)
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
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Provisoire", inversedBy="definitives")
     * @ORM\JoinColumn(name="provisoire_id", referencedColumnName="id")
     */
    private $provisoire;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Epi", inversedBy="definitives")
     * @ORM\JoinColumn(name="epi_id", referencedColumnName="id")
     */
    private $epi;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Sortfinal", inversedBy="definitives")
     * @ORM\JoinColumn(name="sortfinal_id", referencedColumnName="id")
     */
    private $sortfinal;


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
     * Set libelle
     *
     * @param string $libelle
     *
     * @return Definitive
     */
    public function setLibelle($libelle)
    {
        $this->libelle = $libelle;

        return $this;
    }

    /**
     * Get libelle
     *
     * @return string
     */
    public function getLibelle()
    {
        return $this->libelle;
    }

    /**
     * Set designation
     *
     * @param string $designation
     *
     * @return Definitive
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
     * Set rayon
     *
     * @param integer $rayon
     *
     * @return Definitive
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
     * Set position
     *
     * @param integer $position
     *
     * @return Definitive
     */
    public function setPosition($position)
    {
        $this->position = $position;

        return $this;
    }

    /**
     * Get position
     *
     * @return int
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * Set extreme
     *
     * @param string $extreme
     *
     * @return Definitive
     */
    public function setExtreme($extreme)
    {
        $this->extreme = $extreme;

        return $this;
    }

    /**
     * Get extreme
     *
     * @return string
     */
    public function getExtreme()
    {
        return $this->extreme;
    }

    /**
     * Set vie
     *
     * @param string $vie
     *
     * @return Definitive
     */
    public function setVie($vie)
    {
        $this->vie = $vie;

        return $this;
    }

    /**
     * Get vie
     *
     * @return string
     */
    public function getVie()
    {
        return $this->vie;
    }

    /**
     * Set slug
     *
     * @param string $slug
     *
     * @return Definitive
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
     * @return Definitive
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
     * @return Definitive
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
     * @return Definitive
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
     * @return Definitive
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
     * Set provisoire
     *
     * @param \AppBundle\Entity\Provisoire $provisoire
     *
     * @return Definitive
     */
    public function setProvisoire(\AppBundle\Entity\Provisoire $provisoire = null)
    {
        $this->provisoire = $provisoire;

        return $this;
    }

    /**
     * Get provisoire
     *
     * @return \AppBundle\Entity\Provisoire
     */
    public function getProvisoire()
    {
        return $this->provisoire;
    }

    /**
     * Set epi
     *
     * @param \AppBundle\Entity\Epi $epi
     *
     * @return Definitive
     */
    public function setEpi(\AppBundle\Entity\Epi $epi = null)
    {
        $this->epi = $epi;

        return $this;
    }

    /**
     * Get epi
     *
     * @return \AppBundle\Entity\Epi
     */
    public function getEpi()
    {
        return $this->epi;
    }

    /**
     * Set sortfinal
     *
     * @param \AppBundle\Entity\Sortfinal $sortfinal
     *
     * @return Definitive
     */
    public function setSortfinal(\AppBundle\Entity\Sortfinal $sortfinal = null)
    {
        $this->sortfinal = $sortfinal;

        return $this;
    }

    /**
     * Get sortfinal
     *
     * @return \AppBundle\Entity\Sortfinal
     */
    public function getSortfinal()
    {
        return $this->sortfinal;
    }
}
