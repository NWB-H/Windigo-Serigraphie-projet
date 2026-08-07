import { Address } from "@/models/Address";
import { Order } from "@/models/Order";

export const Roles = {
    USER: 'ROLE_USER',
    ADMIN: 'ROLE_ADMIN',
    BLOCKED: 'ROLE_BLOCKED',
} as const;

export type Role = typeof Roles[keyof typeof Roles];

export interface User {
    id: number;
    name: string;
    email: string;
    avatar?: string;
    email_verified_at: string | null;
    created_at: string;
    updated_at: string;
    role: Role;
    addresses: Address[];
    orders: Order[];
}
