<?php
namespace Padam87\ModuleBundle\Listener;

use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Padam87\ModuleBundle\Annotation\AnnotationReaderFactory;
use Doctrine\ORM\EntityManager;

class ModuleListener
{
    protected $_em;
    protected $modules = array();

    public function __construct(EntityManager $em)
    {
        $this->_em = $em;

        $ModuleRepository = $this->_em->getRepository('Padam87ModuleBundle:Module');

        $Modules = $ModuleRepository->findAll();

        foreach ($Modules as $Module) {
            $this->modules[$Module->__toString()] = $Module->getActive();
        }
    }

    public function onCoreController(FilterControllerEvent $event)
    {
        if (!is_array($controller = $event->getController())) {
            return;
        }

        $AnnotationReader = AnnotationReaderFactory::create();
        $annotation = $AnnotationReader->getMethodAnnotation(
            new \ReflectionMethod($controller[0], $controller[1]),
            'Padam87\ModuleBundle\Annotation\Module'
        );

        if (!$annotation) {
            return;
        }

        foreach ($annotation->modules as $module) {
            if (!$this->isActive($module)) {
                throw new \Exception($module . " is inactive");
            }
        }
    }

    public function isActive($module)
    {
        return isset($this->modules[$module]) ? $this->modules[$module] : false;
    }

    public function getModules()
    {
        return $this->modules;
    }
}
