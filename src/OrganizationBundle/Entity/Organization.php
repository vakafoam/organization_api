<?php

namespace OrganizationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints\Uuid;

/**
 * Organization
 *
 * @ORM\Table(name="organization")
 * @ORM\Entity(repositoryClass="OrganizationBundle\Repository\OrganizationRepository")
 */
class Organization
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, unique=true)
     */
    private $name;

    /**
     * Many Organizations have Many Daughters.
     * @ORM\ManyToMany(targetEntity="Organization", mappedBy="orgParents", cascade={"persist"})
     */
    private $orgDaughters;

    /**
     * Many Organizations have many Parents.
     * @ORM\ManyToMany(targetEntity="Organization", inversedBy="orgDaughters")
     * @ORM\JoinTable(name="parents",
     *      joinColumns={@ORM\JoinColumn(name="org_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="parent_id", referencedColumnName="id")}
     *      )
     */
    private $orgParents;
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->orgDaughters = new \Doctrine\Common\Collections\ArrayCollection();
        $this->orgParents = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Organization
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Add orgDaughter
     *
     * @param \OrganizationBundle\Entity\Organization $orgDaughter
     *
     * @return Organization
     */
    public function addOrgDaughter(Organization $orgDaughter)
    {
        $this->orgDaughters[] = $orgDaughter;

        return $this;
    }

    /**
     * Remove orgDaughter
     *
     * @param \OrganizationBundle\Entity\Organization $orgDaughter
     */
    public function removeOrgDaughter(Organization $orgDaughter)
    {
        $this->orgDaughters->removeElement($orgDaughter);
    }

    /**
     * Get orgDaughters
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getOrgDaughters()
    {
        return $this->orgDaughters;
    }

    /**
     * Add orgParent
     *
     * @param \OrganizationBundle\Entity\Organization $orgParent
     *
     * @return Organization
     */
    public function addOrgParent(Organization $orgParent)
    {
        $this->orgParents[] = $orgParent;

        return $this;
    }

    /**
     * Remove orgParent
     *
     * @param \OrganizationBundle\Entity\Organization $orgParent
     */
    public function removeOrgParent(Organization $orgParent)
    {
        $this->orgParents->removeElement($orgParent);
    }

    /**
     * Get orgParents
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getOrgParents()
    {
        return $this->orgParents;
    }
}
