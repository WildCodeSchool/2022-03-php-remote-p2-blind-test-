<?php

namespace App\Controller;

use Twig\Environment;
use Twig\Extension\DebugExtension;
use Twig\Loader\FilesystemLoader;
use App\Model\UserManager;
use App\Service\User;

/**
 * Initialized some Controller common features (Twig...)
 */
abstract class AbstractController
{
    protected Environment $twig;
    protected User $user;


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

        $this->user = $_SESSION['user'] ?? new User();

        $this->twig->addGlobal('user', $this->user->getNickname());
        $this->twig->addGlobal('cookies', $_COOKIE);
        $this->twig->addGlobal('session', $_SESSION);
    }
}
