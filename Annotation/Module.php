<?php

namespace Padam87\ModuleBundle\Annotation;

/**
 * Represents a @Module annotation.
 *
 * @Annotation
 * @Target("METHOD")
 */
final class Module
{
    public $modules;

    public function __construct(array $values)
    {
        if (isset($values['value'])) {
            $values['modules'] = $values['value'];
        }
        if (!isset($values['modules'])) {
            throw new \InvalidArgumentException('You must define a "modules" attribute for each Module annotation.');
        }

        $this->modules = array_map('trim', explode(',', $values['modules']));
    }
}
