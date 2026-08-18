```html
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nouveau message - Windigo</title>
</head>

<body style="margin:0;padding:0;background-color:#f8fafc;font-family:Arial,Helvetica,sans-serif;color:#0f172a;">

<div style="min-height:100vh;background-color:#f8fafc;padding:40px 16px;box-sizing:border-box;">

    <div style="max-width:640px;margin:0 auto;background-color:#ffffff;border-radius:16px;overflow:hidden;box-shadow:0 10px 15px -3px rgba(0,0,0,0.1),0 4px 6px -4px rgba(0,0,0,0.1);">

        <!-- Header -->
        <div style="background-color:#a88871;padding:32px;text-align:center;">

            <img
                src="{{ $message->embed(public_path('images/logo.png')) }}"
                alt="Windigo"
                style="width:80px;height:auto;display:block;margin:0 auto;"
            >

        </div>

        <!-- Content -->
        <div style="padding:40px 32px;">

            <h1 style="margin:0 0 16px;font-size:28px;line-height:36px;font-weight:700;color:#0f172a;text-align:center;">
                Nouveau message
            </h1>

            <p style="margin:0 0 32px;font-size:16px;line-height:24px;color:#475569;text-align:center;">
                Vous avez reçu un nouveau message depuis le formulaire de contact du site Windigo.
            </p>

            <!-- Informations du contact -->
            <div style="margin-bottom:32px;padding:24px;background-color:#f8fafc;border-radius:12px;border:1px solid #e2e8f0;">

                <h2 style="margin:0 0 16px;font-size:20px;line-height:28px;color:#0f172a;">
                    Coordonnées
                </h2>

                <p style="margin:0;font-size:14px;line-height:22px;color:#334155;">
                    <strong>Adresse e-mail</strong><br>
                    <a
                        href="mailto:{{ $email }}"
                        style="color:#a88871;text-decoration:none;"
                    >
                        {{ $email }}
                    </a>
                </p>

            </div>

            <!-- Message -->
            <div style="margin-bottom:32px;">

                <h2 style="margin:0 0 16px;font-size:20px;line-height:28px;color:#0f172a;">
                    Message
                </h2>

                <div style="padding:24px;background-color:#ffffff;border-radius:12px;border:1px solid #e2e8f0;">

                    <p style="margin:0;font-size:15px;line-height:24px;color:#334155;white-space:pre-line;">
                        {{ $contactMessage }}
                    </p>

                </div>

            </div>

            <!-- Bouton réponse -->
            <div style="text-align:center;margin-bottom:32px;">

                <a
                    href="mailto:{{ $email }}"
                    style="display:inline-block;padding:14px 24px;background-color:#a88871;color:#ffffff;text-decoration:none;border-radius:8px;font-size:15px;font-weight:700;"
                >
                    Répondre à ce message
                </a>

            </div>

            <p style="margin:0;font-size:14px;line-height:22px;color:#64748b;text-align:center;">
                Ce message a été envoyé depuis le formulaire de contact du site Windigo.
            </p>

        </div>

        <!-- Footer -->
        <div style="background-color:#f1f5f9;padding:24px;text-align:center;">

            <p style="margin:0;font-size:12px;line-height:18px;color:#64748b;">
                © {{ date('Y') }} Windigo – Les photos sont des propriétés intellectuelles,
                toute reproduction est interdite.
            </p>

        </div>

    </div>

</div>

</body>
</html>
```
