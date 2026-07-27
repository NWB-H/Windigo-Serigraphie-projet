import { Image, ImageForm } from '@/models/Common';
import type { Category } from './Category';
import type { Option } from './Option';

export interface Product {
    id: number;
    name: string;
    price: number;
    stock: number;
    description: string;
    archived: boolean;
    images: Image[];
    highlighted_image?: Image;

    // Relations
    category?: Category;
    option?: Option;
    picture_url?: string;
}

export interface ProductForm {
    id: number;
    name: string;
    price: number;
    stock: number;
    description: string;
    archived: boolean;
    images: ImageForm[];

    // Relations
    category_id?: number;
    option_id?: number;
}
