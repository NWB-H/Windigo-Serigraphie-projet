import { ModalName } from '@/registries/modal';
import type { InjectionKey } from 'vue';

export type ModalContext = {
    updateModal: (value: ModalName, params?: Record<string, unknown>) => void;
    toggleModal: () => void;
};

export const modalKey = Symbol('modal') as InjectionKey<ModalContext>;
