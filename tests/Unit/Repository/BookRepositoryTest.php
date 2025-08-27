<?php

namespace App\Tests\Integration\Repository;

use App\Entity\Book;
use App\Repository\BookRepository;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class BookRepositoryTest extends KernelTestCase
{
    /**
     * Test que la base de données fonctionne
     */
    public function testBookRepository(): void
    {
        self::bootKernel();
        $entityManager = static::getContainer()->get('doctrine')->getManager();


    $book = new Book();
    $book->setTitle('Test Book');
    $book->setImage('test-image.jpg');
    $book->setDescription('Description de test');
    $book->setPages(123); // Ajout du nombre de pages pour respecter la contrainte NOT NULL
        $entityManager->persist($book);
        $entityManager->flush();

        $bookRepository = static::getContainer()->get(BookRepository::class);
        $foundBook = $bookRepository->findOneBy(['title' => 'Test Book']);

        $this->assertNotNull($foundBook);
        $this->assertEquals('Test Book', $foundBook->getTitle());
    }
}
