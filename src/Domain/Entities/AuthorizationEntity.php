<?php

namespace ZnTool\RestClient\Domain\Entities;

use Symfony\Component\Validator\Mapping\ClassMetadata;
use ZnCore\Domain\Interfaces\Entity\EntityIdInterface;
use ZnCore\Domain\Interfaces\Entity\ValidateEntityByMetadataInterface;
use Symfony\Component\Validator\Constraints as Assert;

class AuthorizationEntity implements EntityIdInterface, ValidateEntityByMetadataInterface
{

    private $id = null;
    private $projectId = null;
    private $type = null;
    private $username = null;
    private $password = null;

    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraint('projectId', new Assert\NotBlank);
        $metadata->addPropertyConstraint('projectId', new Assert\Positive);
        $metadata->addPropertyConstraint('type', new Assert\NotBlank);
        $metadata->addPropertyConstraint('username', new Assert\NotBlank);
    }

    public function setId($value)
    {
        $this->id = $value;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setProjectId($value)
    {
        $this->projectId = $value;
    }

    public function getProjectId()
    {
        return $this->projectId;
    }

    public function setType($value)
    {
        $this->type = $value;
    }

    public function getType()
    {
        return $this->type;
    }

    public function setUsername($value)
    {
        $this->username = $value;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function setPassword($value)
    {
        $this->password = $value;
    }

    public function getPassword()
    {
        return $this->password;
    }

}

