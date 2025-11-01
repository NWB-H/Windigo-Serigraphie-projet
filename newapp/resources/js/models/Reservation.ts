import type { WorkshopSession } from "./Workshop";

export interface Reservation {
  id: number;
  user_id: number;
  workshop_session_id: number;
  session?: WorkshopSession;
  remaining_places:number;
}