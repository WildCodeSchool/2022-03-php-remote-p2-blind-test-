<?php

namespace App\Controller;

use Twig\Environment;
use Twig\Extension\DebugExtension;
use Twig\Loader\FilesystemLoader;

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
        if (!empty($_POST['user_id'])) {
            $_SESSION['user_id'] = $_POST['user_id']; /* array_map('trim', $_POST); */
        }
        $name = $_SESSION['user_id'] ?? null;
        $this->twig->addGlobal('user', $name);
    }
}
