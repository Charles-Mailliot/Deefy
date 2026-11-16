<?php

namespace iutnc\deefy\action;

use iutnc\deefy\render\AudioListRenderer;
use iutnc\deefy\repository\DeefyRepository;

class DisplayPlaylistAction extends Action {
    
    public function execute(): string{
        $id = $_GET['id'] ?? ($_SESSION['playlist_id'] ?? null);

        if (is_null($id)) { return "<b>id playlist manquant</b>"; }

        try {
            $pl = DeefyRepository::getInstance()->findPlaylistById($id);
        } catch (\Exception $e) {
            return "<b> erreur de base de données : {$e->getMessage()} </b>";
        }

        $_SESSION['playlist_id'] = $pl->id;
        $r = new AudioListRenderer($pl);
        $html = $r->render(\iutnc\deefy\render\Renderer::COMPACT);
        $html .= '<br><a href="?action=add-track">Ajouter une piste</a>';

        return $html;
    }
    
}