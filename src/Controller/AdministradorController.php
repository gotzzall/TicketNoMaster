<?php

namespace App\Controller;

use App\Entity\Registro;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class AdministradorController extends AbstractController
{
    #[Route('/mostrarvistaprincipal', name:'mostrarVistaPrincipal_admin')]
    public function mostrarVistaPrincipalAdmin(SessionInterface $sesion, EntityManagerInterface $entityManager): Response
    {
       if(!empty($sesion->get('id')))
       {
            $resultado = $entityManager->getRepository(Registro::class)->findAll();

            return $this->render('admin/vistaPrincipalAdmin.html.twig', [
                'registros' => $resultado
            ]);
       }
       else
       {
            return $this->redirectToRoute('mostrar_login');
       }
    }
}