<template>
    <div class="container my-5">
            <h1 class="mb-4">Mentions légales</h1>
            <p>
                Conformément à la loi n° 2004-575 du 21 juin 2004 pour la
                confiance dans l'économie numérique (LCEN), nous vous informons
                :
            </p>
            <div class="card mb-3">
                <div class="card-header">
                    Éditeur du site
                </div>
                <div class="card-body">
                    <p>
                        <strong
                            >Nom ou raison sociale :</strong
                        >
                        FOUQUET CLEMENT
                    </p>
                    <p>
                        <strong>Nom commercial :</strong>
                        WINDIGO
                    </p>
                    <p>
                        <strong>Forme juridique :</strong>
                        Entrepreneur individuel
                    </p>
                    <p>
                        <strong>Numéro SIRET :</strong> 829
                        285 485 00027
                    </p>
                    <p>
                        <strong>Numéro TVA :</strong>
                        FR79829285485
                    </p>
                    <p>
                        <strong>Adresse :</strong> 44 Rue
                        Cavaignac, Appartement 2, 72000 Le Mans, France
                    </p>
                    <p>
                        <strong>Email :</strong>
                        <a href="mailto:contact@windigo.fr"
                            >contact@windigo.fr</a
                        >
                    </p>
                    <p>
                        <strong>Téléphone :</strong> +33 2 43
                        00 00 00
                    </p>
                </div>
            </div>
            <div class="card mb-3">
                <div class="card-header">
                    Directeur de la publication
                </div>
                <div class="card-body">
                    <p>FOUQUET CLEMENT</p>
                </div>
            </div>
            <div class="card">
                <div class="card-header">Hébergeur</div>
                <div class="card-body">
                    <p>
                        <strong>Nom :</strong> o2switch
                    </p>
                    <p>
                        <strong>Adresse :</strong> 222-224
                        Boulevard Gustave Flaubert, 63000 Clermont-Ferrand,
                        France
                    </p>
                    <p>
                        <strong>Téléphone :</strong> +33 4 44
                        44 60 40
                    </p>
                    <p>
                        <strong>Site web :</strong>
                        <a
                            href="https://www.o2switch.fr"
                            target="_blank"

                            >www.o2switch.fr</a
                        >
                    </p>
                    <p>
                        <strong>Forme juridique :</strong>
                        SAS au capital de 7 500 €
                    </p>
                    <p>
                        <strong>RCS :</strong>
                        Clermont-Ferrand – SIRET : 510 909 807 00016 – TVA :
                        FR35510909807
                    </p>
                </div>
            </div>
        </div>
</template>

<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';

defineOptions({
    layout: [AppLayout, { title: 'Mentions légales'}],
})
</script>

<style scoped></style>
