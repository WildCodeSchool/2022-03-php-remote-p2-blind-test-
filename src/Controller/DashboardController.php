<?php

namespace App\Controller;

use App\Model\ItemManager;
use Symfony\Component\Console\Helper\Dumper;

class DashboardController extends ItemController
{
    public function index(): string
    {
        return $this->twig->render('Dashboard/dashboard.html.twig');
    }
}
