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

        // recuperation de l'user
        $user = $this->getUser();

        // Si ROLE[0] est ROLE_USER alors recherche de la fonction dans gestionnaire.
        $roles[] = $user->getRoles();
        if ($roles[0][0] == 'ROLE_USER') {
          // Recherche du service de l'user depuis le gestionnaire.
          $gestionnaire = $em->getRepository('AppBundle:Gestionnaire')->findOneBy(array('user' => $user->getId()));

          // Si gestionnaire est null alors message vous n'êtes à aucun service.
          if ($gestionnaire == NULL) {
            // redigerer vers la page d'erreur
            $entete = "Oups!!!";
            $erreur = "100";
            $message = "Nous sommes désolés, vous n'êtes associé à aucun service. Veuillez contacter votre administrateur pour resourdre ce problème.";

            return $this->render('default/echec_acces.html.twig', array(
                'message' => $message,
                'entete'  => $entete,
                'erreur'  => $erreur,
            ));
          }

          $serviceGestionnaireID = $gestionnaire->getService()->getId();

          // on recupère le service de la rubrique en cours
          $rubrique = $em->getRepository('AppBundle:Rubrique')->findOneById($id);
          $serviceRubriqueID = $rubrique->getService()->getID();

          // si service user est different du service rubrique alors message pas de ce service
          if ($serviceRubriqueID != $serviceGestionnaireID) {
            // redigerer vers la page d'erreur
            $entete = "Accès réfusé";
            $erreur = "102";
            $message = "Nous sommes désolés, vous n'êtes pas de ce service. Veuillez contacter votre administrateur pour resourdre ce problème.";

            return $this->render('default/echec_acces.html.twig', array(
                'message' => $message,
                'entete'  => $entete,
                'erreur'  => $erreur,
            ));
          } else{
              $niveau = $gestionnaire->getNiveau();
              // Verifier l'existence d'une definition de droit d'accès
              // Sinon alors User peut visualiser la page
              $droit = $em->getRepository('AppBundle:Droit')->findOneBy(array('rubrique' => $id, 'niveau' => $niveau));

              $lecture = $droit->getLecture();
              $ecriture = $droit->getEcriture();

              return $this->render('ged/document_rubrique.html.twig', array(
                  'documents' => $documents,
                  'rubrique'  => $rubrique,
                  'lecture' => $lecture,
                  'ecriture'  => $ecriture,
              ));

          }
          // sinon verifier le droit dans droit d'acces
          // si pas ok alors message accès réfusé
        }
        //die('administrateur');

        return $this->render('ged/document_rubrique.html.twig', array(
            'documents' => $documents,
            'rubrique'  => $rubrique,
            'lecture' => true,
            'ecriture'  => true,
        ));
    }

}
