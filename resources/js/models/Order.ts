export interface Order {
    id: number;
    payment_provider_id: number;
    payment_provider_name: string;
    user_d: number;
    total: number;
    status: OrderState;
    created_at: Date;
}

export type OrderState = 'en attente' | 'payée' | 'expédiée' | 'annulée'
