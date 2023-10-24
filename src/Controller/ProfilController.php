<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

// class ProfilController extends AbstractController
// {
//     #[Route('/profil', name: 'app_profil')]
//     public function index(): Response
//     {
//         $info = ['Loper', 'Dave', 'daveloper@code.dom', '01/01/1970'];

//         return $this->render('profil/index.html.twig', [
//             'informations' => $info
//         ]);
//     }
// }

// Pour passer un tableau associatif du contrôleur vers la vue, le procédé reste le même, seul la méthode d'affichage va changer :

    class ProfilController extends AbstractController
    {
        #[Route('/profil', name: 'app_profil')]
        public function index(): Response
        {
            $info = ['lastname' => 'Loper', 'firstname' => 'Dave', 'email' => 'daveloper@code.dom', 'birthdate' => '01/01/1970'];
    
            return $this->render('profil/index.html.twig', [
                'informations' => $info
            ]);
        }
    }