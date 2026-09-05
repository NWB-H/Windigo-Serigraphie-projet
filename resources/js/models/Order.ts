export type OrderStatus = 'pending' | 'rejected' | 'paid';

export interface Order {
    id: number;
    payment_provider_id: string;
    payment_provider_name: string;
    user_id: string;
    total: number;
    status: OrderStatus;
    created_at: Date;
    updated_at: Date;
}
