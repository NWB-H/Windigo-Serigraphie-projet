export interface City {
    id: number;
    name: string;
}

export interface Address {
    id: number;
    name: string;
    address_line1: string;
    address_line2: string;
    postal_code: string;
    city: City;
    country: string;
}
