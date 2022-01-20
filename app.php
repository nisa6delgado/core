<?php

use DebugBar\DataCollector\PDO\PDOCollector;
use DebugBar\DataCollector\PDO\TraceablePDO;
use DebugBar\StandardDebugBar;
use Illuminate\Container\Container;
use Illuminate\Events\EventServiceProvider;
use Illuminate\Support\Facades\Facade;
use Illuminate\Http\Request;
use Illuminate\Routing\RoutingServiceProvider;
use Netflie\Componentes\Componentes;
use Spatie\Ignition\Ignition;

class App
{
    public static function run()
    {
        // General settings

        session_start();

        header('Access-Control-Allow-Origin: *');


        // Config

        $config = require 'app/config.php';

        foreach ($config as $key => $value) {
            $_ENV[$key] = $value;
        }

        $_ENV['view'] = false;

        Lang::set();

        date_default_timezone_set($_ENV['timezone']);

        // Debugbar

        include 'database.php';

        $debugbar = new StandardDebugBar();

        $collector = new PDOCollector();

        foreach ($_ENV['database'] as $database) {
            $pdo[$database['name']] = new TraceablePDO($capsule->getConnection($database['name'])->getPdo());
            $collector->addConnection($pdo[$database['name']], $database['name']);
        }

        $debugbar->addCollector($collector);

        $debugbarRenderer = $debugbar->getJavascriptRenderer();

        $_ENV['debugbar'] = [];


        // Errors

        if ($_ENV['errors'] == false) {
            error_reporting(0);
        } else {
            Ignition::make()->register();
        }


        // Container

        $app = new Container;
        Facade::setFacadeApplication($app);
        $app['app'] = $app;
        $app['env'] = 'production';
        with(new EventServiceProvider($app))->register();
        with(new RoutingServiceProvider($app))->register();


        // Router

        $route = $app['router'];
        include 'app/routes.php';

        $route->fallback(function () {
            if (file_exists($_SERVER['DOCUMENT_ROOT'] . '/resources/views/errors/404.blade.php')) {
                return view('errors/404');
            } else {
                $viewPath = realpath($_SERVER['DOCUMENT_ROOT'] . '/vendor/nisadelgado/framework/third/views');
                $componentes = Componentes::create($viewPath);

                $view = file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/vendor/nisadelgado/framework/third/views/404.blade.php');
                echo $componentes->render($view, []);
            }
        });

        if (file_exists('app/helpers.php')) {
            include 'app/helpers.php';
        }


        // Response

        $request  = Request::createFromGlobals();
        $response = $app['router']->dispatch($request);
        $response->send();

        unset($_SESSION['user']);

        if ($_ENV['view'] && $_ENV['errors']) {
            foreach ($_ENV['debugbar'] as $item) {
                $debugbar["messages"]->addMessage($item);
            }

            echo $debugbarRenderer->renderHead();

            $render = $debugbarRenderer->render();

            echo $render;
        }
    }
}
