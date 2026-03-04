<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Confirmation d'inscription</title>
</head>

<body>
    <h2>Bienvenue {{ $user->name }} !</h2>
    <p>Merci de vous être inscrit sur notre site.</p>
    <p>Veuillez confirmer votre adresse e-mail en cliquant sur le lien ci-dessous :</p>

    <a>
        Vérifier mon compte
    </a>

    <p>Ce lien est valable pendant 24 heures.</p>
</body>
