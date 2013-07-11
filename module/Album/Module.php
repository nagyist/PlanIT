<?php
namespace Album;

class Module
{
    public function getAutoloaderConfig()
    {}

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }
}