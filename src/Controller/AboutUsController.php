<?php

namespace App\Controller;

class AboutUsController extends AbstractController
{
    public function index(): string
    {
        return $this->twig->render('About_us/about_us.html.twig');
    }
}
