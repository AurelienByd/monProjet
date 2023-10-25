<?php

namespace App\Form;

use App\Entity\Contact;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType; // permet d'ajouter un input type text
use Symfony\Component\Form\Extension\Core\Type\IntegerType; // permet d'ajouter un input de type number
use Symfony\Component\Form\Extension\Core\Type\EmailType; // permet d'ajouter un input type email
use Symfony\Component\Form\Extension\Core\Type\SubmitType; // permet d'ajouter un input type submit
use Symfony\Component\Form\Extension\Core\Type\ResetType; // permet d'ajouter un input type reset
use Symfony\Component\Form\Extension\Core\Type\TextareaType; // permet d'ajouter un input type textarea
use Symfony\Component\Form\Extension\Core\Type\HiddenType; // permet d'ajouter un input type hidden
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ContactFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('objet', TextType::class, [
                'label' => 'Motif'])
            ->add('prenom', TextType::class, [
                    'label' => 'Prénom'
                    ])
            ->add('nom', TextType::class, [
                    'label' => 'nom'])
            ->add('age', IntegerType::class, [
                    'label' => 'Votre âge'])
            ->add('email', EmailType::class, [
                'label' => 'Votre adresse email',
                'help' => 'exemple@exemple.exe'])

            //On a rajouté un label et on a rendu le champ optionnel en
            // donnant la valeur false à l'attribut required
            ->add('message', TextareaType::class, [
                'label' => 'Votre message',
                'required' => false,
                'disabled' => true
                ]
            )

            // ->add('caché', HiddenType::class, [
            //     'value' => 25])

            ->add('save', SubmitType::class, [
                'label' => 'Envoyer le message'])

            ->add('erase', ResetType::class, [
                'label' => 'Effacer'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Contact::class,
        ]);
    }

    //     // CSRF token

    // public function delete(Request $request): Response
    // {
    //     $submittedToken = $request->request->get('token');

    //      // 'delete-item' est identique à la valeur utilisée dans la vue pour générer le token 
    //     if ($this->isCsrfTokenValid('delete-item', $submittedToken)) {
    //         // ... le corps de la fonction
    //     }
    // }

}
