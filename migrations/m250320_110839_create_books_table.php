<?php

declare(strict_types=1);

use yii\db\Migration;

/**
 * Handles the creation of table `{{%books}}`.
 */
class m250320_110839_create_books_table extends Migration
{
    public function safeUp(): void
    {
        $this->createTable('books', [
            'id' => $this->primaryKey(),
            'author_id' => $this->integer()->unsigned()->notNull()->comment('ID автора'),
            'title' => $this->string()->notNull()->comment('Название книги'),
            'description' => $this->text()->notNull()->comment('Описание книги'),
            'isbn' => $this->string(13)->notNull()->unique()->comment('ISBN'),
            'published_at' => $this->date()->notNull()->comment('Дата публикации'),
            'image' => $this->string()->defaultValue('')->comment('Фото главной страницы'),

            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);

        $this->createIndex('idx-books-author_id', 'books', 'author_id');
        $this->createIndex('idx-books-published_at', 'books', 'published_at');
    }

    public function safeDown(): void
    {
        $this->dropTable('books');
    }
}
