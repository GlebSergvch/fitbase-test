<?php

use yii\db\Migration;

class m251028_205425_create_club_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%club}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'address' => $this->text(),
            'created_at' => $this->dateTime(),
            'created_by' => $this->integer(),
            'updated_at' => $this->dateTime(),
            'updated_by' => $this->integer(),
            'deleted_at' => $this->dateTime(),
            'deleted_by' => $this->integer(),
        ]);

        // Индексы
        $this->createIndex('{{%idx-club-name}}', '{{%club}}', 'name');
        $this->createIndex('{{%idx-club-created_by}}', '{{%club}}', 'created_by');
        $this->createIndex('{{%idx-club-updated_by}}', '{{%club}}', 'updated_by');
        $this->createIndex('{{%idx-club-deleted_by}}', '{{%club}}', 'deleted_by');

        // Внешние ключи
        $this->addForeignKey('{{%fk-club-created_by}}', '{{%club}}', 'created_by', '{{%user}}', 'id', 'SET NULL');
        $this->addForeignKey('{{%fk-club-updated_by}}', '{{%club}}', 'updated_by', '{{%user}}', 'id', 'SET NULL');
        $this->addForeignKey('{{%fk-club-deleted_by}}', '{{%club}}', 'deleted_by', '{{%user}}', 'id', 'SET NULL');
    }

    public function safeDown()
    {
        $this->dropForeignKey('{{%fk-club-created_by}}', '{{%club}}');
        $this->dropForeignKey('{{%fk-club-updated_by}}', '{{%club}}');
        $this->dropForeignKey('{{%fk-club-deleted_by}}', '{{%club}}');

        $this->dropIndex('{{%idx-club-name}}', '{{%club}}');
        $this->dropIndex('{{%idx-club-created_by}}', '{{%club}}');
        $this->dropIndex('{{%idx-club-updated_by}}', '{{%club}}');
        $this->dropIndex('{{%idx-club-deleted_by}}', '{{%club}}');

        $this->dropTable('{{%club}}');
    }
}