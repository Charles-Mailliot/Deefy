<?php
namespace iutnc\deefy\render;

use iutnc\deefy\audio\tracks\AlbumTrack;

require_once 'AudioTrackRenderer.php';


class AlbumTrackRenderer extends AudioTrackRenderer {

    public function __construct(AlbumTrack $albumTrack) {
        parent::__construct($albumTrack);
    }

    protected function compactRender(): string {
        return "<div>" . $this->track->numPiste . ". " . $this->track->titre . " (" . $this->track->album . ") " . "<audio controls src = '" . $this->track->nomFichier . "'></audio></div>";
    }

    protected function longRender(): string {
        $html = "<div>";
        $html .= "<h3>" . $this->track->titre . "</h3>";
        $html .= "<ul>";
        $html .= "<li>Album : " . $this->track->album . " (Piste " . $this->track->numPiste . ")</li>";
        $html .= "</ul>";
        $html .= "<audio controls src='" . $this->track->nomFichier . "'></audio>";
        $html .= "</div>";

        return $html;
    }
}