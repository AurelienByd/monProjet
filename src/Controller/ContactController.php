<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\DemoFormType;
use App\Form\ContactFormType; // on relie au fichier qui se trouve dans le dossier form et se nomme ContactFormType.php, car c'est le formulaire que l'on souhaite afficher
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ContactRepository;

class ContactController extends AbstractController
{
    #[Route('/contact', name: 'app_contact')]
        // ContactRepository $contactRepo : On appelle le fichier ContactRepository et on créer une variable $contactRepo pour afficher dans les champs du formulaire des valeurs pré-intégrées
    public function index(Request $request, EntityManagerInterface $entityManager, ContactRepository $contactRepo): Response
    {
            // On stocke dans une variable ce qu'on récupère avec la variable $contactRepo à l'aide de la fonction find(id de la ligne à récupérer)
        $contact = $contactRepo->find(1);

            // permet d'afficher les informations récupérées
        // dd($contact);

            // nous utilisons la méthode createForm() pour créer une instance de notre formulaire ContactFormType
            // On rajoute $contact pour tout afficher à la création du formulaire
            $form = $this->createForm(ContactFormType::class, $contact);
            // dd($form);
            // nous utilisons la méthode handleRequest() pour traiter la requête HTTP actuelle et valider les données soumises
            $form->handleRequest($request);
        
            // Si le formulaire est soumis et si le formulaire est valide, nous pouvons accéder aux données du formulaire à l'aide de la méthode getData()
            if ($form->isSubmitted() && $form->isValid()) {

                //on crée une instance de Contact
                $message = new Contact();
                // Traitement des données du formulaire
                $data = $form->getData();
                //on stocke les données récupérées dans la variable $message
                $message = $data;
    
                $entityManager->persist($message);
                $entityManager->flush();
    
                // Redirection vers accueil
                return $this->redirectToRoute('app_accueil');
            }

            // Ce formulaire sera affiché à l'aide de la méthode render() dans la vue index.html.twig qui se trouve dans le répertoire contact
        return $this->render('contact/index.html.twig', [
                // 'form' => $form->createView(),
                'form' => $form
        ]);
    }
}
