<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Réinitialisation du mot de passe</title>
</head>

<body style="margin:0;padding:0;background-color:#f8fafc;font-family:Arial,Helvetica,sans-serif;color:#0f172a;">

<div style="min-height:100vh;background-color:#f8fafc;padding:40px 16px;box-sizing:border-box;">

    <div style="max-width:640px;margin:0 auto;background-color:#ffffff;border-radius:16px;overflow:hidden;box-shadow:0 10px 15px -3px rgba(0,0,0,0.1),0 4px 6px -4px rgba(0,0,0,0.1);">

        <div style="background-color:#a88871;padding:32px;text-align:center;">
            <img
                src="{{ $message->embed(public_path('images/logo.png')) }}"
                alt="Windigo"
                style="width:80px;height:auto;display:block;margin:0 auto;"
            >
        </div>

        <div style="padding:40px 32px;text-align:center;">

            <h1 style="margin:0 0 16px;font-size:28px;line-height:36px;font-weight:700;color:#0f172a;">
                Réinitialisation du mot de passe
            </h1>

            <p style="margin:0 0 24px;font-size:16px;line-height:24px;color:#475569;">
                Vous avez demandé à modifier le mot de passe de votre compte Windigo.
            </p>

            <a
                href="{{ $verificationUrl }}"
                style="display:inline-block;background-color:#a88871;color:#ffffff;text-decoration:none;font-size:16px;line-height:24px;font-weight:700;padding:14px 24px;border-radius:8px;"
            >
                Changer mon mot de passe
            </a>

            <p style="margin:24px 0 0;font-size:14px;line-height:20px;color:#64748b;">
                Ce lien est valable pendant <strong style="color:#334155;">1 heure</strong>.
            </p>

            <p style="margin:16px 0 0;font-size:14px;line-height:20px;color:#64748b;">
                Si vous n'êtes pas à l'origine de cette demande, vous pouvez ignorer cet email.
            </p>

            <div style="margin-top:32px;padding-top:24px;border-top:1px solid #e2e8f0;text-align:left;">
                <p style="margin:0 0 8px;font-size:12px;line-height:16px;color:#94a3b8;">
                    Si le bouton ne fonctionne pas, copiez ce lien :
                </p>

                <a
                    href="{{ $verificationUrl }}"
                    style="font-size:12px;line-height:16px;color:#a88871;word-break:break-all;text-decoration:underline;"
                >
                    {{ $verificationUrl }}
                </a>
            </div>

        </div>

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
