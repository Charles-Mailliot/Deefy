<?php

namespace iutnc\deefy\dispatch;

class Dispatcher {

    protected ?string $action = null;
    protected $actions = [];

    public function __construct() {
        $this->action = $_GET['action'] ?? 'default';
    }








    public function addRoute(string $action, string $action_class) : Dispatcher {
        $this->actions[$action] = $action_class;
        return $this;
    }

    public function run() : void {
        if (isset($this->actions[$this->action])) {
            $class = $this->actions[$this->action];
            $actionObj = new $class();
            $html = $actionObj->execute();
        } else {
            throw new \Exception("Action ' {$this->action} ' not found");
        }

        // Affichage complet de la page
        $this->renderPage($html);
    }

    private function renderPage(string $html) : void {
        echo <<<END
            <!DOCTYPE html>
        <html lang="fr">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Deefy</title>
        </head>
        <body>
            <header>
                <h1>Deefy App</h1>
                <nav>
                    <ul>
                        <li><a href="?action=default">Accueil</a></li>
                        <li><a href="?action=all-playlists">Mes playlists</a></li>
                        <li><a href="?action=playlist">Afficher la playlist courante</a></li>
                        <li><a href="?action=add-playlist">Créer une playlist</a></li>
                        <li><a href="?action=add-user">Inscription</a></li>
                    </ul>
                </nav>
            </header>

            <main>
                {$html}
            </main>
        </body>
        </html>
        END;
    }




}