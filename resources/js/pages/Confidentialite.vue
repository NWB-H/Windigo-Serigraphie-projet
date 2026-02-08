<template>
    <AppLayout title="Confidentialité">
        <div class="container my-5">
            <h1 class="mb-4">Politique de confidentialité</h1>
            <p>Chez <strong>Windigo</strong>, nous attachons une grande importance à la protection de vos données personnelles. Voici comment nous les collectons et les utilisons.</p>

            <div class="card mb-3">
                <div class="card-header">Données collectées</div>
                <div class="card-body">
                    <ul>
                        <li>Nom et prénom</li>
                        <li>Adresse e-mail</li>
                        <li>Adresse postale</li>
                        <li>Numéro de téléphone</li>
                        <li>Informations de paiement</li>
                    </ul>
                </div>
            </div>

            <div class="card mb-3">
                <div class="card-header">Finalité de la collecte</div>
                <div class="card-body">
                    <ul>
                        <li>Permettre la passation et le traitement des commandes</li>
                        <li>Assurer le suivi des livraisons</li>
                        <li>Communiquer avec vous concernant votre commande</li>
                    </ul>
                </div>
            </div>

            <div class="card mb-3">
                <div class="card-header">Partage des données</div>
                <div class="card-body">
                    <p>Les données ne sont pas vendues ni partagées à des fins commerciales. Elles peuvent être transmises uniquement aux prestataires nécessaires (paiement, livraison).</p>
                </div>
            </div>

            <div class="card mb-3">
                <div class="card-header">Sécurité des données</div>
                <div class="card-body">
                    <p>Nous protégeons vos données avec des mesures techniques et organisationnelles appropriées.</p>
                </div>
            </div>

            <div class="card mb-3">
                <div class="card-header">Droits des utilisateurs</div>
                <div class="card-body">
                    <ul>
                        <li>Droit d’accès, de rectification ou de suppression de vos données</li>
                        <li>Droit de limiter le traitement de vos données</li>
                        <li>Droit d’opposition au traitement</li>
                    </ul>
                    <p>Pour exercer vos droits : <a href="mailto:contact@windigo.fr">contact@windigo.fr</a></p>
                </div>
            </div>

            <div class="card mb-3">
                <div class="card-header">Cookies</div>
                <div class="card-body">
                    <p>Actuellement, notre site n’utilise pas de cookies.</p>
                </div>
            </div>

            <div class="card">
                <div class="card-header">Modifications</div>
                <div class="card-body">
                    <p>Cette politique peut être mise à jour. La version la plus récente sera toujours disponible sur cette page.</p>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
<script setup lang="ts">
import AppLayout from "@/layouts/AppLayout.vue";
</script>
