<?php

namespace App\Controller;

use App\Form\ContactType;
use App\Services\MailerService;
use Symfony\Component\Mime\Email;
use App\Repository\ArticlesRepository;
use App\Repository\CategoriesRepository;
use App\Repository\PresentationRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ContactController extends AbstractController
{
    /**
     * @Route("/contact", name="app_contact")
     */
    public function index(Request $request, MailerService $mailer, ArticlesRepository $articlesRepository, CategoriesRepository $categoriesRepository, PresentationRepository $presentationRepository)
    {
        $form = $this->createForm(ContactType::class);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $contactFormData = $form->getData();
            $subject = 'Demande de contact sur votre site de ' . $contactFormData['email'];
            $content = $contactFormData['name'] . ' vous a envoyé le message suivant: ' . $contactFormData['message'];
            $mailer->sendEmail(subject: $subject, content: $content);
            $this->addFlash('success', 'Votre message a été envoyé');
            return $this->redirectToRoute('app_home');
        }
        return $this->render('contact/index.html.twig', [
            'articles' => $articlesRepository->findAll(),
            'categories' => $categoriesRepository->findAll(),
            'presentation' => $presentationRepository->findAll(),
            'form' => $form->createView()
        ]);
    }
}