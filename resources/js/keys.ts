import type { InjectionKey } from 'vue';

export type ModalContext = {
    updateModal: (value: string) => void;
};

export const modalKey = Symbol('modal') as InjectionKey<ModalContext>;
