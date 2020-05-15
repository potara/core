<?php
/**
 * This file is part of the Potara (https://potara.org)
 *
 * @see       https://github.com/potara/core
 * @copyright Copyright (c) 2018-2020 Bruno Lima
 * @author    Bruno Lima <brunolimame@gmail.com>
 * @license   https://github.com/potara/core/blob/master/LICENSE (MIT License)
 */

namespace Potara\Core\Kernel;

use DI\Bridge\Slim\Bridge as SlimBridge;
use Potara\Core\Crud\ConfigModuleInterface;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;
use Symfony\Component\Yaml\Yaml;

class Kernel
{
    /** @var \Slim\App */
    public $app;

    public function __construct($conf = [])
    {
        $this->app  = SlimBridge::create();
        $kernelConf = new KernelConf($conf);
        $container  = $this->app->getContainer();
        $container->set('kernel-conf', $kernelConf);

        $loadedModules = $this->loadModules($kernelConf);

        $sequenceRegister = [
            'provider',
            'event',
            'middleware',
            'router'
        ];
        $eventDispatcher  = null;

        array_walk($sequenceRegister, function ($category) use (
            &$loadedModules, &$container, &$eventDispatcher
        ) {
            if ($container->has('event_dispatcher')) {
                $eventDispatcher = $container->get('event_dispatcher');
            }

            array_walk($loadedModules[$category], function ($args, $classname) use (&$category, &$container, &$eventDispatcher) {

                switch ($category) {
                    case 'provider':
                        (new $classname())->load($this->app, $args);
                        break;

                    case 'event':
                        (new $classname())->load($container, $eventDispatcher, $args);
                        break;

                    case 'middleware':
                        $prepareArgs = !is_array($args) && class_exists($args) ? new $args() : $args;
                        $this->app->add(new $classname($this->app, $prepareArgs));
                        break;

                    case 'router':
                        $this->factoryRouter($args, $classname);
                        break;
                }
            });
        });

    }

    /**
     * @param KernelConf $kernelConf
     *
     * @return array
     */
    public function loadModules(KernelConf $kernelConf) : array
    {

        $cacheFile = $kernelConf->cache . $kernelConf->cache_module_file;

        $reloadModules = true;
        if (!$kernelConf->ignore_cache_module) {
            if ($kernelConf->cache_module) {
                if (file_exists($cacheFile)) {
                    $listModulesEnable = Yaml::parseFile($cacheFile);
                    $reloadModules     = false;
                }
            }
        }

        if ($reloadModules) {
            $listModulesConfig = $this->findConfigModule($kernelConf->modules_path, $kernelConf->modules, ucfirst($kernelConf->modules));

            $listModulesEnable = array_reduce($listModulesConfig, function ($result, $confModule) {
                /** @var ConfigModuleInterface $confModule */
                if ($confModule::isEnable()) {
                    $result = array_merge_recursive($result, $confModule::getConf());
                }

                return $result;
            }, []);


            if ($kernelConf->cache_module) {
                /**
                 * Salvando dados em cache
                 *
                 * Saving data in cache
                 */
                $yamlContent = Yaml::dump($listModulesEnable);
                file_put_contents($cacheFile, $yamlContent);
            }

        }


        $this->app->getContainer()->set("modules_load", $listModulesEnable);

        return $listModulesEnable;

    }

    /**
     * Localiza o arquivo de configuração do módulo e converte em namespace
     *
     * Locates the module configuration file and converts namespace
     *
     * @param      $dir
     * @param      $flag
     * @param null $prefix
     *
     * @return array
     */
    protected function findConfigModule($dir, $flag, $prefix = null)
    {

        $filesConfigModule = (new Finder())->name('ConfigModule.php')->in($dir);

        return array_reduce(iterator_to_array($filesConfigModule), function ($result, SplFileInfo $file) use ($prefix, $flag) {

            if (preg_match_all("%{$flag}\\" . DIRECTORY_SEPARATOR . "(.*)%", $file->getPathname(), $mathFile)) {

                $namespace = "\\{$prefix}\\" . str_replace([
                        '.php',
                        '/'
                    ], [
                        '',
                        "\\"
                    ], current($mathFile[1]));

                if (class_exists($namespace)) {
                    $result[] = $namespace;
                }

            };
            return $result;
        }, []);
    }

    /**
     * @param $routerClass
     * @param $routerName
     */
    protected function factoryRouter($routerClass, $routerName) : void
    {
        /**
         * Se $routerClass for um array, reinicie o processo, caso não, crie o crupo de rotas
         * If $routerClass for an array, restart the process, if no, create the route group
         */
        if (is_array($routerClass)) {
            array_walk($routerClass, function ($router) use (&$routerName) {
                self::factoryRouter($router, $routerName);
            });
        } else {
            $nameRouter = "/";
            if ($routerName != '') {
                $nameRouter .= $routerName;
            }
            $this->app->group($nameRouter, $routerClass);
        }

    }
}
