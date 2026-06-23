export * from './Cart';
export * from './Category';
export * from './Option';
export * from './Order';
export * from './Product';
export * from './Reservation';
export * from './Workshop';
export * from './Common';

export interface Pagination {
    currentPage: number;
    total: number;
    totalPage: number;
    path: string;
}

export interface ResourcePaginated<T> {
    pagination: Pagination;
    items: T[];
}
