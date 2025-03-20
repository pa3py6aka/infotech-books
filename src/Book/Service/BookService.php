<?php

declare(strict_types=1);

namespace Book\Service;

use Book\Entity\Book;
use Book\Forms\BookForm;
use Book\Repository\BookRepository;
use Common\Exceptions\ModelNotFoundException;
use Common\Exceptions\ModelSaveException;
use Common\Service\IFileService;
use DateTime;
use yii\db\Exception;
use yii\web\UploadedFile;

class BookService
{
    public function __construct(private BookRepository $repository, private IFileService $file_service)
    {
    }

    /**
     * @throws ModelNotFoundException
     */
    public function getById(int $id): Book
    {
        return $this->repository->getById($id);
    }

    public function create(BookForm $form, int $author_id): Book
    {
        if ($form->image instanceof UploadedFile) {
            $filename = $this->file_service->uploadFile($form->image);
        }

        $book = Book::create(
            author_id: $author_id,
            title: $form->title,
            description: $form->description,
            isbn: $form->isbn,
            published_at: (new DateTime($form->published_at))->format('Y-m-d'),
            image: $filename ?? '',
        );

        return $this->repository->save($book);
    }

    /**
     * @throws ModelNotFoundException
     * @throws Exception
     * @throws ModelSaveException
     */
    public function edit(int $id, BookForm $form): Book
    {
        $book = $this->repository->getById($id);

        if ($form->image instanceof UploadedFile) {
            // Удаляем старое изображение, если оно было
            if ($book->getImage() !== '') {
                $this->file_service->removeFile($book->getImage());
            }
            $filename = $this->file_service->uploadFile($form->image);
        }

        $book->setTitle($form->title)
            ->setDescription($form->description)
            ->setIsbn($form->isbn)
            ->setPublishedAt((new DateTime($form->published_at))->format('Y-m-d'))
            ->setImage($filename ?? $book->getImage());

        return $this->repository->save($book);
    }
}
