<?php

namespace iutnc\deefy\action;

use iutnc\deefy\repository\DeefyRepository;

class DisplayAllPlaylistsAction extends Action {

    public function execute(): string {
        $repo = DeefyRepository::getInstance();
        $playlists = $repo->findAllPlaylist();

        if (empty($playlists)) {
            return "<p>Aucune playlist enregistrée en base de données.</p>";
        }

        $html = "<h2>Mes playlists</h2><ul>";
        foreach ($playlists as $pl) {
            $nom = htmlspecialchars($pl->nom);
            $html .= "<li><a href=\"?action=playlist&id={$pl->id}\">{$nom}</a></li>";
        }
        $html .= "</ul>";

        return $html;
    }
}