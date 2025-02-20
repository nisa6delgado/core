<?php

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Style\SymfonyStyle;

class MakeFeature extends Command
{
    protected static $defaultName = 'make:feature';

    protected static $defaultDescription = 'Crea una nueva clase de feature';

    public function configure()
    {
        $this->addArgument('name', InputArgument::OPTIONAL);
    }

    protected function execute($input, $output)
    {
        $name = $input->getArgument('name');

        while (! $name) {
            $question = new Question("\n- ¿Cuál es el nombre del feature?\n> ");

            $helper = $this->getHelper('question');
            $name = $helper->ask($input, $output, $question);
        }

        $content = file_get_contents('vendor/base-php/core/commands/examples/feature.php');
        $content = str_replace('FeatureName', $name, $content);

        if (! file_exists('app/Features')) {
            mkdir('app/Features');
        }

        $fopen = fopen('app/Features/' . $name . '.php', 'w+');
        fwrite($fopen, $content);
        fclose($fopen);

        $style = new SymfonyStyle($input, $output);
        $style->success("Clase de feature '$name' creada satisfactoriamente.");

        return Command::SUCCESS;
    }
}
