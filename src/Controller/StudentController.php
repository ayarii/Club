<?php

namespace App\Controller;

use App\Entity\Student;
use App\Form\SearchStudentType;
use App\Form\StudentType;
use App\Repository\StudentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/student")
 */
class StudentController extends AbstractController
{
    /**
     * @Route("/index", name="student")
     */
    public function index()
    {
        return $this->render('student/index.html.twig', [
            'controller_name' => 'StudentController',
        ]);
    }

    /**
     * @Route("/list", name="student")
     */
    public function listStudent(Request $request, StudentRepository $repository)
    {
        //All of Student
        $students = $repository->findAll();
        //list of students order By Mail
        $studentsByMail = $repository->orderByMail();
        //search
        $searchForm = $this->createForm(SearchStudentType::class);
        $searchForm->handleRequest($request);
        if ($searchForm->isSubmitted()) {
            $nsc = $searchForm->getData()->getNsc();
            $resultOfSearch = $repository->searchStudent($nsc);
            return $this->render('student/searchStudent.html.twig', array(
                "resultOfSearch" => $resultOfSearch,
                "searchStudent" => $searchForm->createView()));
        }
        return $this->render('student/list.html.twig', array(
            "students" => $students,
            "studentsByMail" => $studentsByMail,
            "searchStudent" => $searchForm->createView()));
    }

    /**
     * @Route("/delete/{id}", name="deleteStudent")
     */
    public function deleteStudent($id)
    {
        $student = $this->getDoctrine()->getRepository(Student::class)->find($id);
        $em = $this->getDoctrine()->getManager();
        $em->remove($student);
        $em->flush();
        return $this->redirectToRoute("student");
    }

    /**
     * @Route("/show/{id}", name="showStudent")
     */
    public function showStudent($id)
    {
        $student = $this->getDoctrine()->getRepository(Student::class)->find($id);
        return $this->render('student/show.html.twig', array("student" => $student));
    }

    /**
     * @Route("/add", name="addStudent")
     */
    public function addStudent(Request $request)
    {
        $student = new Student();
        $form = $this->createForm(StudentType::class, $student);
        $form->handleRequest($request);
        if ($form->isSubmitted() and $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($student);
            $em->flush();
            return $this->redirectToRoute('student');
        }
        return $this->render("student/add.html.twig", array('form' => $form->createView()));
    }

    /**
     * @Route("/update/{id}", name="updateStudent")
     */
    public function updateStudent(Request $request, $id)
    {
        $student = $this->getDoctrine()->getRepository(Student::class)->find($id);
        $form = $this->createForm(StudentType::class, $student);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute('student');
        }
        return $this->render("student/update.html.twig", array('form' => $form->createView()));
    }

}
