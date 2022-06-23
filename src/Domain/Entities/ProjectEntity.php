<?php

namespace ZnTool\RestClient\Domain\Entities;

use Symfony\Component\Validator\Mapping\ClassMetadata;
use ZnCore\Domain\Entity\Interfaces\EntityIdInterface;
use ZnCore\Base\Validation\Interfaces\ValidationByMetadataInterface;
use ZnCore\Base\Status\Enums\StatusEnum;
use Symfony\Component\Validator\Constraints as Assert;

class ProjectEntity implements EntityIdInterface, ValidationByMetadataInterface
{

    private $id = null;
    private $name = null;
    private $title = null;
    private $url = null;
    private $status = StatusEnum::ENABLED;

    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraint('name', new Assert\NotBlank);
        $metadata->addPropertyConstraint('name', new Assert\Regex(['pattern' => '/[a-zA-Z0-9-]+/i']));
        $metadata->addPropertyConstraint('title', new Assert\NotBlank);
        $metadata->addPropertyConstraint('status', new Assert\NotBlank);
    }

    public function setId($value)
    {
        $this->id = $value;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setName($value)
    {
        $this->name = $value;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setTitle($value)
    {
        $this->title = $value;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setUrl($value)
    {
        $this->url = $value;
    }

    public function getUrl()
    {
        return trim($this->url, '/');
    }

    public function setStatus($value)
    {
        $this->status = $value;
    }

    public function getStatus()
    {
        return $this->status;
    }

}
