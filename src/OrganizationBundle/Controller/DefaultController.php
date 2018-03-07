<?php

namespace OrganizationBundle\Controller;

use Doctrine\ORM\EntityManager;
use OrganizationBundle\Entity\Organization;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class DefaultController extends Controller
{
    const DefaultLimit = 100;
    const DefaultPage = 1;

    /**
     * @Route("/organization", name="create_organization")
     * @Method({"POST"})
     * Create organization tree and save in the DB
     * @param Request $request
     */
    public function saveOrganizationAction(Request $request)
    {
        $contentsArray = array();
        $uniContentsArray = array();
        $content = $request->getContent();

        if (!empty($content))
        {
            $contentsArray = json_decode($content, true);
            $uniContentsArray[0] = $contentsArray;  // unifying structure of contents: [index] => array()
        }

        $this->extractSaveOrganizations($uniContentsArray);

        return new Response("Organizations successfully saved", Response::HTTP_CREATED,
            array('Content-Type' => 'text'));
    }


    /**
     * @Route("/organization/{name}", name="get_organization_relations")
     * @Method({"GET"})
     * Get all relations of an organization by its name
     * @param Request $request
     */
    public function getOrganizationRelationsByNameAction (string $name, Request $request)
    {
        // Find the requested Organization in the DB
        $organizationDataService = $this->get('organization.organization_data');
        $org = $organizationDataService->getOrganizationByName($name);

        if(empty($org)) {
            // No Organization found
            return new Response ("Organization not found!");
        }

        // Get the full relatives array
        $relatives = $this->getRelativesByOrganization($org);

        // Get the paginated relatives array
        $page = ((integer) $request->headers->get('page')) ?: self::DefaultPage;
        $response = $this->getPaginatedRelatives($relatives, $page);

        return new Response(json_encode($response), Response::HTTP_OK,
            array('Content-Type' => 'application/json'));
    }

    private function extractSaveOrganizations (array $contentsArray, Organization $parent = null)
    {
        $orgId = NULL;
        $org = NULL;
        for ($i = 0; $i < count($contentsArray); $i++)
        {
            if(array_key_exists('org_name',$contentsArray[$i])) {
                $name = $contentsArray[$i]['org_name'];
                // Check if the requested Organization already in the DB
                $organizationDataService = $this->get('organization.organization_data');
                $org = $organizationDataService->getOrganizationByName($name);
                if(empty($org)) {
                    // If not in DB, create a new Organization
                    $org = new Organization();
                    $org->setName($name);
                }
                if($parent)
                {
                    $org->addOrgParent($parent);
                    $parent->addOrgDaughter($org);
                    $this->storeOrganizationToDB($parent);
                }
                $this->storeOrganizationToDB($org);
            }
            if(array_key_exists('daughters',$contentsArray[$i]))
            {
                // Call the function recursively to handle 'daughters' tree
                $this->extractSaveOrganizations($contentsArray[$i]['daughters'], $org);
            }
        }
    }

    // Store the given Organization object to DB
    private function storeOrganizationToDB (Organization $org)
    {
        $em = $this->getDoctrine()->getManager();
        $em->persist($org);
        $em->flush();

        return $org->getId();
    }

    // Get the array of all organization's relatives
    private function getRelativesByOrganization (Organization $org)
    {
        $relatives = array();

        // Getting parents
        $parentOrgs = array();
        $parentOrgs = $org->getOrgParents();
        foreach($parentOrgs as $p) {
            array_push($relatives, array(
                "relationship_type" => "parent",
                "org_name" => $p->getName()
            ));

            // Getting sisters as an array of all parents' daughters
            $p_daughters = array();
            $p_daughters = $p->getOrgDaughters();
            foreach($p_daughters as $pd) {
                if($pd->getId() != $org->getId()){         // filter out the key Organization itself
                    array_push($relatives, array(
                            "relationship_type" => "sister",
                            "org_name" => $pd->getName())
                    );
                }
            }
        }

        // Filter out duplicates
        $relatives = array_intersect_key($relatives,
            array_unique(array_map('serialize', $relatives)));

        // Getting daughters
        $daughterOrgs = array();
        $daughterOrgs = $org->getOrgDaughters();
        foreach($daughterOrgs as $d) {
            array_push($relatives, array(
                    "relationship_type" => "daughter",
                    "org_name" => $d->getName())
            );
        }

        // Sorting by name
        usort($relatives, function ($item1, $item2) {
            return $item1['org_name'] <=> $item2['org_name'];
        });

        return $relatives;
    }

    // Get one page of the relatives
    private function getPaginatedRelatives (array $relatives, $page)
    {
        $total = count($relatives);

        if ( ceil($total/self::DefaultLimit) < $page )
        {
            throw new Exception("Page not found");
        }
        else
        {
            $relatives = array_slice($relatives, self::DefaultLimit * ($page - 1),
                self::DefaultLimit);
        }

        // Response that includes pagination info and the array of relatives
        $response = ['total'=>$total, 'limit'=>self::DefaultLimit, 'page'=>$page, 'relatives'=>$relatives];

        return $response;
    }

}
