<?php

namespace ZnTool\RestClient\Yii2\Web\helpers;

use ZnCore\Domain\Collection\Libs\Collection;
use ZnTool\RestClient\Domain\Entities\AuthorizationEntity;
use ZnCore\Base\Arr\Helpers\ArrayHelper;

class Authorization
{

    public static $password = 'Wwwqqq111';

    /**
     * @param Collection | AuthorizationEntity[] $collection
     * @return array
     */
    public static function collectionToOptions(Collection $collection)
    {
        $loginListForSelect = [];
        if ( ! empty($collection)) {
            foreach ($collection as $authorizationEntity) {
                $loginListForSelect[$authorizationEntity->getUsername()] = $authorizationEntity->getUsername();
            }
        }
        $loginListForSelect = ArrayHelper::merge(['' => 'Guest'], $loginListForSelect);
        return $loginListForSelect;
    }

}