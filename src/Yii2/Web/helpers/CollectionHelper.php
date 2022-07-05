<?php

namespace ZnTool\RestClient\Yii2\Web\helpers;

use ZnCore\Base\Arr\Helpers\ArrayHelper;
use ZnCore\Domain\Collection\Interfaces\Enumerable;
use ZnTool\RestClient\Domain\Entities\BookmarkEntity;

class CollectionHelper
{

    /**
     * @param Enumerable | BookmarkEntity[] $collection
     * @return array
     */
    public static function prependCollection(Enumerable $collection)
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