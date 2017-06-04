<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Document;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;

class RechercheController extends Controller
{
    /**
     * Recherche de document
     *
     * @Route("/recherche", name="recherche_document_form")
     * @Method({"GET", "POST"})
     */
    public function rechercheAction(Request $request)
    {
        $document = new Document();
        $form = $this->createForm('AppBundle\Form\RechercheType', $document);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $mot = $document->getLibelle();//dump($mot);die();

            $resultats = $em->getRepository('AppBundle:Document')->recherche($mot);
            //dump($resultats);die();
            if ($resultats) {
              $existance = true;
              $nombre = count($resultats);

            } else {
              $existance = false;
              $this->addFlash('notice', "Aucun document ne correspond à ".strtoupper($mot)."! ");
              $nombre = count($resultats);
            }

            return $this->render('recherche/liste.html.twig', array(
                'resultats' => $resultats,
                'existance'  => $existance,
                'nombre'  => $nombre,
            ));
        }

        return $this->render('recherche/form.html.twig', array(
            'document' => $document,
            'form' => $form->createView(),
        ));
    }
}
