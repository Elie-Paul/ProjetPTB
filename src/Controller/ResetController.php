<?php

namespace App\Controller;

use App\Repository\CommandeNavetteRepository;
use App\Repository\CommandePtbRepository;
use App\Repository\CommandeTaxeRepository;
use App\Repository\CommandeVignetteRepository;
use Doctrine\DBAL\DBALException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ResetController extends AbstractController
{
    /**
     * @Route("/reset", name="reset")
     */
    public function index()
    {
        return $this->render('reset/index.html.twig', [
            'controller_name' => 'ResetController',
        ]);
    }

    /**
     * @Route("/reset/ptb", name="reset_ptb")
     * @param CommandePtbRepository $commandePtbRepository
     * @return Response
     * @throws DBALException
     */
    public function ptb(CommandePtbRepository $commandePtbRepository)
    {
        $commandePtbRepository->truncatePtb();
        $commandePtbRepository->stockZero();
        $commandePtbRepository->numeroDernierBillet();
        $commandePtbRepository->truncateVentePtb();
        return $this->redirectToRoute("home");
    }

    /**
     * @Route("/reset/autorail", name="reset_autorail")
     * @param CommandeNavetteRepository $commandeNavetteRepository
     * @return Response
     * @throws DBALException
     */
    public function autorail(CommandeNavetteRepository $commandeNavetteRepository)
    {
        $commandeNavetteRepository->truncateCommandeNavette();
        $commandeNavetteRepository->stockZero();
        $commandeNavetteRepository->numeroDernierBillet();
        $commandeNavetteRepository->truncateVenteNavette();
        return $this->redirectToRoute("home");
    }

    /**
     * @Route("/reset/taxe", name="reset_taxe")
     * @param CommandeTaxeRepository $commandeTaxeRepository
     * @return Response
     * @throws DBALException
     */
    public function taxe(CommandeTaxeRepository $commandeTaxeRepository)
    {
        $commandeTaxeRepository->truncateCommandeTaxe();
        $commandeTaxeRepository->stockZero();
        $commandeTaxeRepository->numeroDernierBillet();
        $commandeTaxeRepository->truncateVenteTaxe();
        return $this->redirectToRoute("home");
    }

    /**
     * @Route("/reset/vignette", name="reset_vignette")
     * @param CommandeVignetteRepository $vignetteRepository
     * @return Response
     * @throws DBALException
     */
    public function vignette(CommandeVignetteRepository $vignetteRepository)
    {
        $vignetteRepository->truncateCommandeVignette();
        $vignetteRepository->stockZero();
        $vignetteRepository->numeroDernierBillet();
        $vignetteRepository->truncateVenteVignette();
        return $this->redirectToRoute("home");
    }
}
