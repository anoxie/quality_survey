<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SondageRepository")
 */
class Sondage
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $token;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email_interviewed;

    /**
     * @ORM\Column(type="json", nullable=true)
     */
    private $responses = [];

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $sent_at;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $completed_at;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Questionnaire", inversedBy="sondages")
     * @ORM\JoinColumn(nullable=false)
     */
    private $questionnaire;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="sondages")
     */
    private $created_by;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getToken(): ?string
    {
        return $this->token;
    }

    public function setToken(?string $token): self
    {
        $this->token = $token;

        return $this;
    }

    public function getEmailInterviewed(): ?string
    {
        return $this->email_interviewed;
    }

    public function setEmailInterviewed(string $email_interviewed): self
    {
        $this->email_interviewed = $email_interviewed;

        return $this;
    }

    public function getResponses(): ?array
    {
        return $this->responses;
    }

    public function setResponses(?array $responses): self
    {
        $this->responses = $responses;

        return $this;
    }

    public function getSentAt(): ?\DateTimeInterface
    {
        return $this->sent_at;
    }

    public function setSentAt(?\DateTimeInterface $sent_at): self
    {
        $this->sent_at = $sent_at;

        return $this;
    }

    public function getCompletedAt(): ?\DateTimeInterface
    {
        return $this->completed_at;
    }

    public function setCompletedAt(?\DateTimeInterface $completed_at): self
    {
        $this->completed_at = $completed_at;

        return $this;
    }

    public function getQuestionnaire(): ?Questionnaire
    {
        return $this->questionnaire;
    }

    public function setQuestionnaire(?Questionnaire $questionnaire): self
    {
        $this->questionnaire = $questionnaire;

        return $this;
    }

    public function getCreatedBy(): ?User
    {
        return $this->created_by;
    }

    public function setCreatedBy(?User $created_by): self
    {
        $this->created_by = $created_by;

        return $this;
    }
}
