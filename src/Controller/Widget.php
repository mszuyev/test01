<?php


namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class Widget extends AbstractController
{

    /**
     * @Route("/widget_test/", name="widget_test")
     * @param Request $request
     * @return Response
     */
    public function showTest(Request $request): Response
    {
        return $this->render('widget_test.html.twig');
    }

    /**
     * @Route("/widget/{uuid}.js", name="widget")
     * @param string $uuid
     * @return Response
     */
    public function show(string $uuid): Response
    {
        $response = $this->render('widget.js.twig', ['uuid' => $uuid]);
        $response->headers->add(['Content-Type' => 'application/javascript']);
        return $response;
    }

}