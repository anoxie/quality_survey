<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\QuestionnaireRepository")
 */
class Questionnaire
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $libelle;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="json", nullable=true)
     */
    private $model_mail = [];

    /**
     * @ORM\Column(type="json", nullable=true)
     */
    private $reminder_model_mail = [];

    /**
     * @ORM\Column(type="dateinterval", nullable=true)
     */
    private $reminder_time;

    /**
     * @ORM\Column(type="json")
     */
    private $questions_settings = [];

    /**
     * @ORM\Column(type="json", nullable=true)
     */
    private $stats_settings = [];

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Section", inversedBy="questionnaires")
     * @ORM\JoinColumn(nullable=false)
     */
    private $section;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Application", inversedBy="questionnaires")
     */
    private $applications;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Sondage", mappedBy="questionnaire", orphanRemoval=true)
     */
    private $sondages;

    public function __construct()
    {
        $this->applications = new ArrayCollection();
        $this->sondages = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): self
    {
        $this->libelle = $libelle;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getModelMail(): ?array
    {
        return $this->model_mail;
    }

    public function setModelMail(?array $model_mail): self
    {
        $this->model_mail = $model_mail;

        return $this;
    }

    public function getReminderModelMail(): ?array
    {
        return $this->reminder_model_mail;
    }

    public function setReminderModelMail(?array $reminder_model_mail): self
    {
        $this->reminder_model_mail = $reminder_model_mail;

        return $this;
    }

    public function getReminderTime(): ?\DateInterval
    {
        return $this->reminder_time;
    }

    public function setReminderTime(?\DateInterval $reminder_time): self
    {
        $this->reminder_time = $reminder_time;

        return $this;
    }

    public function getQuestionsSettings(): ?array
    {
        return $this->questions_settings;
    }

    public function setQuestionsSettings(array $questions_settings): self
    {
        $this->questions_settings = $questions_settings;

        return $this;
    }

    public function getStatsSettings(): ?array
    {
        return $this->stats_settings;
    }

    public function setStatsSettings(?array $stats_settings): self
    {
        $this->stats_settings = $stats_settings;

        return $this;
    }

    public function getSection(): ?Section
    {
        return $this->section;
    }

    public function setSection(?Section $section): self
    {
        $this->section = $section;

        return $this;
    }

    /**
     * @return Collection|Application[]
     */
    public function getApplications(): Collection
    {
        return $this->applications;
    }

    public function addApplication(Application $application): self
    {
        if (!$this->applications->contains($application)) {
            $this->applications[] = $application;
        }

        return $this;
    }

    public function removeApplication(Application $application): self
    {
        if ($this->applications->contains($application)) {
            $this->applications->removeElement($application);
        }

        return $this;
    }

    /**
     * @return Collection|Sondage[]
     */
    public function getSondages(): Collection
    {
        return $this->sondages;
    }

    public function addSondage(Sondage $sondage): self
    {
        if (!$this->sondages->contains($sondage)) {
            $this->sondages[] = $sondage;
            $sondage->setQuestionnaire($this);
        }

        return $this;
    }

    public function removeSondage(Sondage $sondage): self
    {
        if ($this->sondages->contains($sondage)) {
            $this->sondages->removeElement($sondage);
            // set the owning side to null (unless already changed)
            if ($sondage->getQuestionnaire() === $this) {
                $sondage->setQuestionnaire(null);
            }
        }

        return $this;
    }
}
