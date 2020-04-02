<?php

namespace App\Controller;

use App\Entity\Application;
use App\Form\ApplicationType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ApplicationController extends AbstractController
{
    public function default_data(array $parameters=array()):array{
        $default_parameters = array(
            'controller_name' => 'ApplicationController',
            'navbar_title' => 'Suivis Satisfaction Utilisateurs',
        );

        return array_merge($default_parameters, $parameters);
    }

    /**
     * @Route("/admin/application/add", name="application_add")
     */
    public function addApplication(Request $request, EntityManagerInterface $em){

        $application = new Application();

        $form = $this->createForm(ApplicationType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //dd($form->getData());
            $application = $form->getData();
            $em->persist($application);
            $em->flush();

            return $this->redirectToRoute("application");
        }

        return $this->render('admin/application/form.html.twig', 
        $this->default_data([
            'title' => 'Administration des applications',
            'form' => $form->createView(),
        ]));
    }

        /**
     * @Route("/admin/application/edit/{id_application}", name="application_edit")
     */
    public function editApplication(Request $request, EntityManagerInterface $em, int $id_application){

        $application = $em->getRepository(Application::class)->find($id_application);

        $form = $this->createForm(ApplicationType::class, $application);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //dd($form->getData());
            $application = $form->getData();

            //dd($application);
            $em->persist($application);
            $em->flush();

            return $this->redirectToRoute("application");
        }

        return $this->render('admin/application/form.html.twig', 
        $this->default_data([
            'title' => 'Administration des applications',
            'form' => $form->createView(),
        ]));
    }

            /**
     * @Route("/admin/application/{id_application}", name="application_display")
     */
    public function displayApplication(Request $request, EntityManagerInterface $em, $id_application){

        $application = new Application();

        //TODO create a display application view

        return $this->render('admin/application/add.html.twig', 
        $this->default_data([
            'title' => 'Administration des applications',
        ]));
    }

                /**
     * @Route("/admin/application_delete/", name="application_delete")
     */
    public function deleteApplication(Request $request, EntityManagerInterface $em){

        $idApplication = $request->request->get('idApplication');

        $application = $em->getRepository(Application::class)->find($idApplication);

        $em->remove($application);

        $em->flush();

        $response = new Response(json_encode(array(
            'idApplication'=> $idApplication,
        )));

        return $response;

    }
}
