<?php

namespace ZnTool\RestClient\Domain\Entities;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use ZnCore\Domain\Interfaces\Entity\ValidateEntityByMetadataInterface;

class QwerEntity implements ValidateEntityByMetadataInterface
{

    private $title = null;

    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {

    }

    public function setTitle($value)
    {
        $this->title = $value;
    }

    public function getTitle()
    {
        return $this->title;
    }


}

