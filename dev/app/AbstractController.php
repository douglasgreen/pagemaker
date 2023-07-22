<?php

namespace PageMakerDev;

/**
 * @class Base controller
 * @todo Add middleware for logging, authentication and error handling.
 */
abstract class AbstractController
{
    protected $request;
    protected $registry;
    protected function setRegistry(Registry $registry): void
    {
        $this->registry = $registry;
    }

    protected function setRequest(Request $request): void
    {
        $this->request = $request;
    }
}
