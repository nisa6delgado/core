<?php

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Style\SymfonyStyle;

class Env extends Command
{
    protected static $defaultName = 'env';

    protected static $defaultDescription = 'Muestra el entorno actual del framework';

    protected function execute($input, $output)
    {
        $config = require 'app/config.php';

        $environment = $config['environment'];

        $style = new SymfonyStyle($input, $output);
        $style->text("El entorno de la aplicación es [$environment].");
        $style->newLine();

        return Command::SUCCESS;
    }
}
