<?php

namespace App\Controller;

use App\Entity\Registro;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class LoginController extends AbstractController
{
    #[Route('/', name:'mostrar_login')]
    public function mostrarLogin(): Response
    {
       return $this->render('login/vistaLogin.html.twig',[
        'aviso' => false,
        'mensaje' => ''
    ]);
    }

    #[Route('/login/validar', name:'validar_login', methods:'POST')]
    public function validarLogin(EntityManagerInterface $entityManager, SessionInterface $session, Request $request)
    {
        if(!empty($request->get('user')) && !empty($request->get('pass')))
        {
            $user = $request->get('user');
            $pass = $request->get('pass');
            
            $registro = $entityManager->getRepository(Registro::class)->findOneBy(['usuario' => $user]);
            if($registro)
            {
                if($registro->getUsuario() == $user && $registro->getContrasenia() == $pass && $registro->getEstado() == 1)
                {
                    $session->set('id', $registro->getId());
                    $session->set('user', $user);
                    $session->set('tipo', $registro->getTipo());

                    if($registro->getTipo() == 'admin')
                    {
                        return $this->redirectToRoute('mostrarVistaPrincipal_admin');
                    }
                    else
                    {
                        return die('empleado');
                        //return $this->redirectToRoute('admin/vistaPrincipalAdmin.html.twig');
                    }
                }
            }
        }

        return $this->render('login/vistaLogin.html.twig',[
            'aviso' => true,
            'mensaje' => 'Ingrese un usuario y contraseña válido'
        ]);
    }
}