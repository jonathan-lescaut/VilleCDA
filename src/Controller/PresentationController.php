<?php

namespace App\Controller;

use App\Entity\Presentation;
use App\Form\PresentationType;
use App\Repository\PresentationRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

#[Route('/presentation')]
#[IsGranted('ROLE_ADMIN')]
class PresentationController extends AbstractController
{
    #[Route('/', name: 'app_presentation_index', methods: ['GET'])]
    public function index(PresentationRepository $presentationRepository): Response
    {
        return $this->render('presentation/index.html.twig', [
            'presentations' => $presentationRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_presentation_new', methods: ['GET', 'POST'])]
    public function new(Request $request, PresentationRepository $presentationRepository, SluggerInterface $slugger): Response
    {
        $presentation = new Presentation();
        $form = $this->createForm(PresentationType::class, $presentation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // ========================= 

            $tabImg = ['imgPresentation', 'imgPresentation1', 'imgPresentation2', 'imgPresentation3', 'imgPresentation4'];
            foreach ($tabImg as $key) {
                $imgPresentation = $form->get($key)->getData();
                if ($imgPresentation) {
                    $originalFilename = pathinfo(
                        $imgPresentation->getClientOriginalName(),
                        PATHINFO_FILENAME
                    );
                    $safeFilename = $slugger->slug($originalFilename);
                    $newFilename = $safeFilename . '-' . uniqid() . '.' . $imgPresentation->guessExtension();
    
                    try {
                        $imgPresentation->move(
                            $this->getParameter('photos_directory'),
                            $newFilename
                        );
                    } catch (FileException $e) {
                    }
                    $set = 'set' . ucfirst(substr('set' . $key, 3, 16));
                    $presentation->$set($newFilename);
                }   
            }

            // =================================

            $logoPresentation = $form->get('logoPresentation')->getData();
            if ($logoPresentation) {
                $originalFilename = pathinfo(
                    $logoPresentation->getClientOriginalName(),
                    PATHINFO_FILENAME
                );
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $logoPresentation->guessExtension();

                try {
                    $logoPresentation->move(
                        $this->getParameter('photos_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                }
                $presentation->setLogoPresentation($newFilename);
            }
            // ========================= 


            $presentationRepository->add($presentation, true);

            return $this->redirectToRoute('app_presentation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('presentation/new.html.twig', [
            'presentation' => $presentation,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_presentation_show', methods: ['GET'])]
    public function show(Presentation $presentation): Response
    {
        return $this->render('presentation/show.html.twig', [
            'presentation' => $presentation,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_presentation_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Presentation $presentation, PresentationRepository $presentationRepository): Response
    {
        $form = $this->createForm(PresentationType::class, $presentation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $presentationRepository->add($presentation, true);

            return $this->redirectToRoute('app_presentation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('presentation/edit.html.twig', [
            'presentation' => $presentation,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_presentation_delete', methods: ['POST'])]
    public function delete(Request $request, Presentation $presentation, PresentationRepository $presentationRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $presentation->getId(), $request->request->get('_token'))) {
            $presentationRepository->remove($presentation, true);
        }

        return $this->redirectToRoute('app_presentation_index', [], Response::HTTP_SEE_OTHER);
    }
}
