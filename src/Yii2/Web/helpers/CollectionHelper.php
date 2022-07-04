<?php

namespace ZnTool\RestClient\Yii2\Web\helpers;

use ZnCore\Domain\Collection\Libs\Collection;
use ZnTool\RestClient\Domain\Entities\BookmarkEntity;
use ZnCore\Base\Arr\Helpers\ArrayHelper;

class CollectionHelper
{

    /**
     * @param \ZnCore\Domain\Collection\Interfaces\Enumerable | BookmarkEntity[] $collection
     * @return array
     */
    public static function prependCollection(Collection $collection)
    {
        $closure = function (BookmarkEntity $row) {
            $pureUri = ltrim($row->getUri(), '/');
            if (preg_match('|[^/]+|', $pureUri, $matches)) {
                return $matches[0];
            } else {
                return 'common';
            }
        };
        $collection = ArrayHelper::group($collection, $closure);
        return $collection;
    }

}