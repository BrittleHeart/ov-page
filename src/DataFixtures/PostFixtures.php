<?php

namespace App\DataFixtures;

use App\Entity\Blog\Attachment;
use App\Entity\Blog\Category;
use App\Entity\Blog\Comment;
use App\Entity\Blog\Post;
use App\Entity\Blog\Tag;
use App\Enum\Blog\PostStatusEnum;
use App\Repository\Blog\AttachmentRepository;
use App\Repository\Blog\CategoryRepository;
use App\Repository\Blog\CommentRepository;
use App\Repository\Blog\TagRepository;
use App\Traits\WithFaker;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

/**
 * @psalm-suppress PropertyNotSetInConstructor
 */
class PostFixtures extends Fixture implements DependentFixtureInterface, FixtureGroupInterface
{
    use WithFaker;

    private CommentRepository $commentRepository;
    private AttachmentRepository $attachmentRepository;
    private CategoryRepository $categoryRepository;
    private TagRepository $tagRepository;

    /**
     * @var array<PostStatusEnum>
     */
    protected static array $allowedStatues = [
        PostStatusEnum::Draft,
        PostStatusEnum::Published,
        PostStatusEnum::Archived,
    ];

    public function __construct(
        CommentRepository $commentRepository,
        AttachmentRepository $attachmentRepository,
        CategoryRepository $categoryRepository,
        TagRepository $tagRepository
    ) {
        $this->commentRepository = $commentRepository;
        $this->attachmentRepository = $attachmentRepository;
        $this->categoryRepository = $categoryRepository;
        $this->tagRepository = $tagRepository;
    }

    public function load(ObjectManager $manager): void
    {
        /** @var array<int, Comment> */
        $comments = $this->commentRepository->findAll();

        /** @var array<int, Attachment> */
        $attachments = $this->attachmentRepository->findAll();

        /** @var array<int, Category> */
        $categories = $this->categoryRepository->findAll();

        /** @var array<int, Tag> */
        $tags = $this->tagRepository->findAll();

        for ($i = 0; $i < 10; ++$i) {
            $post = new Post();
            $isPublished = $this->getFaker()->boolean(60);

            $attachments = $this->getFaker()->randomElements($attachments, 2);

            $post->setTitle($this->getFaker()->text(10));

            /*
             * @phpstan-ignore-next-line
             */
            $post->setAuthor($this->getReference(UserFixtures::ADMIN_USER_REFERENCE));
            /*
             * @phpstan-ignore-next-line
             */
            $post->setCategory($this->getFaker()->randomElement($categories));
            /* @phpstan-ignore-next-line */
            $post->addTag($this->getFaker()->randomElement($tags));
            $post->setLikes($this->getFaker()->numberBetween(0, 100));
            $post->setShares($this->getFaker()->numberBetween(0, 100));
            $post->setThumbnailUrl($this->getFaker()->imageUrl());
            $post->setDescription($this->getFaker()->text(100));
            $post->setContent($this->getFaker()->text(1000));
            $post->setPublishedAt($isPublished ? new \DateTimeImmutable() : null);
            /* @phpstan-ignore-next-line */
            $post->setStatus($this->getFaker()->randomElement(self::$allowedStatues)->value);
            foreach ($comments as $comment) {
                // Do not add comments to draft / archived posts
                if ($post->getStatus() === PostStatusEnum::Published->value) {
                    $post->addComment($comment);
                }
            }
            foreach ($attachments as $attachment) {
                $post->addAttachment($attachment);
            }

            $post->setCreatedAt(new \DateTimeImmutable());
            $manager->persist($post);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            UserFixtures::class,
            CategoryFixtures::class,
            TagFixtures::class,
            CommentFixtures::class,
            AttachmentFixtures::class,
        ];
    }

    public static function getGroups(): array
    {
        return ['blog'];
    }
}
