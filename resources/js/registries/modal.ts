import AddressForm from '@/components/Modal/AddressForm.vue';

export const contentModal = {
    address: AddressForm,
} as const;

export type ModalName = keyof typeof contentModal;
