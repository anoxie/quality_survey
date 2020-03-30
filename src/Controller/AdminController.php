<?php

namespace App\Controller;


use App\Entity\Application;
use App\Entity\Campagn;
use App\Entity\Questionnaire;
use App\Entity\Section;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    public function default_data(array $parameters=array()):array{
        $default_parameters = array(
            'controller_name' => 'AdminController',
            'navbar_title' => 'Suivis Satisfaction Utilisateurs',
        );

        return array_merge($default_parameters, $parameters);
    }
    /**
     * @Route("/admin", name="admin")
     */
    public function index()
    {
        return $this->render('admin/index.html.twig', $this->default_data());
    }

    /** 
     * @Route("/admin/section/{id_section}", name="section")
     */
    public function section(Request $request, string $id_section = '', EntityManagerInterface $em)
    {
        $repository = $em->getRepository(Section::class);

        $list_section = $repository->findAll();

        $section = new Section();

        $form = $this->createFormBuilder($section)
            ->add('libelle', TextType::class)
            ->add('description', TextareaType::class)
            ->add('save', SubmitType::class, ['label' => 'Enregitrer la nouvelle section'])
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //dd($form->getData());
            $section = $form->getData();
            $em->persist($section);
            $em->flush();

            return $this->redirectToRoute("section");
        }

        return $this->render('admin/section.html.twig', 
        $this->default_data([
            'title' => 'Administration des sections',
            'sections' => $list_section,
            'form' => $form->createView(),
        ]));
    }

    /** 
     * @Route("/admin/application", name="application")
     */
    public function applications(Request $request, EntityManagerInterface $em)
    {
        $repository = $em->getRepository(Application::class);

        $list_application = $repository->findAll();

        $application = new Application();

        $form = $this->createFormBuilder($application)
            ->add('libelle', TextType::class)
            ->add('description', TextareaType::class)
            ->add('save', SubmitType::class, ['label' => 'Enregitrer la nouvelle application'])
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //dd($form->getData());
            $application = $form->getData();
            $em->persist($application);
            $em->flush();

            return $this->redirectToRoute("application");
        }

        return $this->render('admin/application.html.twig', 
        $this->default_data([
            'title' => 'Applications',
            'applications' => $list_application,
            'form' => $form->createView(),
        ]));
    }

    /**
     * @Route("/admin/utilisateur", name="utilisateur")
     */
    public function utilisateur(Request $request, EntityManagerInterface $em)
    {
        $repository = $em->getRepository(User::class);

        $list_user = $repository->findAll();

        return $this->render('admin/user.html.twig', 
        $this->default_data([
            'title' => 'Utilisateurs',
            'users' => $list_user,
        ]));

    }

        /**
     * @Route("/admin/questionnaire", name="questionnaire")
     */
    public function questionnaire(Request $request, EntityManagerInterface $em)
    {
        $repository = $em->getRepository(Questionnaire::class);

        $list_questionnaire = $repository->findAll();

        return $this->render('admin/questionnaire.html.twig', 
        $this->default_data([
            'title' => 'Utilisateurs',
            'questionnaires' => $list_questionnaire,
        ]));

    }

}
