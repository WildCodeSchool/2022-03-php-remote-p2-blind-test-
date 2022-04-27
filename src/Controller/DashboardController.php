<?php

namespace App\Controller;

use App\Model\DashboardManager;

class DashboardController extends ItemController
{
    public function index(): string
    {
        $tracksManager = new DashboardManager();
        $tracks = $tracksManager->selectAll('title');

        return $this->twig->render('Dashboard/dashboard.html.twig', ['tracks' => $tracks]);
    }

    public function add(): ?string
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // clean $_POST data
            $item = array_map('trim', $_POST);

            $fileName = $_FILES['path']['track'];
            $uploadFile = __DIR__ . '/../../public/uploads' . $fileName;
            if (move_uploaded_file($_FILES['path']['tmp_name'], $uploadFile)) {
                $dashboardManager = new DashboardManager();
                $dashboard['path'] = $fileName;
                $id = $dashboardManager->insert($item);
                header('Location:/Dashboard/show?id=' . $id);
                return null;
            }
        }
        return $this->twig->render('Dashboard.html.twig');
    }
}
