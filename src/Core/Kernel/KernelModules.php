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

use Potara\Core\Crud\ConfigModuleInterface;
use Slim\App;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;
use Symfony\Component\Yaml\Yaml;

class KernelModules
{
    public function load(App &$app)
    {
        /** @var KernelConf $kernelConf */
        $kernelConf = $app->getContainer()
                          ->get('kernel-conf');


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

            $listModulesEnable = array_reduce($listModulesConfig, function ($result, $confModule)
            {
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


        $app->getContainer()
            ->set("modules_load", $listModulesEnable);


        return $this;

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

        $filesConfigModule = (new Finder())->name('ConfigModule.php')
                                           ->in($dir);

        return array_reduce(iterator_to_array($filesConfigModule), function ($result, SplFileInfo $file) use ($prefix, $flag)
        {

            if (preg_match_all("%{$flag}\/(.*)%", $file->getPathname(), $mathFile)) {

                $namespace = "\\{$prefix}\\" . str_replace(['.php', '/'], ['', "\\"], current($mathFile[1]));

                if (class_exists($namespace)) {
                    $result[] = $namespace;
                }
            };
            return $result;
        }, []);
    }
}