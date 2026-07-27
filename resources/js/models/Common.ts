export interface Image {
    id?: number;
    isHighlighted: boolean;
    url: string;
}

export interface ImageForm {
    file: File;
    isHighlighted: boolean;
}
