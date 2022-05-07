<?php

namespace Migrations;

use Illuminate\Database\Schema\Blueprint;
use ZnDatabase\Migration\Domain\Base\BaseCreateTableMigration;
use ZnDatabase\Migration\Domain\Enums\ForeignActionEnum;

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

            $table->unique(['user_id', 'project_id']);

            $this->addForeign($table, 'project_id', 'restclient_project');
        };
    }

}
