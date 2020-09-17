<?php

return [
    'ZnTool\RestClient\Domain\Interfaces\Services\BookmarkServiceInterface' => 'ZnTool\RestClient\Domain\Services\BookmarkService',
    'ZnTool\RestClient\Domain\Interfaces\Repositories\BookmarkRepositoryInterface' => 'ZnTool\RestClient\Domain\Repositories\Eloquent\BookmarkRepository',
    'ZnTool\RestClient\Domain\Interfaces\Services\ProjectServiceInterface' => 'ZnTool\RestClient\Domain\Services\ProjectService',
    'ZnTool\RestClient\Domain\Interfaces\Repositories\ProjectRepositoryInterface' => 'ZnTool\RestClient\Domain\Repositories\Eloquent\ProjectRepository',
    'ZnTool\RestClient\Domain\Interfaces\Repositories\AccessRepositoryInterface' => 'ZnTool\RestClient\Domain\Repositories\Eloquent\AccessRepository',
    'ZnTool\RestClient\Domain\Interfaces\Services\AccessServiceInterface' => 'ZnTool\RestClient\Domain\Services\AccessService',
    'ZnTool\RestClient\Domain\Interfaces\Services\TransportServiceInterface' => 'ZnTool\RestClient\Domain\Services\TransportService',
    'ZnTool\RestClient\Domain\Interfaces\Services\AuthorizationServiceInterface' => 'ZnTool\RestClient\Domain\Services\AuthorizationService',
    'ZnTool\RestClient\Domain\Interfaces\Repositories\AuthorizationRepositoryInterface' => 'ZnTool\RestClient\Domain\Repositories\Eloquent\AuthorizationRepository',
    'ZnTool\RestClient\Domain\Interfaces\Services\EnvironmentServiceInterface' => 'ZnTool\RestClient\Domain\Services\EnvironmentService',
    'ZnTool\RestClient\Domain\Interfaces\Repositories\EnvironmentRepositoryInterface' => 'ZnTool\RestClient\Domain\Repositories\Eloquent\EnvironmentRepository',
];