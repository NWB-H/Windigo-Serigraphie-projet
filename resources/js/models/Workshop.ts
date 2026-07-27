import { Image, ImageForm } from '@/models/Common';

export interface Workshop {
    id: number;
    name: string;
    type: string;
    price: number;
    duration: number;
    age: number;
    description?: string;
    images: Image[];
    highlighted_image?: Image;
    workshop_sessions?: WorkshopSession[];
}

export interface WorkshopSession {
    id: number;
    workshop_id: number;
    session_number: number;
    date: string;
    capacity: number;
    remaining_places: number;
}

export interface WorkshopForm {
    id: number;
    name: string;
    type: string;
    price: number;
    duration: number;
    age: number;
    description?: string;
    images: ImageForm[];
}
