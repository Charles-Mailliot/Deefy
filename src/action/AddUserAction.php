<?php

namespace iutnc\deefy\action;

use iutnc\deefy\repository\DeefyRepository;

class AddUserAction extends Action {
    
    public function execute(): string {

        if ($this->http_method === 'GET') {
            return <<<HTML
            <form method="post" action="?action=add-user">
                <label for="nom">Nom :</label>
                <input type="text" id="nom" name="nom" required><br>

                <label for="email">Email :</label>
                <input type="email" id="email" name="email" required><br>

                <label for="age">Âge :</label>
                <input type="number" id="age" name="age" min="0" required><br>

                <button type="submit">Connexion</button>
            </form>
            HTML;
        }

        if ($this->http_method === 'POST') {
            $nom = filter_var($_POST['nom'], FILTER_SANITIZE_SPECIAL_CHARS);
            $email = filter_var($_POST['email'], FILTER_SANITIZE_SPECIAL_CHARS);
            $age = filter_var($_POST['age'], FILTER_SANITIZE_SPECIAL_CHARS);
            return "<p>Nom:{$nom}, Email:{$email}, Age:{$age} ans</p>";
        }

        return "";
    }
    
}