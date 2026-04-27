<template>
    <AppLayoutAdmin title="Administration produits">
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
                    <tr v-for="product in products" :key="product.id">
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
                                :url="
                                    product.images
                                        ?.filter((i) => i.isHighlighted)
                                        .at(0)?.url
                                "
                                alt="Image produit"
                                imgCssClass="img-cover-50"
                            />
                        </td>

                        <td>
                            <button
                                class="btn btn-sm btn-warning me-2"
                                type="button"
                                @click="edit(product)"
                            >
                                Modifier
                            </button>
                            <button
                                class="btn btn-sm btn-danger"
                                type="button"
                                @click="deleteProduct(product)"
                            >
                                Supprimer
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
            <AppPagination
                :totalPage="productsPaginated.pagination.totalPage"
                :currentPage="productsPaginated.pagination.currentPage"
                :path="productsPaginated.pagination.path"
            />
        </div>
    </AppLayoutAdmin>
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

const props = defineProps<{
    productsPaginated: ResourcePaginated<Product>;
    categories: Category[];
    options: Option[];
}>();

const showForm = ref(false);
const products = ref(props.productsPaginated.items);

const currentProduct = ref<Product>();

function newProduct() {
    currentProduct.value = undefined;

    showForm.value = true;
}

function edit(product: Product) {
    currentProduct.value = product;

    showForm.value = true;
}

function deleteProduct(product: Product) {
    const index = products.value.findIndex((i: Product) => i.id === product.id);

    if (index !== -1) {
        ProductRepository.deleteProduct(product).then(() => {
            products.value.splice(index, 1);
            router.flash('notification', {
                message: 'Produit supprimé',
                type: 'success',
            });
        });
    }
}
</script>

<style scoped></style>
