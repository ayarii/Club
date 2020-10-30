<?php

namespace App\Controller;

use App\Entity\Classroom;
use App\Entity\Student;
use App\Form\ClassRoomType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/classroom")
 */
class ClassroomController extends AbstractController
{
    /**
     * @Route("/list", name="classroom")
     */
    public function listClassroom()
    {
        $classrooms = $this->getDoctrine()->getRepository(Classroom::class)->findAll();
        return $this->render('classroom/list.html.twig', array("classrooms" => $classrooms));
    }


    /**
     * @Route("/delete/{id}", name="deleteClassroom")
     */
    public function deleteClassroom($id)
    {
        $classroom = $this->getDoctrine()->getRepository(Classroom::class)->find($id);
        $em = $this->getDoctrine()->getManager();
        $em->remove($classroom);
        $em->flush();
        return $this->redirectToRoute("classroom");
    }

    /**
     * @Route("/show/{id}", name="showClassroom")
     */
    public function showClassroom($id)
    {
        $classroom = $this->getDoctrine()->getRepository(Classroom::class)->find($id);

        //1 method:list of Students
        //$students=$classroom->getStudents();
        //2 method: from repository
        $students= $this->getDoctrine()->getRepository(Student::class)->listStudentByClass($classroom->getId());
        return $this->render('classroom/show.html.twig', array(
            "classroom" => $classroom,
            "students"=>$students));
    }

    /**
     * @Route("/add", name="addClassroom")
     */
    public function addClassroom(Request $request)
    {
        $classroom = new Classroom();
        $form = $this->createForm(ClassRoomType::class, $classroom);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($classroom);
            $em->flush();
            return $this->redirectToRoute('classroom');
        }
        return $this->render("classroom/add.html.twig",array('form'=>$form->createView()));
    }

    /**
     * @Route("/update/{id}", name="updateClassroom")
     */
    public function updateClassroom(Request $request,$id)
    {
        $classroom = $this->getDoctrine()->getRepository(Classroom::class)->find($id);
        $form = $this->createForm(ClassRoomType::class, $classroom);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute('classroom');
        }
        return $this->render("classroom/update.html.twig",array('form'=>$form->createView()));
    }
}
