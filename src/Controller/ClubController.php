<?php

namespace App\Controller;

use App\Entity\Club;
use App\Form\ClubType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/club")
 */
class ClubController extends AbstractController
{
    /**
     * @Route("/index", name="club")
     */
    public function index()
    {
        return $this->render('club/index.html.twig', [
            'controller_name' => 'ClubController',
        ]);
    }

    /**
     * @Route("/list", name="club")
     */
    public function listClub()
    {
        $clubs = $this->getDoctrine()->getRepository(Club::class)->findAll();
        $clubsByDate= $this->getDoctrine()->getRepository(Club::class)->orderByDate();
        $enabledClubs = $this->getDoctrine()->getRepository(Club::class)->findEnabledClub();
        return $this->render('club/list.html.twig', array(
            "clubs" => $clubs,
            "clubByDate"=>$clubsByDate,
             "enabledClub"=>$enabledClubs));
    }

    /**
     * @Route("/delete/{id}", name="deleteClub")
     */
    public function deleteClub($id)
    {
        $club = $this->getDoctrine()->getRepository(Club::class)->find($id);
        $em = $this->getDoctrine()->getManager();
        $em->remove($club);
        $em->flush();
        return $this->redirectToRoute("club");
    }

    /**
     * @Route("/show/{id}", name="showClub")
     */
    public function showClub($id)
    {
        $club = $this->getDoctrine()->getRepository(Club::class)->find($id);
        return $this->render('club/show.html.twig', array("club" => $club));
    }

    /**
     * @Route("/add", name="addClub")
     */
    public function addClub(Request $request)
    {
        $club = new Club();
        $form = $this->createForm(ClubType::class, $club);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($club);
            $em->flush();
            return $this->redirectToRoute('club');
        }
        return $this->render("club/add.html.twig",array('form'=>$form->createView()));
    }

    /**
     * @Route("/update/{id}", name="updateClub")
     */
    public function updateClub(Request $request,$id)
    {
        $club = $this->getDoctrine()->getRepository(Club::class)->find($id);
        $form = $this->createForm(ClubType::class, $club);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute('club');
        }
        return $this->render("club/update.html.twig",array('form'=>$form->createView()));
    }

}
