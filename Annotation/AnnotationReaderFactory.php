<?php
namespace Padam87\ModuleBundle\Annotation;

use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Annotations\IndexedReader;
use Doctrine\Common\Annotations\AnnotationRegistry;

/**
 * Custom annotation reader for Netlife annotations
 */
class AnnotationReaderFactory
{
    /**
     * Creates a preconfigured annotation reader, only for Module annotations, ignores others
     * @return $AnnotationReader \Doctrine\Common\Annotations\AnnotationReader
     */
    public static function create()
    {
        AnnotationRegistry::registerAutoloadNamespace("\Padam87\ModuleBundle\Annotation", __DIR__);

        $AnnotationReader = new IndexedReader(new AnnotationReader());

        return $AnnotationReader;
    }
}
