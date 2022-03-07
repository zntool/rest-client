<?php

namespace Migrations;

use Illuminate\Database\Schema\Blueprint;
use ZnDatabase\Migration\Domain\Base\BaseCreateTableMigration;
use ZnDatabase\Migration\Domain\Enums\ForeignActionEnum;

class m_2020_02_22_101059_create_authorization_table extends BaseCreateTableMigration
{

    protected $tableName = 'restclient_authorization';
    protected $tableComment = 'Авторизация на API';

    public function tableSchema()
    {
        return function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->comment('Идентификатор');
            $table->integer('project_id')->comment('ID проекта');
            $table->string('type')->comment('Тип авторизации (bearer, basic)');
            $table->string('username')->comment('Логин пользователя');
            $table->string('password')->comment('Пароль пользователя');

            $table->unique(['project_id', 'type', 'username']);

            $this->addForeign($table, 'project_id', 'restclient_project');

            /*$table
                ->foreign('project_id')
                ->references('id')
                ->on($this->encodeTableName('restclient_project'))
                ->onDelete(ForeignActionEnum::CASCADE)
                ->onUpdate(ForeignActionEnum::CASCADE);*/
        };
    }

}
