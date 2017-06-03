<?php

namespace AppBundle\Services;

use Symfony\Component\DependencyInjection\ContainerInterface;
/**
 *
 */
class DroitAcces
{

  function __construct(ContainerInterface $container, $entityManager)
  {
    $this->container = $container;
    $this->em = $entityManager;
    //$this->controller = $controller;
  }

  public function droitacces($user)
  {

    // Si ROLE[0] est ROLE_USER alors recherche de la fonction dans gestionnaire.
    $roles[] = $user->getRoles();
    if ($roles[0][0] == 'ROLE_USER') {
      $gestionnaire = $this->em->getRepository('AppBundle:Gestionnaire')->findOneBy(array('user' => $user->getId()));
      //dump($gestionnaire);die();
      // Si gestionnaire est null alors message vous n'êtes à aucun service.
      if ($gestionnaire == NULL) {
        // redigerer vers la page d'erreur
        $entete = "Oups!!!";
        $erreur = "100";
        $message = "Nous sommes désolés, vous n'êtes associé à aucun service. Veuillez contacter votre administrateur pour resourdre ce problème.";

        $response = $this->container->get('templating')->renderResponse('default/echec_acces.html.twig', array(
            'message' => $message,
            'entete'  => $entete,
            'erreur'  => $erreur,
        ));
        return $response;
      }
      // Si fonction est differentes de CHEF ou DIRECTEUR alors message vous n'êtes pas autorisés
      if (($gestionnaire->getNiveau()) < 4) {
        // redigerer vers la page d'erreur
        $entete = "Accès réfusé";
        $erreur = "101";
        $message = "Nous sommes désolés, vous n'avez pas les droits requis pour accéder à cette page. Veuillez contacter votre administrateur pour resourdre ce problème.
                    Si le problème persiste, prière <a href='#'>nous contacter</a>";
        //return $this->redirectToRoute('homepage');die('depasser');
         $response = $this->container->get('templating')->renderResponse('default/echec_acces.html.twig', array(
            'message' => $message,
            'entete'  => $entete,
            'erreur'  => $erreur,
        ));
         return $response;
      }
    }
  }
}
