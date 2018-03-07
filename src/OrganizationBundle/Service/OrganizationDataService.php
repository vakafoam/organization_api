<?php
/**
 * Created by PhpStorm.
 * User: vaka
 * Date: 2/17/2018
 * Time: 12:09 PM
 */

namespace OrganizationBundle\Service;

use Doctrine\ORM\EntityManager;
use OrganizationBundle\Entity\Organization;


class OrganizationDataService
{
    private $em;

    public function __construct(EntityManager $em){
        $this->em = $em;
    }

    public function getOrganizationByName (string $name)
    {
        $orgRepository = $this->em->getRepository('OrganizationBundle:Organization');
        $org = $orgRepository->findOneBy(['name'=>$name]);
        return $org;
    }
}