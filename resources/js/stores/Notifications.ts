import { defineStore } from 'pinia';
import { v4 as uuidv4 } from 'uuid';
import { ref } from 'vue';

export type ItemType = 'success' | 'error' | 'warning'; // todo: mettre dans un fichier

export interface Item {
    id?: string;
    type: ItemType;
    message: string;
}

export const useNotificationStore = defineStore('notifications', () => {
    const items = ref<ItemType[]>([]);

    function addItem(item: Item) {
        items.value.push({ id: uuidv4(), ...item });
    }

    function removeItem(item: Item) {
        const index = items.value.find((i) => i === item);

        items.value.splice(index, 1);
    }

    function needImplementationNotification() {
        // todo: delete it when all feature are done
        items.value.push({
            id: uuidv4(),
            type: 'warning',
            message: 'Cette feature doit être implémenté.',
        });
    }

    return {
        items,
        addItem,
        removeItem,
        needImplementationNotification,
    };
});
