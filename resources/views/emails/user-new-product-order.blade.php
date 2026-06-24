<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Confirmation de commande #{{ $order->id }}</title>
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

        <div style="padding:40px 32px;">

            <h1 style="margin:0 0 16px;font-size:28px;line-height:36px;font-weight:700;color:#0f172a;text-align:center;">
                Merci pour votre commande
            </h1>

            <p style="margin:0 0 24px;font-size:16px;line-height:24px;color:#475569;text-align:center;">
                Bonjour {{ $order->user->name }},
            </p>

            <p style="margin:0 0 32px;font-size:16px;line-height:24px;color:#475569;text-align:center;">
                Nous avons bien reçu votre commande <strong>#{{ $order->id }}</strong>.
                Elle est actuellement en cours de traitement et sera préparée dans les meilleurs délais.
            </p>

            <div style="margin-bottom:32px;padding:24px;background-color:#f8fafc;border-radius:12px;border:1px solid #e2e8f0;">
                <h2 style="margin:0 0 16px;font-size:20px;line-height:28px;color:#0f172a;">
                    Adresse de livraison
                </h2>

                <p style="margin:0;font-size:14px;line-height:22px;color:#334155;">
                    {{ $order->user->name }}<br>
                    {{ $order->user->deliveryAddress->name ?? 'Adresse non renseignée' }}
                </p>
            </div>

            <div style="margin-bottom:32px;">
                <h2 style="margin:0 0 16px;font-size:20px;line-height:28px;color:#0f172a;">
                    Récapitulatif de votre commande
                </h2>

                <table width="100%" cellpadding="0" cellspacing="0" style="border-collapse:collapse;">
                    <thead>
                    <tr>
                        <th align="left" style="padding:12px;border-bottom:1px solid #e2e8f0;font-size:13px;color:#64748b;">
                            Produit
                        </th>

                        <th align="center" style="padding:12px;border-bottom:1px solid #e2e8f0;font-size:13px;color:#64748b;">
                            Qté
                        </th>

                        <th align="right" style="padding:12px;border-bottom:1px solid #e2e8f0;font-size:13px;color:#64748b;">
                            Prix
                        </th>
                    </tr>
                    </thead>

                    <tbody>
                    @foreach($order->products as $product)
                        <tr>
                            <td style="padding:12px;border-bottom:1px solid #e2e8f0;font-size:14px;color:#334155;">
                                {{ $product->name }}
                            </td>

                            <td align="center" style="padding:12px;border-bottom:1px solid #e2e8f0;font-size:14px;color:#334155;">
                                {{ $product->pivot->quantity }}
                            </td>

                            <td align="right" style="padding:12px;border-bottom:1px solid #e2e8f0;font-size:14px;color:#334155;">
                                {{ number_format($product->pivot->quantity * $product->pivot->price, 2, ',', ' ') }} €
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

            <div style="padding:24px;background-color:#a88871;border-radius:12px;text-align:right;">
                <p style="margin:0;font-size:16px;line-height:24px;color:#ffffff;">
                    Total payé
                </p>

                <p style="margin:4px 0 0;font-size:28px;line-height:36px;font-weight:700;color:#ffffff;">
                    {{ number_format($order->total, 2, ',', ' ') }} €
                </p>
            </div>

            <p style="margin:32px 0 0;font-size:14px;line-height:22px;color:#64748b;text-align:center;">
                Merci pour votre confiance. Nous vous contacterons si nous avons besoin
                d'informations complémentaires concernant votre commande.
            </p>

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
