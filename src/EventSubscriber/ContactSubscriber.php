<?php

    namespace App\EventSubscriber;

    use App\Entity\Contact;
    use Doctrine\Common\EventSubscriber;
    use Doctrine\ORM\Events;
    use Doctrine\Persistence\Event\LifecycleEventArgs;
    use Symfony\Component\Mailer\MailerInterface;
    use Symfony\Component\Mime\Email;
    use App\Service\MailService;

    class ContactSubscriber implements EventSubscriber
    {
        private $ms;

        public function __construct(MailService $ms)
        {
            $this->ms = $ms;
        }

        public function getSubscribedEvents()
        {
            //retourne un tableau d'événements (prePersist, postPersist, preUpdate etc...)
            return [
                //événement déclenché après l'insert dans la base de donnée
                Events::postPersist,
            ];
        }

        public function postPersist(LifecycleEventArgs $args)
        {
    //        $args->getObject() nous retourne l'entité concernée par l'événement postPersist
            $entity = $args->getObject();

    //     Vérifier si l'entité est un nouvel objet de type Contact;
    //    Si l'objet persité n'est pas de type Contact, on ne veut pas que le Subscriber se déclenche!
            if ($entity instanceof Contact) {

                $email = $entity->getEmail();
                $objet = $entity->getObjet();
                $message = $entity->getMessage();

                //Si l'objet ou le text du message contiennent le mot "rgpd", le Subscriber enverra un email à l'adresse "admin@velvet.com"
                if (preg_match("/rgpd\b/i", $objet) || preg_match("/rgpd\b/i", $message) ) {

                    //     Envoyer un e-mail à l'admin

                    $this->ms->sendMail($entity->getEmail(), 'service-rgpd@hotmail.com', $entity->getObjet(), $entity->getMessage() );
                } else {
                    $this->ms->sendMail($entity->getEmail(), 'service-other@hotmail.com', $entity->getObjet(), $entity->getMessage() );
                }

            }
        }
    }