<?php

/**
 * Created by PhpStorm.
 * User: Thai Duc
 * Date: 12-Mar-18
 * Time: 3:50 PM
 */
namespace Admin\Service;

use Admin\Entity\Unit;
use Zend\ServiceManager\ServiceManager;
use Zend\ServiceManager\ServiceManagerAwareInterface;

class UnitManager implements ServiceManagerAwareInterface
{
    private $sm;

    public function setServiceManager(ServiceManager $serviceManager)
    {
        $this->sm = $serviceManager;
    }

    public function getServiceLocator(){
        return $this->sm;
    }

    protected function getEntityManager()
    {
        $em = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');
        return $em;
    }

    public function getArrayUnit(){
        $em = $this->getEntityManager();

        $units = $em->getRepository('\Admin\Entity\Unit')->findAll();
        $arrUnit = array();
        foreach ($units as $unit) {
            $arrUnit[$unit->getId()] = $unit->getName();
        }
        return $arrUnit;
    }
}