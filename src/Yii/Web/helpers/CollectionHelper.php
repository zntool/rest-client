<?php

namespace ZnTool\RestClient\Yii\Web\helpers;

use Illuminate\Support\Collection;
use ZnTool\RestClient\Domain\Entities\BookmarkEntity;
use ZnCore\Base\Legacy\Yii\Helpers\ArrayHelper;

class CollectionHelper
{

    /**
     * @param Collection | BookmarkEntity[] $collection
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