<?php

require_once 'BaseController.php';

/**
 * Fonction pour envoyer un email avec validation et sécurité
 *
 * @param string $to L'adresse email du destinataire
 * @param string $subject Le sujet de l'email
 * @param string $message Le contenu du message
 * @param string $fromEmail L'email de l'expéditeur
 * @param string $fromName Le nom de l'expéditeur
 * @return bool Succès ou échec de l'envoi
 */
function sendMail($to, $subject, $message, $fromEmail, $fromName)
{
    // Validation des paramètres
    if (empty($to) || empty($subject) || empty($message)) {
        return false;
    }

    // Validation de l'email destinataire
    if (!filter_var($to, FILTER_VALIDATE_EMAIL)) {
        return false;
    }

    // Nettoyage et sécurisation des données
    $subject = trim(strip_tags($subject));
    $message = trim($message);
    $fromEmail = filter_var($fromEmail, FILTER_SANITIZE_EMAIL);
    $fromName = trim(strip_tags($fromName));

    // Configuration des en-têtes
    $headers = [];
    $headers[] = 'MIME-Version: 1.0';
    $headers[] = 'Content-type: text/html; charset=utf-8';
    $headers[] = 'From: ' . $fromName . ' <no-reply@enzo-fournier.fr>';
    $headers[] = 'Reply-To: ' . $fromEmail;
    $headers[] = 'X-Mailer: PHP/' . phpversion();
    $headers[] = 'X-Priority: 3';

    // Formatage du message
    $htmlMessage = "
    <!DOCTYPE html>
    <html>
    <head>
        <meta charset='utf-8'>
        <title>" . htmlspecialchars($subject) . "</title>
        <style>
            body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
            .container { max-width: 600px; margin: 0 auto; padding: 20px; }
            .header { background: linear-gradient(135deg, #00d4ff 0%, #7209b7 100%); color: white; padding: 20px; text-align: center; }
            .content { background: #f9f9f9; padding: 20px; }
            .footer { background: #333; color: white; padding: 10px; text-align: center; font-size: 12px; }
            .info { background: #e7f3ff; padding: 15px; margin: 10px 0; border-left: 4px solid #00d4ff; }
        </style>
    </head>
    <body>
        <div class='container'>
            <div class='header'>
                <h1>Nouveau message de contact</h1>
            </div>
            <div class='content'>
                <div class='info'>
                    <strong>Expéditeur :</strong> " . htmlspecialchars($fromName) . "<br>
                    <strong>Email :</strong> " . htmlspecialchars($fromEmail) . "<br>
                    <strong>Sujet :</strong> " . htmlspecialchars($subject) . "<br>
                    <strong>Date :</strong> " . date('d/m/Y à H:i:s') . "
                </div>
                <h3>Message :</h3>
                <div style='background: white; padding: 15px; border: 1px solid #ddd;'>
                    " . nl2br(htmlspecialchars($message)) . "
                </div>
            </div>
            <div class='footer'>
                <p>Message envoyé depuis le formulaire de contact du site enzo-fournier.fr</p>
            </div>
        </div>
    </body>
    </html>";

    // Envoi de l'email
    return mail($to, $subject, $htmlMessage, implode("\r\n", $headers));
}

/**
 * Fonction pour valider les données du formulaire de contact
 *
 * @param array $data Les données à valider
 * @return array Les erreurs de validation
 */
function validateContactForm($data)
{
    $errors = [];

    // Validation du nom
    if (empty(trim($data['name'] ?? ''))) {
        $errors['name'] = 'Le nom est obligatoire';
    } elseif (strlen(trim($data['name'])) < 2) {
        $errors['name'] = 'Le nom doit contenir au moins 2 caractères';
    } elseif (strlen(trim($data['name'])) > 100) {
        $errors['name'] = 'Le nom ne peut pas dépasser 100 caractères';
    }

    // Validation de l'email
    if (empty(trim($data['email'] ?? ''))) {
        $errors['email'] = 'L\'email est obligatoire';
    } elseif (!filter_var(trim($data['email']), FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'L\'email n\'est pas valide';
    }

    // Validation du sujet
    if (empty(trim($data['subject'] ?? ''))) {
        $errors['subject'] = 'Le sujet est obligatoire';
    } elseif (strlen(trim($data['subject'])) < 5) {
        $errors['subject'] = 'Le sujet doit contenir au moins 5 caractères';
    } elseif (strlen(trim($data['subject'])) > 200) {
        $errors['subject'] = 'Le sujet ne peut pas dépasser 200 caractères';
    }

    // Validation du message
    if (empty(trim($data['message'] ?? ''))) {
        $errors['message'] = 'Le message est obligatoire';
    } elseif (strlen(trim($data['message'])) < 10) {
        $errors['message'] = 'Le message doit contenir au moins 10 caractères';
    } elseif (strlen(trim($data['message'])) > 5000) {
        $errors['message'] = 'Le message ne peut pas dépasser 5000 caractères';
    }

    // Vérification anti-spam (honeypot)
    if (!empty($data['honeypot'] ?? '')) {
        $errors['spam'] = 'Tentative de spam détectée';
    }

    return $errors;
}

class ContactController extends BaseController
{
    /**
     * Affiche le formulaire de contact
     */
    public function contact()
    {
        // Si c'est une requête POST, traiter le formulaire
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->handleContactForm();
            return;
        }

        // Sinon, afficher le formulaire
        echo $this->view('contact');
    }

    /**
     * Traite la soumission du formulaire de contact
     */
    private function handleContactForm()
    {
        try {
            // Récupération et nettoyage des données
            $data = [
                'name' => trim($_POST['name'] ?? ''),
                'email' => trim($_POST['email'] ?? ''),
                'subject' => trim($_POST['subject'] ?? ''),
                'message' => trim($_POST['message'] ?? ''),
                'honeypot' => $_POST['honeypot'] ?? ''
            ];

            // Validation des données
            $errors = validateContactForm($data);

            // Si il y a des erreurs, les afficher
            if (!empty($errors)) {
                $this->showContactFormWithErrors($errors, $data);
                return;
            }

            // Configuration de l'email destinataire
            $destinationEmail = 'enzofournier.contact@gmail.com';

            // Tentative d'envoi de l'email
            $emailSent = sendMail(
                $destinationEmail,
                '[Contact Site] ' . $data['subject'],
                $data['message'],
                $data['email'],
                $data['name']
            );

            if ($emailSent) {
                // Succès : message de confirmation et redirection
                $this->setFlashMessage('success', 'Votre message a été envoyé avec succès ! Je vous répondrai dans les plus brefs délais.');

                // Log de l'envoi (optionnel)
                error_log("Contact form submission: " . $data['email'] . " - " . $data['subject']);

                // Redirection pour éviter la resoumission
                header('Location: ' . $_SERVER['REQUEST_URI']);
                exit;
            } else {
                // Échec de l'envoi
                throw new Exception('Erreur lors de l\'envoi de l\'email');
            }
        } catch (Exception $e) {
            // Log de l'erreur
            error_log("Contact form error: " . $e->getMessage());

            // Message d'erreur à l'utilisateur
            $this->setFlashMessage('error', 'Une erreur est survenue lors de l\'envoi de votre message. Veuillez réessayer plus tard ou me contacter directement.');

            // Conserver les données saisies
            $this->showContactFormWithErrors([], $data ?? []);
        }
    }

    /**
     * Affiche le formulaire avec les erreurs et les données précédentes
     */
    private function showContactFormWithErrors($errors = [], $oldData = [])
    {
        echo $this->view('contact', [
            'errors' => $errors,
            'old' => $oldData
        ]);
    }

    /**
     * Définit un message flash pour la session
     */
    private function setFlashMessage($type, $message)
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $_SESSION['flash'][$type] = $message;
    }
}
