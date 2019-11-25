<?php

namespace App\Controller;

use App\Entity\Hotel;
use App\Entity\HotelChain;
use App\Entity\Review;
use App\Repository\ReviewRepository;
use Psr\Cache\InvalidArgumentException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Cache\Adapter\ApcuAdapter;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Cache\ItemInterface;

class ApiController extends AbstractController
{

    /**
     * @Route("/api/average", name="average")
     * @param Request $request
     * @return Response
     */
    public function getAverage(Request $request)
    {
        $hotelId   = $request->get('hotelId');
        $hotelUUID = $request->get('hotelUUID');
        $from      = $request->get('from');
        $to        = $request->get('to');

        $cacheKey = preg_replace("/[\\{}()\/:@_]*/", '', implode('_', array_filter([$hotelId, $hotelUUID, $from, $to])));

        $cache = new ApcuAdapter(
            $namespace = 'test',
            $defaultLifetime = 3600,
            $version = null
        );

        try {
            $value = $cache->get($cacheKey, function (ItemInterface $item) use ($hotelId, $hotelUUID, $from, $to) {
                $item->expiresAfter(3600);

                if ($hotelId === null) {
                    if ($hotelUUID === null) {
                        return 'provide hotelId or hotelUUID for this request';
                    }
                    $hotel = $this->getDoctrine()->getRepository(Hotel::class)->findOneBy(['uuid' => $hotelUUID]);
                    if ($hotel === null) {
                        return 'no hotel found';
                    }
                    $hotelId = $hotel->getId();
                }
                if (!empty($from)) {
                    try {
                        $from = new \DateTime($from);
                    } catch (\Throwable $t) {
                        $from = "";
                    }
                }
                if (!empty($to)) {
                    try {
                        $to = new \DateTime($to);
                    } catch (\Throwable $t) {
                        $to = "";
                    }
                }

                /** @var ReviewRepository $review_repo */
                $review_repo = $this->getDoctrine()->getRepository(Review::class);
                return $review_repo->getAverageScoreForHotel($hotelId, $from, $to);
            }, 0);
        } catch (InvalidArgumentException $e) {
            $value = 'Error';
        }

        return new Response($value);
    }

    /**
     * @Route("/api/reviews", name="review_list")
     * @param Request $request
     * @return JsonResponse
     */
    public function getReviews(Request $request): JsonResponse
    {
        $hotelId = $request->get('hotelId');
        $review_repo = $this->getDoctrine()->getRepository(Review::class);

        if (!empty($hotelId)) {
            return new JsonResponse($review_repo->findBy(['hotel_id' => $hotelId]));
        }
        return new JsonResponse($review_repo->findAll());
    }

    /**
     * @Route("/api/hotels", name="hotel_list")
     * @param Request $request
     * @return JsonResponse
     */
    public function getHotels(Request $request): JsonResponse
    {
        return new JsonResponse($this->getDoctrine()->getRepository(Hotel::class)->findAll());
    }

    /**
     * @Route("/api/hotel_chains", name="hotel_chains_list")
     * @param Request $request
     * @return Response
     */
    public function getHotelChains(Request $request): Response
    {
        $chainId = $request->get('chainId');
        if (!empty($chainId)) {
            return new JsonResponse($this->getDoctrine()->getRepository(HotelChain::class)->find($chainId));
        }

        return new JsonResponse($this->getDoctrine()->getRepository(HotelChain::class)->findAll());
    }
}
