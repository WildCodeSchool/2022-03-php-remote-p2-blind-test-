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

    /**
     * Show informations for a specific item
     */
    public function show(int $id): string
    {
        $trackManager = new DashboardManager();
        $track = $trackManager->selectOneById($id);

        return $this->twig->render('Dashboard/show.html.twig', ['track' => $track]);
    }

    public function add(): ?string
    {
        $errors = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // clean $_POST data
            $item = array_map('trim', $_POST);

            $fileName =  basename($_FILES['path']['name']);
            $uploadFile = __DIR__ . "/../../public/uploads/tracks/" .  $fileName;

            $extension = pathinfo($_FILES['path']['name'], PATHINFO_EXTENSION);
            $authorizedExtensions = ['mp3'];
            $maxFileSize = 8000000;

            if ((!in_array($extension, $authorizedExtensions))) {
                $errors[] = 'Veuillez sélectionner un morceau en mp3!';
            }

            // $uploadFile = __DIR__ . '/../../public/uploads' . $fileName;

            if (file_exists($_FILES['path']['tmp_name']) && filesize($_FILES['path']['tmp_name']) > $maxFileSize) {
                $errors[] = "Votre fichier doit faire moins de 5Mo !";
            }

            if (!empty($_FILES['path']['tmp_name'])) {
                $_SESSION['file'] = $_FILES;
                move_uploaded_file($_FILES['path']['tmp_name'], $uploadFile);
            }
            if (empty($errors)) {
                $dashboardManager = new DashboardManager();
                $item['path'] = $fileName;
                $dashboardManager->insert($item);
                header('Location: /dashboard');
                return null;
            }
        }
        return $this->twig->render('Dashboard/dashboard.html.twig', ['errors' => $errors]);
    }
}
