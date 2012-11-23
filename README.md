# Module Bundle #

Modulariazion for Symfony2. Enable / disable modules.

## Example ##

	/**
     * @Route("/")
	 * @Template()
	 * @Module("blog.main")
	 */
	public function indexAction(Request $request)
	{

This annotation will throw an exception if the module is not enabled.

### In twig
	{% if module_active('blog.main') %}
		link to blog
	{% endif %}

## Installation

### Composer

    "padam87/module-bundle": "dev-master",

### AppKernel:

    $bundles = array(
		...
        new Padam87\ModuleBundle\Padam87ModuleBundle(),
    );        

### Routing:

	Padam87ModuleBundle:
	    resource: "@Padam87SearchBundle/Controller/"
	    type:     annotation
	    prefix:   /admin

The route will be /admin/modules this way... feel free to modify.

### config.yml
	imports:
		...
	    - { resource: modules.yml }
	    - { resource: "@Padam87ModuleBundle/Resources/config/config.yml" }

### modules.yml

Create your modules.yml. Example:

	parameters:
	  modules:
	    blog:
	      main: true
	      comments: true
	      history: true
	      tags: true

Note: If you set one of the options to false, you wont be able to see that module in the admin, so it will be permanently disabled.

### View

Athough the bundle provides a default view, you would propably want to create your own.
You can do that by adding an:

	app/Resources/Padam87ModuleBundle/views/Admin/index.html.twig

OR

You can create yout own bundle as a child of this one.

Check Padam87ModulesBundle:Admin:index.html.twig for an example

## Dependencies

None.


