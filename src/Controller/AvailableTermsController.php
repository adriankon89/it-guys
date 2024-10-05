<?php

declare(strict_types=1);

namespace App\Controller;

use App\Cache\BookedTermCache;
use App\DTO\AvailableTermsEnquiry;
use App\Entity\ItGuy;
use App\Filter\AvailableTermsFilter;
use App\Repository\ItGuyRepository;
use App\Service\Serializer\DTOSerializer;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;

final class AvailableTermsController extends AbstractController
{
    public function __construct(
        private ItGuyRepository $repository,
        private EntityManagerInterface $entityManager
    ) {
    }

    #[Route('/itguys/{id}/available-terms', name: 'itguys-available-terms', methods: 'GET')]
    public function __invoke(
        Request $request,
        ItGuy $itGuy,
        DTOSerializer $serializer,
        AvailableTermsFilter $availableTermsFilter,
        BookedTermCache $cache,
    ): Response {
        $availableTermsEnquiry = $serializer->deserialize(
            $request->getContent(),
            AvailableTermsEnquiry::class,
            'json'
        );
        $availableTermsEnquiry->setItGuy($itGuy);
        $bookedTerms = $cache->findItGuyBookedTerms($itGuy, $availableTermsEnquiry->getAvailableFrom());
        $modifiedEnquiry = $availableTermsFilter->apply($availableTermsEnquiry, ...$bookedTerms);

        $responseContent = $serializer->serialize($modifiedEnquiry, 'json', [
            DateTimeNormalizer::FORMAT_KEY => 'Y-m-d',
        ]);
        return new JsonResponse(data: $responseContent, status: Response::HTTP_OK, json: true);
    }
}
