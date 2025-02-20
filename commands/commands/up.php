<?php

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Style\SymfonyStyle;

class Up extends Command
{
    protected static $defaultName = 'up';

    protected static $defaultDescription = 'Sacar la aplicación del modo de mantenimiento';

    protected function execute($input, $output)
    {
        $file = 'app/config.php';

        $string = file_get_contents($file);
        $string = str_replace("'maintenance' => true", "'maintenance' => false", $string);

        $fopen = fopen($file, 'w');
        fwrite($fopen, $string);
        fclose($fopen);

        $style = new SymfonyStyle($input, $output);
        $style->info('La aplicación ahora está activa.');

        return Command::SUCCESS;
    }
}
