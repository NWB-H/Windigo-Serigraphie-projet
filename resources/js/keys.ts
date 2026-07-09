import type { InjectionKey } from 'vue';
import { ModalName } from "@/registries/modal";

export type ModalContext = {
    updateModal: (value: ModalName, params?: Record<string, unknown>) => void;
    toggleModal: () => void;
};

export const modalKey = Symbol('modal') as InjectionKey<ModalContext>;
