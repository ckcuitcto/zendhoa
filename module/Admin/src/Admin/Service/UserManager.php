<?php

/**
 * Created by PhpStorm.
 * User: Thai Duc
 * Date: 12-Mar-18
 * Time: 3:50 PM
 */

namespace Admin\Service;

use Admin\Entity\Unit;
use Admin\Entity\User;
use Zend\ServiceManager\ServiceManager;
use Zend\ServiceManager\ServiceManagerAwareInterface;

class UserManager implements ServiceManagerAwareInterface
{
    private $sm;

    public function setServiceManager(ServiceManager $serviceManager)
    {
        $this->sm = $serviceManager;
    }

    public function getServiceLocator()
    {
        return $this->sm;
    }

    protected function getEntityManager()
    {
        $em = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');
        return $em;
    }

    public function setRememberTokenByUser(User $user, $code)
    {
        $em = $this->getEntityManager();
        $user->setRememberToken($code);
        $em->persist($user);
        $em->flush();
    }

    public function changePassword(User $user, $newPassword)
    {
        $em = $this->getEntityManager();
        $user->setPassword(md5($newPassword));
        $em->persist($user);
        $em->flush();
    }

}