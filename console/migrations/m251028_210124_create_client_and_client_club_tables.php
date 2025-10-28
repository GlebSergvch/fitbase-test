<?php

use yii\db\Migration;

class m251028_210124_create_client_and_client_club_tables extends Migration
{
    public function safeUp()
    {
        // Таблица клиента
        $this->createTable('{{%client}}', [
            'id' => $this->primaryKey(),
            'full_name' => $this->string()->notNull(),
            'gender' => $this->string(6)->notNull()->check("gender IN ('male', 'female')"),
            'birth_date' => $this->date(),
            'created_at' => $this->integer(),
            'created_by' => $this->integer(),
            'updated_at' => $this->integer(),
            'updated_by' => $this->integer(),
            'deleted_at' => $this->integer(),
            'deleted_by' => $this->integer(),
        ]);

        // Связующая таблица: клиент ↔ клубы
        $this->createTable('{{%client_club}}', [
            'client_id' => $this->integer()->notNull(),
            'club_id' => $this->integer()->notNull(),
            'PRIMARY KEY(client_id, club_id)',
        ]);

        // Индексы для client
        $this->createIndex('{{%idx-client-full_name}}', '{{%client}}', 'full_name');
        $this->createIndex('{{%idx-client-gender}}', '{{%client}}', 'gender');
        $this->createIndex('{{%idx-client-birth_date}}', '{{%client}}', 'birth_date');
        $this->createIndex('{{%idx-client-created_by}}', '{{%client}}', 'created_by');
        $this->createIndex('{{%idx-client-updated_by}}', '{{%client}}', 'updated_by');
        $this->createIndex('{{%idx-client-deleted_by}}', '{{%client}}', 'deleted_by');

        // Индексы для client_club
        $this->createIndex('{{%idx-client_club-club_id}}', '{{%client_club}}', 'club_id');

        // Внешние ключи для client
        $this->addForeignKey(
            '{{%fk-client-created_by}}',
            '{{%client}}',
            'created_by',
            '{{%user}}',
            'id',
            'SET NULL'
        );

        $this->addForeignKey(
            '{{%fk-client-updated_by}}',
            '{{%client}}',
            'updated_by',
            '{{%user}}',
            'id',
            'SET NULL'
        );

        $this->addForeignKey(
            '{{%fk-client-deleted_by}}',
            '{{%client}}',
            'deleted_by',
            '{{%user}}',
            'id',
            'SET NULL'
        );

        // Внешние ключи для client_club
        $this->addForeignKey(
            '{{%fk-client_club-client_id}}',
            '{{%client_club}}',
            'client_id',
            '{{%client}}',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->addForeignKey(
            '{{%fk-client_club-club_id}}',
            '{{%client_club}}',
            'club_id',
            '{{%club}}',
            'id',
            'CASCADE',
            'CASCADE'
        );
    }

    public function safeDown()
    {
        // Удаляем внешние ключи
        $this->dropForeignKey('{{%fk-client_club-client_id}}', '{{%client_club}}');
        $this->dropForeignKey('{{%fk-client_club-club_id}}', '{{%client_club}}');
        $this->dropForeignKey('{{%fk-client-created_by}}', '{{%client}}');
        $this->dropForeignKey('{{%fk-client-updated_by}}', '{{%client}}');
        $this->dropForeignKey('{{%fk-client-deleted_by}}', '{{%client}}');

        // Удаляем индексы
        $this->dropIndex('{{%idx-client_club-club_id}}', '{{%client_club}}');
        $this->dropIndex('{{%idx-client-full_name}}', '{{%client}}');
        $this->dropIndex('{{%idx-client-gender}}', '{{%client}}');
        $this->dropIndex('{{%idx-client-birth_date}}', '{{%client}}');
        $this->dropIndex('{{%idx-client-created_by}}', '{{%client}}');
        $this->dropIndex('{{%idx-client-updated_by}}', '{{%client}}');
        $this->dropIndex('{{%idx-client-deleted_by}}', '{{%client}}');

        // Удаляем таблицы
        $this->dropTable('{{%client_club}}');
        $this->dropTable('{{%client}}');

        return true;
    }
}
