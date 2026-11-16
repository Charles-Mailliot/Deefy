<?php

namespace iutnc\deefy\action;

use iutnc\deefy\audio\lists\Playlist;
use iutnc\deefy\render\AudioListRenderer;
use iutnc\deefy\repository\DeefyRepository;

class AddPlaylistAction extends Action {
    
    public function execute(): string {
        if ($this->http_method === 'GET') {
            return <<<HTML
            <form method="post" action="?action=add-playlist">
                <label for="nom">Nom de la playlist :</label>
                <input type="text" id="nom" name="nom" required>
                <button type="submit">Créer</button>
            </form>
            HTML;
        }

        if ($this->http_method === 'POST') {
            $nom = filter_var($_POST['nom'], FILTER_SANITIZE_SPECIAL_CHARS);
            $playlist = new Playlist($nom);
            $repo = DeefyRepository::getInstance();
            $playlist = $repo->saveEmptyPlaylist($playlist);
            $_SESSION['playlist_id'] = $playlist->id;
            $listRenderer = new AudioListRenderer($playlist);
            return $listRenderer->render(1) . '<br><a href="?action=add-track">Ajouter une piste</a>';
        }
        return "";
    }
    
}