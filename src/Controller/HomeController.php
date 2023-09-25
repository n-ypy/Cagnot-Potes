<?php

namespace App\Controller;

use App\Entity\Campaign;
use App\Entity\Participant;
use App\Repository\CampaignRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\ParticipantType;
use App\Form\CampaignType;
use DateTime;
use DateTimeImmutable;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(CampaignRepository $campaignRepository): Response
    {
        return $this->render('home/index.html.twig', [
            'campaigns' => $campaignRepository->findAll(),
        ]);
    }


    #[Route('/create', name: 'app_create')]
    public function create(Request $request, EntityManagerInterface $entityManager): Response
    {
        $campaign = new Campaign();
        $form = $this->createForm(CampaignType::class, $campaign);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($campaign);
            $entityManager->flush();

            return $this->redirectToRoute('app_home', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('home/create.html.twig', [
            'campaign' => $campaign,
            'form' => $form,
        ]);
    }


    #[Route('/payment/{id}', name: 'app_payment', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, Campaign $campaign): Response
    {

        $participant = new Participant();
        $participant->setCampaign($campaign);
        $form = $this->createForm(ParticipantType::class, $participant);
        if (is_numeric($request->query->get('amount'))) {
            $form->get('payment')->get('amount')->setData($request->query->get('amount'));
        }
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($participant);
            $entityManager->flush();

            return $this->redirectToRoute('app_show', ['id' => $campaign->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->render('home/payment.html.twig', [
            'participant' => $participant,
            'form' => $form,
        ]);
    }


    #[Route('/show/{id}', name: 'app_show', methods: ['GET'])]
    public function show(Campaign $campaign): Response
    {
        $participants = $campaign->getParticipants();

        return $this->render('home/show.html.twig', [
            'campaign' => $campaign,
            'participants' => $participants,
            'participantNumber' => $campaign->returnParticipantNumber(),
            'totalAmount' => $campaign->returnTotalParticipationAmount(),
            'progress' => $campaign->returnProgressPercent(),
        ]);
    }


    #[Route('/edit/{id}', name: 'app_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Campaign $campaign, EntityManagerInterface $entityManager): Response
    {
        $campaign->setUpdatedAt(new DateTime());
        $form = $this->createForm(CampaignType::class, $campaign);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_show', ['id' => $campaign->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->render('home/edit.html.twig', [
            'campaign' => $campaign,
            'form' => $form,
        ]);
    }
}
