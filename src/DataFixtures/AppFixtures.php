<?php

namespace App\DataFixtures;

use App\Entity\Emoji;
use App\Entity\EmojiCategory;
use App\Entity\User;
use App\Repository\EmojiCategoryRepository;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    private ObjectManager $manager;
    private EmojiCategoryRepository $categoryRepository;

    public function __construct(EmojiCategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function load(ObjectManager $manager): void
    {
        $this->manager = $manager;

        $this->loadUser();
        $this->loadEmojis();

        $this->manager->flush();
    }

    private function loadUser(): void
    {
        $user = (new User())
            ->setEmail('nialltiernan93@gmail.com')
            ->setUsername('nelly')
            ->setCreatedAt(new DateTimeImmutable())
        ;

        $this->manager->persist($user);
    }

    private function loadEmojis(): void
    {
        $smileys = (new EmojiCategory())
            ->setName('Smileys & Emotion (face-neutral-skeptical)')
        ;


        $grimacingFace = (new Emoji())
            ->setName('grimacing face')
            ->setHtml('&#128556;')
            ->setCategory($smileys)
        ;

        $zipperMouth = (new Emoji())
            ->setName('zipper-mouth face')
            ->setHtml('&#129296;')
            ->setCategory($smileys)
        ;

        $this->manager->persist($smileys);
        $this->manager->persist($grimacingFace);
        $this->manager->persist($zipperMouth);

        $flags = (new EmojiCategory())
            ->setName('(subdivision-flag)')
        ;

        $flagIreland = (new Emoji())
            ->setName('flag: Ireland')
            ->setHtml('&#127470;&#127466;')
            ->setCategory($flags)
        ;

        $this->manager->persist($flags);
        $this->manager->persist($flagIreland);
    }
}
