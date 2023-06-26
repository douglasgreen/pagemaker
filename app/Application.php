<?php

namespace PageMaker;

// @todo Add plugin features to body builder
// The purpose of plugin architecture is separation of features and error checking.
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
            } catch (Throwable $e) {
                $output = "Error in " . $plugin->getName() . ": " . $e->getMessage();
            }
            // @todo Add to ID
        }
    }
}
