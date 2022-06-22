<?php

namespace ZnTool\RestClient\Domain\Entities;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use ZnCore\Base\Libs\Validation\Interfaces\ValidationByMetadataInterface;
use ZnCore\Domain\Entity\Interfaces\EntityIdInterface;

class EnvironmentEntity implements ValidationByMetadataInterface, EntityIdInterface
{

    private $id = null;
    private $projectId = null;
    private $isMain = false;
    private $title = null;
    private $url = null;

    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraint('title', new Assert\NotBlank);
        $metadata->addPropertyConstraint('url', new Assert\NotBlank);
    }

    public function setId($value) : void
    {
        $this->id = $value;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setProjectId($value) : void
    {
        $this->projectId = $value;
    }

    public function getProjectId()
    {
        return $this->projectId;
    }

    public function getIsMain()
    {
        return $this->isMain;
    }

    public function setIsMain($isMain)
    {
        $this->isMain = $isMain;
    }

    public function setTitle($value) : void
    {
        $this->title = $value;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setUrl($value) : void
    {
        $this->url = $value;
    }

    public function getUrl()
    {
        return $this->url;
    }

}
