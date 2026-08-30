<template>
    <div class="container my-5">
        <div class="flex gap-2">
            <h2>Gestion Produits</h2>
            <button class="btn btn-success mb-3" @click="newProduct()">
                Ajouter un produit
            </button>
        </div>

        <!-- Formulaire -->
        <div v-if="showForm" class="card mb-4 p-3">
            <ProductForm
                :options="options"
                :categories="categories"
                :product="currentProduct"
                :key="currentProduct ? currentProduct.id : 'new-product'"
                @close="showForm = false"
            />
        </div>

        <!-- Table produits -->
        <table class="table-striped table">
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Prix</th>
                    <th>Stock</th>
                    <th>Description</th>
                    <th>Catégorie</th>
                    <th>Option</th>
                    <th>Archivé</th>
                    <th>Image</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr
                    v-for="product in productsPaginated.items"
                    :key="product.id"
                    class="align-middle"
                >
                    <td>{{ product.name }}</td>
                    <td>{{ product.price }} €</td>
                    <td>{{ product.stock }}</td>
                    <td>
                        {{
                            product.description.length > 50
                                ? product.description.slice(0, 50) + '...'
                                : product.description
                        }}
                    </td>
                    <td>{{ product.category?.name || '-' }}</td>
                    <td>{{ product.option?.name || '-' }}</td>
                    <td>{{ product.archived ? 'Oui' : 'Non' }}</td>
                    <td>
                        <AppImage
                            :url="product.highlighted_image?.url"
                            alt="Image produit"
                            imgCssClass="img-cover-50"
                        />
                    </td>

                    <td>
                        <div class="flex gap-2">
                            <AppButton
                                ignoreStyle
                                class="rounded bg-yellow-400 px-2 py-1"
                                type="default"
                                @click="edit(product)"
                            >
                                ✏️
                            </AppButton>
                            <AppButton
                                ignoreStyle
                                class="rounded bg-red-500 px-2 py-1 text-white"
                                type="default"
                                @click="deleteProduct(product)"
                            >
                                🗑️
                            </AppButton>
                            <ToolTip
                                v-if="product.stock <= 3"
                                :tooltip="
                                    product.stock === 0
                                        ? 'Stock vide'
                                        : 'Il ne reste plus que ' +
                                          product.stock +
                                          ' produit en stock'
                                "
                            >
                                <ExclamationTriangleIcon
                                    class="size-[36px]"
                                    :class="[
                                        product.stock === 0
                                            ? 'text-red-500'
                                            : 'text-amber-500',
                                    ]"
                                />
                            </ToolTip>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
        <AppPagination
            v-if="productsPaginated.pagination.totalPage > 1"
            :totalPage="productsPaginated.pagination.totalPage"
            :currentPage="productsPaginated.pagination.currentPage"
            :path="productsPaginated.pagination.path"
        />
    </div>
</template>

<script setup lang="ts">
import AppImage from '@/components/AppImage.vue';
import AppPagination from '@/components/AppPagination.vue';
import ProductForm from '@/components/Form/ProductForm.vue';
import AppLayoutAdmin from '@/layouts/AppLayoutAdmin.vue';
import { Category, Option, Product, ResourcePaginated } from '@/models';
import ProductRepository from '@/services/ProductRepository';
import { router } from '@inertiajs/vue3';
import { ref } from 'vue';
import ExclamationTriangleIcon from '@/components/Icon/ExclamationTriangleIcon.vue';
import ToolTip from '@/components/ToolTip.vue';
import AppButton from '@/components/Global/AppButton.vue';

defineOptions({
    layout: AppLayoutAdmin,
});
const { productsPaginated } = defineProps<{
    productsPaginated: ResourcePaginated<Product>;
    categories: Category[];
    options: Option[];
}>();

const showForm = ref(false);

const currentProduct = ref<Product>();

function newProduct() {
    currentProduct.value = undefined;

    showForm.value = true;
}

function edit(product: Product) {
    currentProduct.value = product;

    showForm.value = true;
}

async function deleteProduct(product: Product) {
    await ProductRepository.deleteProduct(product);

    router.reload({
        only: ['productsPaginated'],
        onSuccess: () => {
            router.flash('notification', {
                message: 'Produit supprimé',
                type: 'success',
            });
        },
    });
}
</script>

<style scoped></style>
