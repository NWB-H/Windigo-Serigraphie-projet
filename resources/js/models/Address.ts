export interface Address {
    id?: number;
    name: string;
    address_line1: string;
    address_line2?: string;
    postal_code: string;
    city: string;
    country: string;
}

export interface AddressForm {
    id?: number;
    name: string;
    address_line1: string;
    address_line2?: string;
    postal_code: string;
    country: string;
    city: string;
}
