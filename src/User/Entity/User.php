<?php

declare(strict_types=1);

namespace User\Entity;

use Book\Entity\Book;
use Common\Exceptions\ModelNotFoundException;
use User\Repository\UserRepository;
use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * User model
 *
 * @property integer $id
 * @property string $username
 * @property string $password_hash
 * @property ?string $auth_key
 * @property string $email
 * @property string $phone
 * @property integer $created_at
 * @property integer $updated_at
 * @propertdy string $password write-only password
 *
 * @property string $statusName
 *
 * @property Book[] $books
 * @property User[] $subscribedAuthors
 * @property User[] $subscribedUsers
 */
class User extends ActiveRecord implements IdentityInterface
{
    public const string ATTR_ID = 'id';
    public const string ATTR_USERNAME = 'username';
    public const string ATTR_EMAIL = 'email';
    public const string ATTR_PHONE = 'phone';
    public const string ATTR_AUTH_KEY = 'auth_key';
    public const string ATTR_PASSWORD_HASH = 'password_hash';
    public const string ATTR_CREATED_AT = 'created_at';
    public const string ATTR_UPDATED_AT = 'updated_at';

    public int $books_count = 0;

    public static function create(
        string $username,
        string $email,
        string $phone,
        string $password
    ): User {
        $user = new self();
        $user->setUsername($username);
        $user->setEmail($email);
        $user->setPhone($phone);
        $user->generateAuthKey();
        $user->setPassword($password);
        return $user;
    }

    public static function tableName(): string
    {
        return 'users';
    }

    public function behaviors(): array
    {
        return [
            TimestampBehavior::class,
        ];
    }

    /**
     * @throws ModelNotFoundException
     */
    public static function findIdentity($id): ?self
    {
        return (new UserRepository())->getById($id);
    }

    /**
     * @throws NotSupportedException
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->{self::ATTR_ID};
    }

    public function getUsername(): string
    {
        return $this->{self::ATTR_USERNAME};
    }

    public function setUsername(string $username): self
    {
        $this->{self::ATTR_USERNAME} = $username;
        return $this;
    }

    public function getEmail(): string
    {
        return $this->{self::ATTR_EMAIL};
    }

    public function setEmail(string $email): self
    {
        $this->{self::ATTR_EMAIL} = $email;
        return $this;
    }

    public function getPhone(): string
    {
        return $this->{self::ATTR_PHONE};
    }

    public function setPhone(string $phone): self
    {
        $this->{self::ATTR_PHONE} = $phone;
        return $this;
    }

    public function getAuthKey(): ?string
    {
        return $this->{self::ATTR_AUTH_KEY};
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey): bool
    {
        return $this->getAuthKey() === $authKey;
    }

    public function validatePassword(string $password): bool
    {
        return Yii::$app->security->validatePassword($password, $this->{self::ATTR_PASSWORD_HASH});
    }

    public function setPassword($password): self
    {
        $this->{self::ATTR_PASSWORD_HASH} = Yii::$app->security->generatePasswordHash($password);
        return $this;
    }

    public function generateAuthKey(): void
    {
        $this->{self::ATTR_AUTH_KEY} = Yii::$app->security->generateRandomString();
    }

    #region Relations
    public function getBooks(): ActiveQuery
    {
        return $this->hasMany(Book::class, [Book::ATTR_AUTHOR_ID => self::ATTR_ID]);
    }

    public function getSubscribedAuthors(): ActiveQuery
    {
        return $this->hasMany(self::class, [self::ATTR_ID => 'author_id'])
            ->viaTable('user_author_subscriptions', ['user_id' => self::ATTR_ID])
            ->indexBy(self::ATTR_ID);
    }

    public function getSubscribedUsers(): ActiveQuery
    {
        return $this->hasMany(self::class, [self::ATTR_ID => 'user_id'])
            ->viaTable('user_author_subscriptions', ['author_id' => self::ATTR_ID]);
    }
    #endregion
}
