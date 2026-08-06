import { contentModal, ModalName } from '@/registries/modal';
import { computed, ref } from 'vue';

export function useModal() {
    const currentModal = ref<ModalName | null>(null);
    const showModal = computed(() => currentModal.value !== null);
    const modalProps = ref<Record<string, unknown>>({});

    const currentModalComponent = computed(() => {
        if (!currentModal.value) {
            return null;
        }

        return contentModal[currentModal.value];
    });

    function updateModal(modal: ModalName, data?: Record<string, unknown>) {
        currentModal.value = modal;
        modalProps.value = data ?? {};
    }

    function toggleModal() {
        currentModal.value = null;
    }


    return {
        showModal,
        modalProps,
        currentModalComponent,
        updateModal,
        toggleModal,
    };
}
