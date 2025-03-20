<?php

declare(strict_types=1);

namespace Book\Entity;

use User\Entity\User;
use User\Service\SubscribeService;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * @property int $id
 * @property int $author_id
 * @property string $title
 * @property string $description
 * @property string $isbn
 * @property string $published_at
 * @property string $image
 *
 * @property-read User $author
 */
class Book extends ActiveRecord
{
    public const string ATTR_ID = 'id';
    public const string ATTR_AUTHOR_ID = 'author_id';
    public const string ATTR_TITLE = 'title';
    public const string ATTR_DESCRIPTION = 'description';
    public const string ATTR_ISBN = 'isbn';
    public const string ATTR_PUBLISHED_AT = 'published_at';
    public const string ATTR_IMAGE = 'image';
    public const string ATTR_CREATED_AT = 'created_at';
    public const string ATTR_UPDATED_AT = 'updated_at';

    public static function create(
        int $author_id,
        string $title,
        string $description,
        string $isbn,
        string $published_at,
        string $image,
    ): self {
        return (new self())
            ->setAuthorId($author_id)
            ->setTitle($title)
            ->setDescription($description)
            ->setIsbn($isbn)
            ->setPublishedAt($published_at)
            ->setImage($image);
    }

    public static function tableName(): string
    {
        return 'books';
    }

    public function behaviors(): array
    {
        return [
            TimestampBehavior::class,
        ];
    }

    public function getEditableAttributes(): array
    {
        return [
            self::ATTR_TITLE => $this->getTitle(),
            self::ATTR_DESCRIPTION => $this->getDescription(),
            self::ATTR_ISBN => $this->getIsbn(),
            self::ATTR_PUBLISHED_AT => $this->getPublishedAt(),
        ];
    }

    public function afterSave($insert, $changedAttributes): void
    {
        \Yii::$container->get(SubscribeService::class)->notify($this);
    }

    #region getters/setters
    public function getId(): int
    {
        return $this->{self::ATTR_ID};
    }

    public function getAuthorId(): int
    {
        return $this->{self::ATTR_AUTHOR_ID};
    }

    public function setAuthorId(int $author_id): self
    {
        $this->{self::ATTR_AUTHOR_ID} = $author_id;
        return $this;
    }

    public function getTitle(): string
    {
        return $this->{self::ATTR_TITLE};
    }

    public function setTitle(string $title): self
    {
        $this->{self::ATTR_TITLE} = $title;
        return $this;
    }

    public function getDescription(): string
    {
        return $this->{self::ATTR_DESCRIPTION};
    }

    public function setDescription(string $description): self
    {
        $this->{self::ATTR_DESCRIPTION} = $description;
        return $this;
    }

    public function getIsbn(): string
    {
        return $this->{self::ATTR_ISBN};
    }

    public function setIsbn(string $isbn): self
    {
        $this->{self::ATTR_ISBN} = $isbn;
        return $this;
    }

    public function getPublishedAt(): string
    {
        return $this->{self::ATTR_PUBLISHED_AT};
    }

    public function setPublishedAt(string $published_at): self
    {
        $this->{self::ATTR_PUBLISHED_AT} = $published_at;
        return $this;
    }

    public function getImage(): string
    {
        return $this->{self::ATTR_IMAGE};
    }

    public function setImage(string $image): self
    {
        $this->{self::ATTR_IMAGE} = $image;
        return $this;
    }

    public function getImageUrl(): string
    {
        return $this->getImage() ?: 'book-no-image.png';
    }
    #endregion

    public function getAuthor(): ActiveQuery
    {
        return $this->hasOne(User::class, [User::ATTR_ID => self::ATTR_AUTHOR_ID]);
    }
}
