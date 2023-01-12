<?php

namespace App\Command;

use App\Enum\EnvironmentTypeEnum;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Exception\CommandNotFoundException;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'setup:database',
    description: 'Set up your database for a various environment',
)]
class SetupDatabaseCommand extends Command
{
    protected function configure(): void
    {
        // ...
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        /** @var string|null $environmentOption */
        $environmentOption = $input->getOption('env');
        $application = $this->getApplication();
        if (null === $application) {
            throw new CommandNotFoundException('Application instance is null');
        }

        /** @var string $currentEnv */
        $currentEnv = EnvironmentTypeEnum::DEVELOPMENT->value;
        if (null !== $environmentOption) {
            $currentEnv = $environmentOption;
        }

        $io->info("Setting up the database for the `{$currentEnv}` environment");

        /**
         * @var array<array-key, Command> $databaseCommands
         */
        $databaseCommands = [
            $application->find('doctrine:database:drop'),
            $application->find('doctrine:database:create'),
            $application->find('doctrine:schema:create'),
        ];

        $arguments = ['--env' => $currentEnv];

        if ('doctrine:database:drop' === $databaseCommands[0]->getName()) {
            $arguments['--if-exists'] = true;
            $arguments['--force'] = true;

            $databaseCommands[0]->run(new ArrayInput($arguments), $output);
            $io->success('Database dropped successfully');

            unset($arguments['--if-exists']);
            unset($arguments['--force']);
            array_shift($databaseCommands);
        }

        $input = new ArrayInput($arguments);
        foreach ($databaseCommands as $command) {
            if (Command::SUCCESS !== $command->run($input, $output)) {
                $io->error('An error occurred while setting up the database');

                return Command::FAILURE;
            }

            $io->success('Database setup successfully');
        }

        echo "All done 😎. Enjoy \n";

        return Command::SUCCESS;
    }
}
