<?php
namespace iutnc\deefy\render;

use iutnc\deefy\audio\tracks\PodcastTrack;

require_once 'AudioTrackRenderer.php';

class PodcastTrackRenderer extends AudioTrackRenderer {

    public function __construct(PodcastTrack $podcast) {
        parent::__construct($podcast);
    }

    protected function compactRender(): string {
        return "<div>" . $this->track->titre . "<audio controls src = 'audio/" . $this->track->nomFichier . "'></audio></div>";
    }

    protected function longRender(): string {
        $html = "<div>";
        $html .= "<h3>" . $this->track->titre . "</h3>";
        $html .= "<audio controls src='" . $this->track->nomFichier . "'></audio>";
        $html .= "</div>";
        
        return $html;
    }
}