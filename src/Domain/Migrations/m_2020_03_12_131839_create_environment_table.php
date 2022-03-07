<?php

namespace Migrations;

use Illuminate\Database\Schema\Blueprint;
use ZnDatabase\Migration\Domain\Base\BaseCreateTableMigration;
use ZnDatabase\Migration\Domain\Enums\ForeignActionEnum;

if ( ! class_exists(m_2020_03_12_131839_create_environment_table::class)) {

    class m_2020_03_12_131839_create_environment_table extends BaseCreateTableMigration
    {

        protected $tableName = 'restclient_environment';
        protected $tableComment = 'Окружение';

        public function tableSchema()
        {
            return function (Blueprint $table) {
                $table->integer('id')->autoIncrement()->comment('Идентификатор');
                $table->integer('project_id')->comment('ID проекта');
                $table->boolean('is_main')->default(false)->comment('Является ли окружением по умолчанию?');
                $table->string('title')->comment('Название');
                $table->string('url')->comment('URL для API');

                $table->unique(['project_id', 'url']);
                $table->unique(['project_id', 'title']);

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

}