<?php

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;

class Migrate extends Command
{
    protected static $defaultName = 'migrate';

    protected static $defaultDescription = 'Migrate all files to database';

    public function configure()
    {
        $this->addArgument('file', InputArgument::OPTIONAL);
    }

    protected function execute($input, $output)
    {
        include 'vendor/nisadelgado/framework/database.php';

        $file = $input->getArgument('file');

        if ($file) {
            if (file_exists('database/' . $file)) {
                $schema = $capsule->schema();
                include 'database/' . $file;
                $output->writeln("<info>$file is ok.</info>");

            } else {
                $output->writeln("<error>The file '$file' does not exist.</error>");
            }

        } else {
            $scandir = scandir('database');

            foreach ($scandir as $item) {
                if (!is_dir($item)) {
                    $schema = $capsule->schema();
                    include 'database/' . $item;
                    $output->writeln("<info>$item is ok.</info>");
                }
            }
        }

        return Command::SUCCESS;
    }
}
