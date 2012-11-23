<?php

namespace Padam87\ModuleBundle\Twig;

use Padam87\ModuleBundle\Listener\ModuleListener;
use Padam87\ModuleBundle\Entity\Module;

class ModuleExtension extends \Twig_Extension
{
	protected $moduleListener;
	protected $modules = array();
	
	public function __construct(ModuleListener $moduleListener)
	{
		$this->moduleListener = $moduleListener;
	}
	
	public function getFunctions()
    {
        return array(
            'module_active' => new \Twig_Function_Method($this, 'isActive')
        );
    }
	
	public function getName()
	{
		return 'module_manager';
	}
	
	public function isActive($module)
	{
		return $this->moduleListener->isActive($module);
	}
}
