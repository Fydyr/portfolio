<?php ob_start(); ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Admin - CV</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.0/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="/assets/css/style.css" rel="stylesheet">
</head>
<body>
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="mb-0">Gestion du CV</h1>
        <a href="<?= url('admin') ?>" class="btn btn-outline-light">
            <i class="bi bi-arrow-left"></i> Retour
        </a>
    </div>

    <div class="card mb-4">
        <div class="card-header">
            <h2 class="mb-0"><i class="bi bi-file-earmark-pdf"></i> CV actuel</h2>
        </div>
        <div class="card-body">
            <?php if (!empty($cv['exists'])): ?>
                <p>
                    <strong>Fichier :</strong> mon_cv.pdf<br>
                    <strong>Taille :</strong> <?= number_format($cv['size'] / 1024, 1, ',', ' ') ?> Ko<br>
                    <strong>Dernière modification :</strong> <?= date('d/m/Y H:i', $cv['modified']) ?>
                </p>
                <a href="/assets/docs/mon_cv.pdf" class="btn btn-primary" target="_blank">
                    <i class="bi bi-eye"></i> Aperçu
                </a>
                <a href="/assets/docs/mon_cv.pdf" class="btn btn-secondary" download>
                    <i class="bi bi-download"></i> Télécharger
                </a>
                <form method="post" action="<?= url('admin/cv/delete') ?>" class="d-inline"
                      onsubmit="return confirm('Supprimer le CV actuel ? Le lien public ne fonctionnera plus tant qu\'un nouveau n\'est pas uploadé.');">
                    <button type="submit" class="btn btn-danger">
                        <i class="bi bi-trash"></i> Supprimer
                    </button>
                </form>
            <?php else: ?>
                <div class="alert alert-warning mb-0">
                    <i class="bi bi-exclamation-triangle-fill"></i>
                    Aucun CV n'est actuellement uploadé. Le bouton "Télécharger mon CV" de la page d'accueil renvoie un 404.
                </div>
            <?php endif; ?>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h2 class="mb-0">
                <i class="bi bi-upload"></i>
                <?= !empty($cv['exists']) ? 'Remplacer le CV' : 'Uploader un CV' ?>
            </h2>
        </div>
        <div class="card-body">
            <form method="post" action="<?= url('admin/cv/upload') ?>" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="cv" class="form-label">Fichier PDF (max 10 Mo)</label>
                    <input type="file" name="cv" id="cv" class="form-control" accept="application/pdf,.pdf" required>
                    <div class="form-text">
                        Le nouveau fichier remplace définitivement l'ancien. L'URL publique reste <code>/assets/docs/mon_cv.pdf</code>.
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-cloud-upload"></i> Envoyer
                </button>
            </form>
        </div>
    </div>
</div>
</body>
</html>
<?php $content = ob_get_clean(); include 'layout.php'; ?>
