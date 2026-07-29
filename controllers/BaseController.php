<?php

class BaseController
{

    /**
     * Garde d'accès de toute la zone admin : exige une session administrateur,
     * et un jeton CSRF valide sur les requêtes POST. Termine la requête (403)
     * si l'une des deux conditions n'est pas remplie.
     *
     * Définie ici plutôt que dupliquée dans chaque contrôleur : les copies
     * privées divergeaient (certaines ne testaient même pas le flag `admin`).
     */
    protected function checkAuth(): void
    {
        requireAdminPost();
    }

    protected function view($template, $data = [])
    {
        return view($template, $data);
    }

    protected function json($data, $code = 200)
    {
        return json($data, $code);
    }

    protected function redirect($url)
    {
        return redirect($url);
    }

    /**
     * Afficher une page 404
     */
    protected function notFound($message = null)
    {
        return $this->callErrorController('notFound', $message);
    }

    /**
     * Afficher une erreur 403
     */
    protected function forbidden($message = null)
    {
        return $this->callErrorController('forbidden', $message);
    }

    /**
     * Afficher une erreur 500
     */
    protected function serverError($message = null)
    {
        return $this->callErrorController('serverError', $message);
    }

    /**
     * Appeler le contrôleur d'erreur
     */
    private function callErrorController($method, $message = null)
    {
        include_once 'controllers/ErrorController.php';
        $errorController = new ErrorController();
        return $errorController->$method($message);
    }

    /**
     * Validation simple
     */
    protected function validate($data, $rules)
    {
        $errors = [];

        foreach ($rules as $field => $rule) {
            $value = $data[$field] ?? '';

            if ($rule === 'required' && empty($value)) {
                $errors[] = ucfirst($field) . ' est requis';
            }

            if ($rule === 'email' && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
                $errors[] = ucfirst($field) . ' doit être un email valide';
            }
        }

        return $errors;
    }
}
