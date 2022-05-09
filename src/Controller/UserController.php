<?php

namespace App\Controller;

use App\Model\UserManager;
use App\Controller\AbstractController;

class UserController extends AbstractController
{
    public function login(): string|null
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST)) {
            $credentials = array_map('trim', $_POST);
            // @todo make some controls on email and password fields and if errors, send them to the view
            $userManager = new UserManager();
            // On demande au UserManager de rechercher l'utilisateur en BDD à partir de l'email
            $user = $userManager->selectByEmail($credentials['email']);
            // Si l'utilisateur a été trouvé et si l'empreinte de son mot de passe est vérifiée...
            if ($user && password_verify($credentials['password'], $user['password'])) {
                // ...alors on persiste l'id de notre utilisateur identifié dans la session PHP à l'index ['user_id']
                $_SESSION['user_id'] = $user['id'];
                // puis on le redirige sur une autre page (page catégories ici)
                header('Location: /category');
                return null;
            }
        }
        return $this->twig->render('user/login.html.twig');
    }

    public function register(): string
    {
        return $this->twig->render('/login/register.html.twig');
    }
}
