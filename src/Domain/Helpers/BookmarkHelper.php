<?php

namespace ZnTool\RestClient\Domain\Helpers;

use ZnCrypt\Base\Domain\Enums\HashAlgoEnum;
use ZnCrypt\Base\Domain\Helpers\SafeBase64Helper;
use ZnDatabase\Eloquent\Domain\Capsule\Manager;
use ZnTool\RestClient\Domain\Entities\BookmarkEntity;
use ZnTool\RestClient\Domain\Repositories\Eloquent\BookmarkRepository;
use ZnTool\RestClient\Domain\Services\BookmarkService;

class BookmarkHelper
{

    public static function sortArray(array &$array) {
        ksort($array);
        foreach ($array as &$item) {
            if(is_array($item)) {
                self::sortArray($item);
            }
        }
    }

    public static function arrayToString(array $array): string {
        self::sortArray($array);
        return json_encode($array);
    }

    public static function generateHash(BookmarkEntity $bookmarkEntity) {
        $scope =
            $bookmarkEntity->getProjectId() . '.' .
            $bookmarkEntity->getMethod() . '.' .
            $bookmarkEntity->getUri() . '.' .
            self::arrayToString($bookmarkEntity->getQuery()) . '.' .
            self::arrayToString($bookmarkEntity->getBody()) . '.' .
            self::arrayToString($bookmarkEntity->getHeader()) . '.' .
            $bookmarkEntity->getAuthorization();
        $hash = hash(HashAlgoEnum::SHA1, $scope, true);
        $base64 = SafeBase64Helper::encode($hash);
        return $base64;
    }

    public static function addRequestInHistory() {
        $data = [
            'project_id' => 1,
            'method' => $_SERVER['REQUEST_METHOD'],
            'uri' => $_SERVER['PATH_INFO'],
            'query' => $_GET,
            'body' => $_POST,
            'header' => [],
            'description' => '',
        ];
        $manager = new Manager;
        $bookmarkService = new BookmarkRepository($manager);
        $bookmarkService = new BookmarkService($bookmarkService);
        try {
            $bookmarkService->createOrUpdate($data);
        } catch (\Exception $e) {}
    }

}

