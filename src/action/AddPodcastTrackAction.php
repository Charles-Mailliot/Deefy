<?php

namespace iutnc\deefy\action;

use iutnc\deefy\audio\lists\Playlist;
use iutnc\deefy\render\AudioListRenderer;
use iutnc\deefy\audio\tracks\PodcastTrack;
use iutnc\deefy\repository\DeefyRepository;

class AddPodcastTrackAction extends Action {
    
    public function execute(): string {

        if (!isset($_SESSION['playlist_id'])) {
            return "<p>Veuillez d'abord créer une playlist avant d'ajouter une piste.</p>";
        }

        if ($this->http_method === 'GET') {
            return <<<HTML
            <form method="post" action="?action=add-track" enctype="multipart/form-data">
                <label for="titre">Titre du podcast :</label>
                <input type="text" id="titre" name="titre" required><br>

                <label for="auteur">Auteur :</label>
                <input type="text" id="auteur" name="auteur"><br>

                <label for="fichier">Fichier audio (.mp3) :</label>
                <input type="file" id="fichier" name="userfile" accept="audio/mp3" required><br>

                <button type="submit">Ajouter la piste</button>
            </form>
            HTML;   
        }

        if ($this->http_method === 'POST') {

            if (!isset($_POST['titre'])) {
                return "<p>Erreur : Champ titre manquant.</p>";
            }

            $titre = filter_var($_POST['titre'], FILTER_SANITIZE_SPECIAL_CHARS);
            $auteur = filter_var($_POST['auteur'] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
            
            $upload_dir = __DIR__ . '/../../audio/';

            if (isset($_FILES['userfile']) && $_FILES['userfile']['error'] === UPLOAD_ERR_OK) {
                $tmp = $_FILES['userfile']['tmp_name'];
                $originalName = $_FILES['userfile']['name'];

                if (substr($originalName, -4) === '.mp3') {
                    $filename = uniqid() . '.mp3';
                    $dest = $upload_dir . $filename;

                    if (move_uploaded_file($tmp, $dest)) {
                        $track = new PodcastTrack($titre, $filename);
                        if (!empty($auteur)) {
                            $track->setAuteur($auteur);
                        }

                        $repo = DeefyRepository::getInstance();
                        $track = $repo->saveTrack($track);

                        $playlistId = (int)$_SESSION['playlist_id'];
                        $repo->addTrackPlaylist($track->id, $playlistId);

                        $playlist = $repo->findPlaylistById($playlistId);
                        $renderer = new AudioListRenderer($playlist);

                        return "<p>Piste ajoutée avec succès !</p>" . 
                               $renderer->render(1) . 
                               '<br><a href="?action=add-track">Ajouter encore une piste</a>';
                    } else {
                        return "<p>Échec du transfert du fichier.</p>";
                    }
                } else {
                    return "<p>Seuls les fichiers avec l'extension .mp3 sont autorisés.</p>";
                }
            } else {
                if (($_FILES['userfile']['error'] ?? null) === UPLOAD_ERR_INI_SIZE) {
                    return "<p>Erreur : Le fichier dépasse la taille maximale autorisée par le serveur</p>";
                }
                return "<p>Erreur lors du transfert du fichier.</p>";
            }
        }
        return "";
    }
}