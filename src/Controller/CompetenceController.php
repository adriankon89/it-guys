<?php

namespace App\Controller;

use App\Cache\CompetenceCache;
use App\DTO\CompetenciesEnquiry;
use App\Filter\ItGuysWithCompetenciesFilterInterface;
use App\Repository\ItGuyRepository;
use App\Service\Serializer\DTOSerializer;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Context\Normalizer\ObjectNormalizerContextBuilder;

class CompetenceController extends AbstractController
{
    public function __construct(
        private ItGuyRepository $repository,
        private EntityManagerInterface $entityManager
    ) {
    }

    /**
     * Searches for IT professionals based on a set of competencies provided by the user.
     *
     * @Route("/itguys/competencies", name="search_by_competencies", methods={"GET"})
     *
     * @OA\Get(
     *     path="/itguys/competencies",
     *     summary="Search IT professionals based on competencies",
     *     description="This endpoint filters IT professionals based on a set of competencies provided by the user. The request should include an array of competencies as a query parameter and optional fields like location and availability dates.",
     *     operationId="searchByCompetencies",
     *     tags={"IT Guys Competencies"},
     *     @OA\Parameter(
     *         name="strictSearch",
     *         in="query",
     *         description="Whether the filter for competencies should be strict or not.",
     *         required=false,
     *         @OA\Schema(
     *              type="boolean",
     *              default=false
     *          )
     *     ),
     *     @OA\Parameter(
     *         name="competencies",
     *         in="query",
     *         description="List of competencies to filter professionals by (e.g., 'PHP', 'Symfony').",
     *         required=false,
     *         @OA\Schema(
     *             type="array",
     *             @OA\Items(type="string")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful response with a list of filtered IT professionals.",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="it_guys",
     *                 type="array",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(property="id", type="integer", example=1),
     *                     @OA\Property(property="name", type="string", example="John Doe"),
     *                 )
     *             ),
     *             @OA\Property(
     *                 property="competencies",
     *                 type="array",
     *                 @OA\Items(
     *                     type="string",
     *                      example="PHP"
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid request format or parameters."
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="No IT professionals found with the given criteria."
     *     )
     * )
     */
    #[Route('itguys/competencies', name: 'search_by_competencies', methods: 'GET')]
    public function invoke(
        Request $request,
        DTOSerializer $serializer,
        ItGuysWithCompetenciesFilterInterface $competenciesFilter,
        CompetenceCache $competenceCache
    ) {
        $competenciesEnquiry = $serializer->deserialize(
            $request->getContent(),
            CompetenciesEnquiry::class,
            'json'
        );
        $modifiedEnquiry = $competenciesFilter->apply(
            $competenciesEnquiry,
            $competenceCache->getItGuysWithCompetencies()
        );
        $responseStatus = true === empty($modifiedEnquiry->getItGuys())
        ? Response::HTTP_NOT_FOUND : Response::HTTP_OK;

        $context = (new ObjectNormalizerContextBuilder())
            ->withGroups('competencies')
            ->toArray();
        $responseContent = $serializer->serialize($modifiedEnquiry, 'json', $context);

        return new JsonResponse(data: $responseContent, status: $responseStatus, json: true);
    }
}
