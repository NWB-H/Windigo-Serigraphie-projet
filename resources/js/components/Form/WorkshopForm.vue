<script setup lang="ts"></script>

<template>
    <form @submit.prevent="saveWorkshop" class="space-y-3">
        <input
            v-model="form.name"
            placeholder="Nom"
            class="w-full border p-2"
            required
        />
        <input
            v-model="form.type"
            placeholder="Type"
            class="w-full border p-2"
            required
        />
        <input
            v-model.number="form.price"
            type="number"
            placeholder="Prix"
            class="w-full border p-2"
            required
        />
        <input
            v-model.number="form.duration"
            type="number"
            placeholder="Durée (min)"
            class="w-full border p-2"
            required
        />
        <input
            v-model.number="form.age"
            type="number"
            placeholder="Age minimum"
            class="w-full border p-2"
            required
        />

        <!-- Description -->
        <textarea
            v-model="form.description"
            placeholder="Description"
            class="w-full border p-2"
            rows="4"
        ></textarea>

        <!-- Upload images multiples -->
        <div>
            <label class="mb-1 block font-medium"
                >Images (plusieurs possibles)</label
            >
            <input
                type="file"
                multiple
                @change="handleFilesChange"
                class="w-full border p-1"
            />
        </div>

        <!-- Aperçu images existantes et nouvelles -->
        <div class="mt-2 flex flex-wrap gap-2">
            <!-- Images existantes -->
            <div
                v-for="(img, index) in visibleImages"
                :key="'existing-' + index"
                class="relative"
            >
                <img
                    :src="`https://back.windigoprint.com/storage/${img}`"
                    class="table-image border"
                />
                <button
                    type="button"
                    @click="removedImages.push(img)"
                    class="absolute top-0 right-0 flex h-5 w-5 items-center justify-center rounded-full bg-red-600 text-xs text-white"
                >
                    x
                </button>
            </div>

            <!-- Nouvelles images sélectionnées -->
            <div
                v-for="(img, index) in previewImages"
                :key="'preview-' + index"
                class="relative"
            >
                <img :src="img" class="table-image border" />
                <button
                    type="button"
                    @click="removePreviewImage(index)"
                    class="absolute top-0 right-0 flex h-5 w-5 items-center justify-center rounded-full bg-red-600 text-xs text-white"
                >
                    x
                </button>
            </div>
        </div>

        <div class="mt-2 space-x-2">
            <button
                class="rounded bg-blue-600 px-4 py-2 text-white"
                :disabled="store.loading"
            >
                {{ form.id ? 'Mettre à jour' : 'Créer' }}
            </button>
            <button
                type="button"
                @click="resetForm"
                class="rounded bg-gray-300 px-4 py-2"
            >
                Annuler
            </button>
        </div>
    </form>
</template>

<style scoped></style>
