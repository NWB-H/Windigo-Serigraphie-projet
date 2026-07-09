import type { InjectionKey } from 'vue';
import { ModalName } from '@/types';

export type ModalContext = {
    updateModal: (value: ModalName, params?: Record<string, unknown>) => void;
};

export const modalKey = Symbol('modal') as InjectionKey<ModalContext>;
