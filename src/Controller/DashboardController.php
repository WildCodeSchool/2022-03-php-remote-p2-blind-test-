<?php

namespace App\Controller;

use App\Model\ItemManager;
use App\Model\TrackManager;
use App\Model\DashboardManager;

class DashboardController extends AbstractController
{
    public function index(): string
    {
        $tracksManager = new TrackManager();
        $tracks = $tracksManager->selectAll('title');

        return $this->twig->render('Dashboard/dashboard.html.twig', ['tracks' => $tracks]);
    }

    /**
     * Show informations for a specific item
     */
    public function show(int $id): string
    {
        $trackManager = new TrackManager();
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
                $trackManager = new TrackManager();
                $item['path'] = $fileName;
                $trackManager->insert($item);
                header('Location: /dashboard');
                return null;
            }
        }
        return $this->twig->render('Dashboard/dashboard.html.twig', ['errors' => $errors]);
    }

    public function update(int $id)
    {
        $trackManager = new TrackManager();
        $track = $trackManager->selectOneById($id);
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // clean $_POST data
            $track = array_map('trim', $_POST);

            if (!empty($_FILES['path']['name'])) {
                $fileName =  basename($_FILES['path']['name']);
                $uploadFile = __DIR__ . '/../../public/uploads/tracks/' . $fileName;
                move_uploaded_file($_FILES['path']['tmp_name'], $uploadFile);
                $track['path'] = $fileName;
            }
            $trackManager->update($track);
            header('Location:/dashboard');
            return null;
        }
        return $this->twig->render('Dashboard/update.html.twig', ['track' => $track]);
    }

    /**
     * Delete a specific item
     */
    public function delete($id): void
    {
        $id = trim($id);
        $trackManager = new TrackManager();
        $trackManager->delete((int)$id);

        header('Location:/dashboard');
    }
}
