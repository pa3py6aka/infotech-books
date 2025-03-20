<?php

declare(strict_types=1);

use yii\db\Migration;

/**
 * Handles the creation of table `{{%users}}`.
 */
class m250319_185547_create_users_table extends Migration
{
    public function up(): void
    {
        $this->createTable('users', [
            'id' => $this->primaryKey()->unsigned(),
            'username' => $this->string()->notNull(),
            'email' => $this->string()->notNull(),
            'phone' => $this->string(20)->notNull(),

            'password_hash' => $this->string()->notNull(),
            'auth_key' => $this->string(32)->notNull(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);

        $this->createIndex('users-username-unique', 'users', 'username', true);
        $this->createIndex('users-email-unique', 'users', 'email', true);

        $this->createTable('user_author_subscriptions', [
            'user_id' => $this->integer()->unsigned()->notNull(),
            'author_id' => $this->integer()->unsigned()->notNull(),
        ]);

        // Индекс для поиска по user_id
        $this->createIndex('idx-users_author_subscriptions-user_id', 'user_author_subscriptions', 'user_id');
        // Уникальный индекс по двум полям
        $this->createIndex('idx-users_author_subscriptions-unique', 'user_author_subscriptions', ['user_id', 'author_id'], true);

        // Связку по foreign keys я не добавляю, это замедляет БД, лучше следить за связанными таблицами в коде
    }

    public function down(): void
    {
        $this->dropTable('user_author_subscriptions');
        $this->dropTable('users');
    }
}
