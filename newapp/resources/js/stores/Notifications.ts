import { ref } from 'vue'
import { defineStore } from 'pinia'
import { v4 as uuidv4 } from 'uuid'

export type ItemType = 'success' | 'error' | 'warning' // todo: mettre dans un fichier

export interface Item {
    id?: string,
    type: ItemType,
    message: string
}

export const useNotificationStore = defineStore('notifications', () => {
    const items = ref<ItemType[]>([])

    function addItem(item: Item) {
        items.value.push({ id: uuidv4(), ...item })
    }

    function removeItem(item: Item) {
        const index = items.value.find(i => i === item)

        items.value.splice(index, 1)
    }

    return {
        items,
        addItem,
        removeItem
    }
})
