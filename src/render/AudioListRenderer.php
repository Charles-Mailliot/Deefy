<?php
namespace iutnc\deefy\render;

use iutnc\deefy\audio\lists\AudioList;
use iutnc\deefy\audio\tracks\AlbumTrack;
use iutnc\deefy\audio\tracks\PodcastTrack;

require_once 'Renderer.php';
require_once 'AlbumTrackRenderer.php';
require_once 'PodcastTrackRenderer.php';

class AudioListRenderer implements Renderer {

    private AudioList $liste;

    public function __construct(AudioList $liste) {
        $this->liste = $liste;
    }

    public function render(int $selector): string {
        $html = "<h2>" . $this->liste->nom . "</h2>";

        $html .= "<div>";
        foreach ($this->liste->track as $track) {
            if ($track instanceof AlbumTrack) {
                $trackRender = new AlbumTrackRenderer($track);
                $html .= $trackRender->render(Renderer::COMPACT);
            } elseif ($track instanceof PodcastTrack) {
                $trackRender = new PodcastTrackRenderer($track);
                $html .= $trackRender->render(Renderer::COMPACT);
            }
            
        }
        $html .= "</div>";

        $html .= "<div>";
        $html .= "<p>Nombre de pistes : " . $this->liste->nbPistes . "</p>";
        //$html .= "<p>Durée totale : " . $this->liste->dureeTotale . " secondes</p>";
        $html .= "</div>";

        return $html;
    }

}