<?php

namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Filesystem\Filesystem;

#[AsCommand(
    name: 'emoji:list-categories',
    description: 'Scans emoji list to find categories',
)]
class EmojiListCategoriesCommand extends Command
{
    protected function configure(): void
    {
        $this
            ->addArgument('inputFile', InputArgument::REQUIRED, 'Path to JSON file containing emojis')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $emojiFile = $input->getArgument('inputFile');

        $filesystem = new Filesystem();

        if (! $filesystem->exists($emojiFile)) {
            $io->error('Specified input file does not exist');
            return Command::FAILURE;
        }

        $categories = [];
        $data = json_decode(file_get_contents($emojiFile), true);
        $emojis = $data['emojis'];

        foreach ($emojis as $emoji) {
            $category = $emoji['category'];
            if (in_array($category, $categories)) {
                continue;
            }
            $categories[] = $category;
        }

        $io->info($categories);

        return Command::SUCCESS;
    }
}
