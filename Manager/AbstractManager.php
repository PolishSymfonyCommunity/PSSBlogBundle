<?php

namespace PSS\Bundle\BlogBundle\Manager;

# Symfony/Doctrine internal
use Doctrine\ORM\EntityManager;
use Symfony\Component\EventDispatcher\EventDispatcher;


# Specific


# Domain objects


# Entities




abstract class AbstractManager 
{

    /**
     * Fully Qualified Class Name of the entity
     *
     * @var string
     */
    protected $classname;


    /* @var \Doctrine\ORM\EntityManager */
    protected $em = null;


    /* @var \Symfony\Component\EventDispatcher\EventDispatcher */
    protected $dispatcher = null;


    public function __construct(EventDispatcher $dispatcher, EntityManager $em, $classname=null)
    {
        $this->dispatcher = $dispatcher;
        $this->em = $em;
    }


    public function getRepository($name=null)
    {
        $entityName = ($name === null)?static::CLASSNAME:$name;
        $repository = $this->em->getRepository($entityName);
        return $repository;
    }




    /**
     * Returns a new instance of the Form class
     *
     * Make sure you adjust the form' __construct($inputArray)
     * with the proper index.
     *
     * e.g.  $om->formFactory($injectOne,$injectTwo,$injectThree);
     *       would return a new SomeRandomFormName instance
     *
     * Inside the SomeRandomFormName::__construct($inputArray), you
     * could get $injectOne value by delcaring $inputArray[0]
     *
     * @return \Symfony\Component\Form\AbstractType form class instance
     */
    public function formFactory()
    {
        $arguments = func_get_args();
        $formClassname = static::FORM_CLASSNAME;
        if(count($arguments) >= 1){
            return new $formClassname($arguments);
        }
        return new $formClassname();
    }




    /**
     * Return a _new Entity_ 
     */
    public function create()
    {
        $classname = $this->classname;
        return new $classname();
    }

}