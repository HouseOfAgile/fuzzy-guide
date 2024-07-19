<?php

namespace HouseOfAgile\FuzzyGuide\Composer;

use Composer\Script\Event;
use Symfony\Component\Yaml\Yaml;

class ScriptHandler
{
    public static function copyScripts(Event $event)
    {
        $extra = $event->getComposer()->getPackage()->getExtra();
        $rootDir = isset($extra['symfony-root-dir']) ? $extra['symfony-root-dir'] : '.';

        // Read the configuration from the Symfony config file
        $configFile = $rootDir . '/config/packages/fuzzy_guide.yaml';
        if (file_exists($configFile)) {
            $config = Yaml::parseFile($configFile);
            $scriptTargetDir = $config['fuzzy_guide']['script_target_dir'];
        } else {
            $scriptTargetDir = isset($extra['script-target-dir']) ? $extra['script-target-dir'] : 'scripts';
        }

        $sourceDir = __DIR__ . '/../../scripts';
        $targetDir = $scriptTargetDir;

        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0755, true);
        }

        foreach (glob($sourceDir . '/*') as $file) {
            $fileName = basename($file);
            copy($file, $targetDir . '/' . $fileName);
        }

        $event->getIO()->write('<info>Scripts copied to ' . $targetDir . '</info>');
    }
}
