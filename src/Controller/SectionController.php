<?php

namespace App\Controller;

use App\Entity\Application;
use App\Entity\Section;
use App\Entity\User;
use App\Form\SectionType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SectionController extends AbstractController
{
    public function default_data(array $parameters=array()):array{
        $default_parameters = array(
            'controller_name' => 'SectionController',
            'navbar_title' => 'Suivis Satisfaction Utilisateurs',
        );

        return array_merge($default_parameters, $parameters);
    }

    /**
     * @Route("/admin/section/add", name="section_add")
     */
    public function addSection(Request $request, EntityManagerInterface $em){

        $section = new Section();

        $form = $this->createForm(SectionType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //dd($form->getData());
            $section = $form->getData();
            $em->persist($section);
            $em->flush();

            return $this->redirectToRoute("section");
        }

        return $this->render('admin/section/form.html.twig', 
        $this->default_data([
            'title' => 'Administration des sections',
            'form' => $form->createView(),
        ]));
    }

        /**
     * @Route("/admin/section/edit/{id_section}", name="section_edit")
     */
    public function editSection(Request $request, EntityManagerInterface $em, int $id_section){

        $section = $em->getRepository(Section::class)->find($id_section);

        $form = $this->createForm(SectionType::class, $section);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //dd($form->getData());
            $section = $form->getData();

            //dd($section);
            $em->persist($section);
            $em->flush();

            return $this->redirectToRoute("section");
        }

        return $this->render('admin/section/form.html.twig', 
        $this->default_data([
            'title' => 'Administration des sections',
            'form' => $form->createView(),
        ]));
    }

            /**
     * @Route("/admin/section/{id_section}", name="section_display")
     */
    public function displaySection(Request $request, EntityManagerInterface $em, $id_section){

        $section = new Section();

        //TODO create a display section view

        return $this->render('admin/section/add.html.twig', 
        $this->default_data([
            'title' => 'Administration des sections',
        ]));
    }

                /**
     * @Route("/admin/section_delete/", name="section_delete")
     */
    public function deleteSection(Request $request, EntityManagerInterface $em){

        $idSection = $request->request->get('idSection');

        $section = $em->getRepository(Section::class)->find($idSection);

        $em->remove($section);

        $em->flush();

        $response = new Response(json_encode(array(
            'idSection'=> $idSection,
        )));

        return $response;

    }
}
