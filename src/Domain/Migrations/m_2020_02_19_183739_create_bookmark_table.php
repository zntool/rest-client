<?php

namespace Migrations;

use Illuminate\Database\Schema\Blueprint;
use ZnDatabase\Migration\Domain\Base\BaseCreateTableMigration;
use ZnDatabase\Migration\Domain\Enums\ForeignActionEnum;

class m_2020_02_19_183739_create_bookmark_table extends BaseCreateTableMigration
{

    protected $tableName = 'restclient_bookmark';
    protected $tableComment = 'Избранное';

    public function tableSchema()
    {
        return function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->comment('Идентификатор');
            $table->string('hash')->comment('Хэш от (project_id.method.uri.query.body.header.authorization)');
            $table->integer('project_id')->comment('Проект');
            $table->string('method')->comment('Метод запроса');
            $table->string('uri')->comment('Внутренняя ссылка на ресурс');
            $table->text('query_data')->nullable()->comment('GET-параметры запроса');
            $table->text('body_data')->nullable()->comment('Тело запроса');
            $table->text('header_data')->nullable()->comment('Заголовки запроса');
            $table->string('authorization')->nullable()->comment('Авторизация');
            $table->string('description')->comment('Описание');
            $table->smallInteger('status')->comment('Статус');
            $table->unique(['hash']);

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
