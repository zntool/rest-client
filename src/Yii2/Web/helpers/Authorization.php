<?php

namespace ZnTool\RestClient\Yii2\Web\helpers;

use ZnCore\Base\Arr\Helpers\ArrayHelper;
use ZnCore\Collection\Interfaces\Enumerable;
use ZnTool\RestClient\Domain\Entities\AuthorizationEntity;

class Authorization
{

    public static $password = 'Wwwqqq111';

    /**
     * @param Enumerable | AuthorizationEntity[] $collection
     * @return array
     */
    public static function collectionToOptions(Enumerable $collection)
    {
        $loginListForSelect = [];
        if (!empty($collection)) {
            foreach ($collection as $authorizationEntity) {
                $loginListForSelect[$authorizationEntity->getUsername()] = $authorizationEntity->getUsername();
            }
        }
        $loginListForSelect = ArrayHelper::merge(['' => 'Guest'], $loginListForSelect);
        return $loginListForSelect;
    }

}