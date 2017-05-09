<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Epi;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Epi controller.
 *
 * @Route("ged")
 */
class GedController extends Controller
{
    /**
     * Liste des documents concernés par la rubrique.
     *
     * @Route("/{id}/liste-des-documents-de-la-rubrique-{slug}", name="ged_document_rubrique")
     * @Method({"GET", "POST"})
     */
    public function documentrubriqueAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $rubrique = $em->getRepository('AppBundle:Rubrique')->findOneById($id);
        $documents = $em->getRepository('AppBundle:Document')->findBy(array('rubrique'  => $id));
        //dump($documents); die();

        return $this->render('ged/document_rubrique.html.twig', array(
            'documents' => $documents,
            'rubrique'  => $rubrique,
        ));
    }

}
