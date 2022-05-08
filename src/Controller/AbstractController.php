<?php

namespace App\Controller;

use Twig\Environment;
use Twig\Extension\DebugExtension;
use Twig\Loader\FilesystemLoader;
use App\Model\UserManager;

/**
 * Initialized some Controller common features (Twig...)
 */
abstract class AbstractController
{
    protected Environment $twig;


    public function __construct()
    {
        $loader = new FilesystemLoader(APP_VIEW_PATH);
        $this->twig = new Environment(
            $loader,
            [
                'cache' => false,
                'debug' => (ENV === 'dev'),
            ]
        );
        $this->twig->addExtension(new DebugExtension());
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
            }
        }
        $name = $_SESSION['user_id'] ?? null;
        $this->twig->addGlobal('user', $name);
        $this->twig->addGlobal('cookies', $_COOKIE);
        $this->twig->addGlobal('session', $_SESSION);
        $this->twig->addGlobal('errors', $errors);
    }
}
