export interface Workshop {
  id: number;
  name: string;
  type: string;
  price: number;
  duration: number;
  age: number;
  description?: string;          
  images?: string[];             
  first_image_url?: string;      
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
