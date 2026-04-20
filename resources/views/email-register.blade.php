<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Confirmation d'inscription</title>
    <style>
        .container {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            height: 100vh;
            gap: 8px;
        }

        header, footer {
            background: #a88871;
            color: black;
            text-align: center;
            padding: 16px;
        }

        header img {
            width: 50px;
        }

        footer {
            padding: 64px;
        }

        .content {
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="container">
        <header><img src="{{ $message->embed(public_path('images/logo.png')) }}" alt=""></header>
        <div class="content">
            <h2>Bonjour {{ $user->name }}</h2>
            <p>Votre inscription à bien été prise en compte. <br>Pour valider votre email merci de cliquer sur le <a href="{{ $verificationUrl }}">lien</a> suivant</p>
        </div>
        <footer>© 2025 Windigo – Les photos sont des propriétés intellectuelles, toute reproduction est interdite.</footer>
    </div>
</body>
