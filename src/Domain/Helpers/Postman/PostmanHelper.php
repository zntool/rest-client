<?php

namespace ZnTool\RestClient\Domain\Helpers\Postman;

use ZnTool\RestClient\Domain\Entities\BookmarkEntity;
use yii\helpers\Json;
use yii\web\ServerErrorHttpException;
use ZnCore\Base\Legacy\Yii\Helpers\ArrayHelper;

class PostmanHelper {
	
	const POSTMAN_VERSION = '2.1';

    public static function splitByGroup($collection) {
        /** @var BookmarkEntity[] $collection */
        $list = [];
        foreach ($collection as $favorite) {
            $group = self::getGroup($favorite->getUri());
            $list[$group][] = $favorite;
        }
        return $list;
    }

    private static function getGroup($url, $index = 0) {
        return explode('/', $url)[$index];
    }

	public static function genFromCollection($groups, $apiVersion) {
		$groupCollection = [];

		foreach($groups as $groupName => $group) {
            //dd($group);
			/** @var BookmarkEntity $requestEntity */
			$groupData = [
				'name' => $groupName,
				'description' => '',
			];
			$items = [];
			foreach($group as $name => $requestEntity) {
				$request = GeneratorHelper::genRequest($requestEntity);
				$items[] = [
					'name' => $requestEntity->getUri() . ($request['description'] ? " ({$request['description']})" : ''),
					'event' => GeneratorHelper::genEvent(),
					'request' => $request,
					'response' => [],
				];
			}
			$groupData['item'] = $items;
			$groupCollection[] = $groupData;
		}

        $initItems = [
            'name' => 'init',
            'description' => 'Initialize',
            'item' => InitHelper::genCollection(),
        ];

		$authItems = [
			'name' => 'auth by',
			'description' => '',
			'item' => AuthorizationHelper::genAuthCollection(),
		];

		$groupCollection = ArrayHelper::merge([$authItems], $groupCollection);
        $groupCollection = ArrayHelper::merge([$initItems], $groupCollection);
		
		return [
			'info' => [
				'_postman_id' => StringHelper::genUuid(),
				'name' => MiscHelper::collectionName($apiVersion),
				'schema' => 'https://schema.getpostman.com/json/collection/v2.1.0/collection.json',
			],
			'item' => $groupCollection,
		];
	}
	
}