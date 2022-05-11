<?php

namespace App\Controller;

use App\Model\UserManager;
use App\Controller\AbstractController;
use App\Service\User;

class UserController extends AbstractController
{
    public function login(): string|null
    {

        $errors = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST)) {
            $credentials = array_map('trim', $_POST);
            // @todo make some controls on email and password fields and if errors, send them to the view
            $userManager = new UserManager();
            // On demande au UserManager de rechercher l'utilisateur en BDD à partir de l'email
            $user = $userManager->selectByEmail($credentials['email'])->getEmail();
            if (empty($user)) {
                $errors[] = "Le mail n'existe pas";
            }
            // Si l'utilisateur a été trouvé et si l'empreinte de son mot de passe est vérifiée...
            if ($user && password_verify($credentials['password'], $user->getPassword())) {
                // ...alors on persiste l'id de notre utilisateur identifié dans la session PHP à l'index ['user_id']
                $_SESSION['user'] = $user;
                // puis on le redirige sur une autre page (page catégories ici)
                header('Location: /category');
                return null;
            } else {
                $errors[] = "Mot de passe non valide";
            }
        }
        return $this->twig->render('User/login.html.twig', [
            'errors' => $errors
        ]);
    }


    //Mon test pour l'image
    public function register(): string|null
    {
        $errors = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // 1. vérifier que le pseudo et l'email $credentials['nickname'] est disponible/valide
            if (!empty($_POST['nickname']) && !empty($_POST['email'])) {
                $credentials = $_POST;
                $userManager = new UserManager();
                $userByNickname = $userManager->selectOneByNickname($credentials['nickname']);
                $userByEmail = $userManager->selectByEmail($credentials['email']);
                if ($userByNickname) {
                    $errors['user'] = "Pseudo déjà utilisé";
                }
                if ($userByEmail) {
                    $errors['email'] = "Veuillez saisir une adresse e-mail valide";
                }
                if (strlen($credentials['password']) < 6) {
                    $errors['password'] = "Entrez une combinaisons d'au moins six caractères";
                }
                if (empty($errors)) {
                    $_SESSION['user'] = $credentials;
                    $userManager->insert($credentials);
                    return $this->login();
                }
            }
        }
        return $this->twig->render('User/register.html.twig', [
            'errors' => $errors
        ]);
    }

    public function logout()
    {
        // On supprime $_SESSION
        unset($_SESSION['user']);
        // puis on le redirige sur une autre page (page d'accueil ici)
        header('Location: /');
    }
}
