<?php
namespace Padam87\ModuleBundle\Controller;
 
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Padam87\ModuleBundle\Entity;
use Padam87\ModuleBundle\Annotation\Module;

/**
 * @Route("/modules")
 */
class AdminController extends Controller
{
	/**
     * @Route("/")
	 * @Template()
	 */
	public function indexAction(Request $request)
	{
        $this->_em = $this->getDoctrine()->getEntityManager();
		$Builder = $this->createFormBuilder();
		
		foreach($this->container->getParameter('modules') as $module_name => $module) {
			$options = array(
				'expanded'	=> true,
				'multiple'	=> true,
				'choices'	=> array(),
				'label'		=> $this->get('translator')->trans(implode(".", array('modules', $module_name))),
			);
			
			foreach($module as $submodule_name => $is_active) {
				if(!$is_active) continue;
				$options['choices'][$submodule_name] = $this->get('translator')->trans(
                    implode(".", array('modules', $module_name, $submodule_name))
                );
			}
			
			$Builder->add($module_name, 'choice', $options);
		}
        
		$Builder->setData($this->convertToForm());
		
		$form = $Builder->getForm();

		if($request->getMethod() == 'POST') {
			$form->bindRequest($request);
			
			$data = $form->getData();
			
			$modules = array();
			
			foreach($data as $module_name => $module) {
				if(!isset($modules[$module_name])) $modules[$module_name] = array();
				foreach($module as $submodule_name) {
					if(!isset($modules[$module_name][$submodule_name])) $modules[$module_name][$submodule_name] = true;
				}
			}
			
			foreach($this->container->getParameter('modules') as $module_name => $module) {
				if(!isset($modules[$module_name])) $modules[$module_name] = array();
				foreach($module as $submodule_name => $is_active) {	
					if(!isset($modules[$module_name][$submodule_name])) $modules[$module_name][$submodule_name] = false;
				}
			}
			
			$modules = $this->convertToDb($modules);
            
            $ModuleRepository = $this->_em->getRepository('Padam87ModuleBundle:Module');
		
            foreach($modules as $name => $is_active) {			
                $Module = $ModuleRepository->findOneBy(array('name' => $name));

                if($Module == null) {
                    $Module = new Entity\Module();
                }

                $Module->setName($name);
                $Module->setActive($is_active);

                $this->_em->persist($Module);
            }

            $this->_em->flush();
			
			$this->get('session')->setFlash('success', $this->get('translator')->trans('messages.save.successful'));
			return $this->redirect($this->generateUrl('padam87_module_admin_index'));
		}
		
		return array(
			'form' => $form->createView(),
		);
	}
	
	public function convertToForm()
	{
		$modules = array();
		
		foreach($this->get('module.listener')->getModules() as $module => $is_active) {
			$module = explode(".", $module);
			
			if(!isset($modules[$module[0]])) $modules[$module[0]] = array();
			
			if($is_active) $modules[$module[0]][] = $module[1];
		}
		
		return $modules;
	}
	
	public function convertToDb($modules)
	{
		$db = array();
		
		foreach($modules as $module_name => $module) {
			foreach($module as $submodule_name => $is_active) {
				$db[$module_name . '.' . $submodule_name] = $is_active;
			}
		}
		
		return $db;
	}
}