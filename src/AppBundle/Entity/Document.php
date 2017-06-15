<?php

namespace AppBundle\Entity;

use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;

/**
 * Document
 *
 * @ORM\Table(name="document")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\DocumentRepository")
 */
class Document
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
     * @ORM\Column(name="reference", type="string", length=255, nullable=true)
     */
    private $reference;

    /**
     * @var string
     *
     * @ORM\Column(name="libelle", type="string", length=255)
     */
    private $libelle;

    /**
     * @var string
     *
     * @ORM\Column(name="resume", type="text", nullable=true)
     */
    private $resume;

    /**
     * @var string
     *
     * @ORM\Column(name="tags", type="text", nullable=true)
     */
    private $tags;

    /**
     * @var string
     *
     * @ORM\Column(name="dateprod", type="string", length=10, nullable=true)
     */
    private $dateprod;

    /**
     * @var string
     *
     * @ORM\Column(name="datefin", type="string", length=10, nullable=true)
     */
    private $datefin;

    /**
     * @var bool
     *
     * @ORM\Column(name="transfert", type="boolean", nullable=true)
     */
    private $transfert;

    /**
     * @var bool
     *
     * @ORM\Column(name="partage", type="boolean", nullable=true)
     */
    private $partage;

    /**
     * @var bool
     *
     * @ORM\Column(name="stagiaire", type="boolean", nullable=true)
     */
    private $stagiaire;

    /**
     * @var bool
     *
     * @ORM\Column(name="assistant", type="boolean", nullable=true)
     */
    private $assistant;

    /**
     * @var bool
     *
     * @ORM\Column(name="adjoint", type="boolean", nullable=true)
     */
    private $adjoint;

    /**
     * @var bool
     *
     * @ORM\Column(name="chef", type="boolean", nullable=true)
     */
    private $chef;

    /**
     * @var string
     *
     * @Gedmo\Slug(fields={"libelle","reference"})
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
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Rubrique", inversedBy="documents")
     * @ORM\JoinColumn(name="rubrique_id", referencedColumnName="id")
     */
    private $rubrique;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Sortfinal", inversedBy="documents")
     * @ORM\JoinColumn(name="sortfinal_id", referencedColumnName="id")
     */
    private $sortfinal;

    /**
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Piecejointe", cascade={"persist", "remove"})
     */
     private $piecejointe;


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
     * Set reference
     *
     * @param string $reference
     *
     * @return Document
     */
    public function setReference($reference)
    {
        $this->reference = strtoupper($reference);

        return $this;
    }

    /**
     * Get reference
     *
     * @return string
     */
    public function getReference()
    {
        return $this->reference;
    }

    /**
     * Set libelle
     *
     * @param string $libelle
     *
     * @return Document
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
     * Set resume
     *
     * @param string $resume
     *
     * @return Document
     */
    public function setResume($resume)
    {
        $this->resume = $resume;

        return $this;
    }

    /**
     * Get resume
     *
     * @return string
     */
    public function getResume()
    {
        return $this->resume;
    }

    /**
     * Set tags
     *
     * @param string $tags
     *
     * @return Document
     */
    public function setTags($tags)
    {
        $this->tags = $tags;

        return $this;
    }

    /**
     * Get tags
     *
     * @return string
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * Set dateprod
     *
     * @param string $dateprod
     *
     * @return Document
     */
    public function setDateprod($dateprod)
    {
        $this->dateprod = $dateprod;

        return $this;
    }

    /**
     * Get dateprod
     *
     * @return string
     */
    public function getDateprod()
    {
        return $this->dateprod;
    }

    /**
     * Set datefin
     *
     * @param string $datefin
     *
     * @return Document
     */
    public function setDatefin($datefin)
    {
        $this->datefin = $datefin;

        return $this;
    }

    /**
     * Get datefin
     *
     * @return string
     */
    public function getDatefin()
    {
        return $this->datefin;
    }

    /**
     * Set transfert
     *
     * @param boolean $transfert
     *
     * @return Document
     */
    public function setTransfert($transfert)
    {
        $this->transfert = $transfert;

        return $this;
    }

    /**
     * Get transfert
     *
     * @return bool
     */
    public function getTransfert()
    {
        return $this->transfert;
    }

    /**
     * Set partage
     *
     * @param boolean $partage
     *
     * @return Document
     */
    public function setPartage($partage)
    {
        $this->partage = $partage;

        return $this;
    }

    /**
     * Get partage
     *
     * @return bool
     */
    public function getPartage()
    {
        return $this->partage;
    }

    /**
     * Set stagiaire
     *
     * @param boolean $stagiaire
     *
     * @return Document
     */
    public function setStagiaire($stagiaire)
    {
        $this->stagiaire = $stagiaire;

        return $this;
    }

    /**
     * Get stagiaire
     *
     * @return bool
     */
    public function getStagiaire()
    {
        return $this->stagiaire;
    }

    /**
     * Set assistant
     *
     * @param boolean $assistant
     *
     * @return Document
     */
    public function setAssistant($assistant)
    {
        $this->assistant = $assistant;

        return $this;
    }

    /**
     * Get assistant
     *
     * @return bool
     */
    public function getAssistant()
    {
        return $this->assistant;
    }

    /**
     * Set adjoint
     *
     * @param boolean $adjoint
     *
     * @return Document
     */
    public function setAdjoint($adjoint)
    {
        $this->adjoint = $adjoint;

        return $this;
    }

    /**
     * Get adjoint
     *
     * @return bool
     */
    public function getAdjoint()
    {
        return $this->adjoint;
    }

    /**
     * Set chef
     *
     * @param boolean $chef
     *
     * @return Document
     */
    public function setChef($chef)
    {
        $this->chef = $chef;

        return $this;
    }

    /**
     * Get chef
     *
     * @return bool
     */
    public function getChef()
    {
        return $this->chef;
    }

    /**
     * Set slug
     *
     * @param string $slug
     *
     * @return Document
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
     * @return Document
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
     * @return Document
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
     * @return Document
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
     * @return Document
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
     * Set service
     *
     * @param \AppBundle\Entity\Service $service
     *
     * @return Document
     */
    public function setService(\AppBundle\Entity\Service $service = null)
    {
        $this->service = $service;

        return $this;
    }

    /**
     * Get service
     *
     * @return \AppBundle\Entity\Service
     */
    public function getService()
    {
        return $this->service;
    }

    /**
     * Set rubrique
     *
     * @param \AppBundle\Entity\Rubrique $rubrique
     *
     * @return Document
     */
    public function setRubrique(\AppBundle\Entity\Rubrique $rubrique = null)
    {
        $this->rubrique = $rubrique;

        return $this;
    }

    /**
     * Get rubrique
     *
     * @return \AppBundle\Entity\Rubrique
     */
    public function getRubrique()
    {
        return $this->rubrique;
    }

    /**
     * Set sortfinal
     *
     * @param \AppBundle\Entity\Sortfinal $sortfinal
     *
     * @return Document
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
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->piecejointe = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add piecejointe
     *
     * @param \AppBundle\Entity\Piecejointe $piecejointe
     *
     * @return Document
     */
    public function addPiecejointe(\AppBundle\Entity\Piecejointe $piecejointe)
    {
        $this->piecejointe[] = $piecejointe;

        return $this;
    }

    /**
     * Remove piecejointe
     *
     * @param \AppBundle\Entity\Piecejointe $piecejointe
     */
    public function removePiecejointe(\AppBundle\Entity\Piecejointe $piecejointe)
    {
        $this->piecejointe->removeElement($piecejointe);
    }

    /**
     * Get piecejointe
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPiecejointe()
    {
        return $this->piecejointe;
    }
}
