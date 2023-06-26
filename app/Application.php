<?php

namespace PageMaker;

// @todo Add plugin features to body builder
class Application
{
    protected $plugins = [];

    public static function isCli(): bool
    {
        return php_sapi_name() === 'cli';
    }

    public function registerPlugin(string $id, BasePlugin $plugin) {
        $this->plugins[$id][] = $plugin;
    }

    public function run() {
        foreach ($this->plugins as $plugin) {
            try {
                $output = $plugin->render();
            } catch (Exception $e) {
                $output = "Error in " . $plugin->getName() . ": " . $e->getMessage();
            }
            // @todo Add to ID
        }
    }
}
