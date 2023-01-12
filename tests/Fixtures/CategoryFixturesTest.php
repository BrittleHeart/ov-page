<?php

namespace App\Tests\Fixtures;

use App\DataFixtures\CategoryFixtures;
use App\Entity\Blog\Category;
use App\Repository\Blog\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Liip\TestFixturesBundle\Services\DatabaseToolCollection;
use Liip\TestFixturesBundle\Services\DatabaseTools\AbstractDatabaseTool;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class CategoryFixturesTest extends KernelTestCase
{
    private AbstractDatabaseTool $databaseTool;
    private CategoryRepository $categoryRepository;
    private EntityManagerInterface $entityManager;
    
    public function setUp(): void
    {
        parent::setUp();

        $this->databaseTool = self::getContainer()->get(DatabaseToolCollection::class)->get();
        $this->entityManager = self::getContainer()->get(EntityManagerInterface::class);
        $this->categoryRepository = $this->entityManager->getRepository(Category::class);
    }

    public function testCreateNewCategory(): void
    {
        $this->databaseTool->loadFixtures([
            CategoryFixtures::class
        ]);

        $categories = $this->categoryRepository->findAll();
        if(0 === count($categories)) {
            $this->fail('No categories were found');
        }


        $category = new Category();
        $category->setName('ważne');
        $this->categoryRepository->save($category);
        
        $this->assertGreaterThan(0, $categories);
        $this->assertEquals('ważne', $category->getName());
    }
}
