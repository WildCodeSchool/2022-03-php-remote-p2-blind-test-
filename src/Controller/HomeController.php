<?php

namespace App\Controller;

use App\Model\UserManager;

class HomeController extends AbstractController
{
    /**
     * Display home page
     */
    public function index(): string
    {
        $errors = [];
        if (!empty($_POST['user_id'])) {
            $credentials = $_POST;
            $userManager = new UserManager();
            $user = $userManager->selectOneByNickname($credentials['user_id']);
            if (!empty($user)) {
                $errors['user'] = "Pseudo déjà utilisé";
            } else {
                $_SESSION['user_id'] = $_POST['user_id'];
                $userManager->add($_SESSION['user_id']);
                header('location: /category');
            }
        }
        return $this->twig->render('Home/index.html.twig', [
            'errors' => $errors
        ]);
    }
}
