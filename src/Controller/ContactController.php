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
use Symfony\Component\Mime\Email;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mime\Address;
use App\Service\MailService;

class ContactController extends AbstractController
{
    #[Route('/contact', name: 'app_contact')]
        // ContactRepository $contactRepo : On appelle le fichier ContactRepository et on créer une variable $contactRepo pour afficher dans les champs du formulaire des valeurs pré-intégrées
    public function index(Request $request, EntityManagerInterface $entityManager, ContactRepository $contactRepo, MailerInterface $mailer, MailService $ms): Response
    {
        //     // On stocke dans une variable ce qu'on récupère avec la variable $contactRepo à l'aide de la fonction find(id de la ligne à récupérer)
        // $contact = $contactRepo->find(1);

            // permet d'afficher les informations récupérées
        // dd($contact);

            // nous utilisons la méthode createForm() pour créer une instance de notre formulaire ContactFormType
            // On rajoute $contact pour tout afficher à la création du formulaire
            $form = $this->createForm(ContactFormType::class);//, $contact);
            // dd($form);
            // nous utilisons la méthode handleRequest() pour traiter la requête HTTP actuelle et valider les données soumises
            $form->handleRequest($request);
        
            // Si le formulaire est soumis et si le formulaire est valide, nous pouvons accéder aux données du formulaire à l'aide de la méthode getData()
            if ($form->isSubmitted() && $form->isValid()) {

                // Traitement des données du formulaire
                $data = $form->getData();

                //on crée une instance de Contact
                $message = new Contact();
                $message->setEmail($data->getEmail());
                $message->setObjet($data->getObjet());
                $message->setMessage($data->getMessage());

                //on stocke les données récupérées dans la variable $message
                $message = $data;

                $entityManager->persist($message);
                $entityManager->flush();

                //envoie du mail

                    // $email = (new TemplatedEmail())
                    //     ->from('hello@example.com')
                    //     ->to(new Address($data->getEmail()))
                    //     //->cc('cc@example.com')
                    //     //->bcc('bcc@example.com')
                    //     //->replyTo('fabien@example.com')
                    //     //->priority(Email::PRIORITY_HIGH)
                    //     ->subject('Exercice d\'envoie de mail avec Symfony')

                    //     // le chemin de la vue Twig à utiliser dans le mail
                    //     ->htmlTemplate('emails/contact_email.html.twig')

                    //     // un tableau de variable à passer à la vue; 
                    //     //  on choisit le nom d'une variable pour la vue et on lui attribue une valeur (comme dans la fonction `render`) :
                    //     ->context([
                    //         'email_envoie' => $data->getEmail(),
                    //         'sujet' => $data->getObjet(),
                    //         'message' => $data->getMessage(),
                    //     ]);

                    // $mailer->send($email);

                    // $email = (new Email())
                    //     ->from('hello@example.com')
                    //     ->to($data->getEmail())
                    //     //->cc('cc@example.com')
                    //     //->bcc('bcc@example.com')
                    //     //->replyTo('fabien@example.com')
                    //     //->priority(Email::PRIORITY_HIGH)
                    //     ->subject($data->getObjet())
                    //     ->text($data->getMessage())
                    //     ->html('<h1>'.$data->getObjet().'</h1><p>'.$data->getMessage().'</p>');

                    // $mailer->send($email);

                // //envoi de mail avec notre service MailService
                    // $ms->sendMail('hello@example.com', $data->getEmail(), $data->getObjet(), $data->getMessage() );

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