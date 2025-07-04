<?php

require_once 'BaseController.php';

class ErrorController extends BaseController
{

    /**
     * Page 404 personnalisée
     */
    public function notFound($message = null)
    {
        http_response_code(404);

        // Message par défaut si aucun fourni
        if (!$message) {
            $message = 'La page que vous cherchez n\'existe pas.';
        }

        echo $this->view('404', [
            'title' => 'Page non trouvée',
            'message' => $message
        ]);
    }

    /**
     * Erreur 500 (erreur serveur)
     */
    public function serverError($message = 'Une erreur est survenue sur le serveur.')
    {
        http_response_code(500);

        echo $this->view('500', [
            'title' => 'Erreur serveur',
            'message' => $message
        ]);
    }

    /**
     * Erreur 403 (accès interdit)
     */
    public function forbidden($message = 'Vous n\'avez pas l\'autorisation d\'accéder à cette page.')
    {
        http_response_code(403);

        echo $this->view('403', [
            'title' => 'Accès interdit',
            'message' => $message
        ]);
    }
}
