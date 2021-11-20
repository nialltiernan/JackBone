<?php

namespace App\Command;

use App\Entity\Emoji;
use App\Entity\EmojiCategory;
use App\Repository\EmojiCategoryRepository;
use App\Repository\EmojiRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Filesystem\Filesystem;

#[AsCommand(name: 'emoji:import', description: 'Imports emojis (and categories)')]
class ImportEmojisCommand extends Command
{
    private EmojiCategoryRepository $categoryRepo;
    private EntityManagerInterface $entityManager;
    private SymfonyStyle $io;
    private EmojiRepository $emojiRepo;

    public function __construct(
        EntityManagerInterface $entityManager,
        EmojiCategoryRepository $categoryRepo,
        EmojiRepository $emojiRepo,
        string $name = null
    ) {
        $this->categoryRepo = $categoryRepo;
        $this->entityManager = $entityManager;
        $this->emojiRepo = $emojiRepo;
        parent::__construct($name);
    }

    protected function configure(): void
    {
        $this->addArgument('inputFile', InputArgument::REQUIRED, 'Path to JSON file containing emojis');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->io = new SymfonyStyle($input, $output);

        $this->io->title('==== Emoji importer ====');

        if (!$this->doesFileExist($input->getArgument('inputFile'))) {
            $this->io->error('Specified file does not exist');
            return Command::FAILURE;
        }

        $data = $this->getDataFromFile($input->getArgument('inputFile'));
        $data = $this->stripData($data);

        $this->io->block('Data loaded from JSON');
        $this->io->table(['emoji', 'name', 'html', 'category'], array_slice($data, 0, 10));

        $categories = $this->getCategoriesFromData($data);

        $this->io->section('Importing categories');
        $this->io->progressStart(count($categories));
        $this->io->newLine(2);

        $this->importCategories($categories);

        $this->io->newLine(2);
        $this->io->section('Importing emojis');
        $this->io->progressStart(count($data));
        $this->io->newLine(2);

        $this->importEmojis($data);

        $this->io->newLine(3);
        $this->io->success('Import successful');
        return Command::SUCCESS;
    }

    private function doesFileExist(string $filename): bool
    {
        $filesystem = new Filesystem();
        return $filesystem->exists($filename);
    }

    private function getDataFromFile(string $filename): array
    {
        $data = json_decode(file_get_contents($filename), true);
        return $data['emojis'];
    }

    private function stripData(array $data): array
    {
        $stripped = [];
        foreach ($data as $datum) {
            unset($datum['shortname']);
            unset($datum['unicode']);
            unset($datum['order']);
            $stripped[] = $datum;
        }
        return $stripped;
    }

    private function getCategoriesFromData(array $data): array
    {
        $categories = [];
        foreach ($data as $datum) {
            if (in_array($datum['category'], $categories)) {
                continue;
            }
            $categories[] = $datum['category'];
        }
        return $categories;
    }

    private function importCategories(array $categories)
    {
        foreach ($categories as $category) {
            $this->io->progressAdvance();
            if ($this->categoryRepo->findBy(['name' => $category])) {
                continue;
            }
            $this->importCategory($category);
        }
        $this->entityManager->flush();
    }

    private function importCategory(string $name)
    {
        $category = new EmojiCategory();
        $category->setName($name);
        $this->entityManager->persist($category);
    }

    private function importEmojis(array $data)
    {
        foreach ($data as $datum) {
            $this->io->progressAdvance();
            if ($this->emojiRepo->findBy(['name' => $datum['name']])) {
                continue;
            }
            $this->importEmoji($datum);
        }
        $this->entityManager->flush();
    }

    private function importEmoji(array $datum)
    {
        $category = $this->categoryRepo->findOneBy(['name' => $datum['category']]);

        if (!$category) {
            $this->io->error('Category not found for: ' . $datum['name']);
            return;
        }

        $emoji = new Emoji();
        $emoji
            ->setName($datum['name'])
            ->setHtml($datum['html'])
            ->setCategory($category)
        ;

        $this->entityManager->persist($emoji);
    }
}
