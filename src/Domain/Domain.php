<?php

namespace ZnTool\RestClient\Domain;

use ZnCore\Domain\Domain\Interfaces\DomainInterface;

class Domain implements DomainInterface
{

    public function getName()
    {
        return 'restClient';
    }
}

