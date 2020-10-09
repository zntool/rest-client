<?php

namespace Migrations;

use Illuminate\Database\Schema\Blueprint;
use ZnLib\Migration\Domain\Base\BaseCreateTableMigration;
use ZnLib\Migration\Domain\Enums\ForeignActionEnum;

class m_2020_02_21_100830_create_access_table extends BaseCreateTableMigration
{

    protected $tableName = 'restclient_access';
    protected $tableComment = 'Доступы к проектам';

    public function tableSchema()
    {
        return function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->comment('Идентификатор');
            $table->integer('user_id')->comment('Пользователь');
            $table->integer('project_id')->comment('Проект');
            $table
                ->foreign('project_id')
                ->references('id')
                ->on($this->encodeTableName('restclient_project'))
                ->onDelete(ForeignActionEnum::CASCADE)
                ->onUpdate(ForeignActionEnum::CASCADE);
            $table->unique(['user_id', 'project_id']);
        };
    }

}
