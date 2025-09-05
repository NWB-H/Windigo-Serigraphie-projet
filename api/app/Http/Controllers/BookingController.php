<?php

namespace App\Http\Controllers;

use App\Models\WorkshopSession;
use App\Models\Reservation;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{

    public function index()
    {
        $user = Auth::user();

        $reservations = Reservation::with('session.workshop')
            ->where('user_id', $user->id)
            ->get();

        return response()->json([
            'success' => true,
            'data' => $reservations
        ]);
    }

    public function availableSessions($workshop_id)
    {
        $sessions = WorkshopSession::where('workshop_id', $workshop_id)
            ->where('date', '>=', now())
            ->whereRaw('capacity > (SELECT COUNT(*) FROM reservations WHERE workshop_session_id = workshop_sessions.id)')
            ->orderBy('date', 'asc')
            ->get();

        return response()->json([
            'success' => true,
            'message' => 'Sessions disponibles pour réservation',
            'data' => $sessions
        ]);
    }

    public function store($session_id)
    {
        $user = Auth::user();

        $session = WorkshopSession::findOrFail($session_id);
 
        if ($session->reservations()->count() >= $session->capacity) {
            return response()->json([
                'success' => false,
                'message' => 'Cette session est complète ❌'
            ], 400);
        }

        if (Reservation::where('user_id', $user->id)
            ->where('workshop_session_id', $session->id)
            ->exists()
        ) {
            return response()->json([
                'success' => false,
                'message' => 'Vous avez déjà réservé cette session ⚠️'
            ], 400);
        }
        $reservation = Reservation::create([
            'user_id' => $user->id,
            'workshop_session_id' => $session->id,
        ]);
        return response()->json([
            'success' => true,
            'message' => 'Réservation confirmée ✅',
            'data' => $reservation
        ], 201);
    }

   public function destroy($id)
    {
        $reservation = Reservation::findOrFail($id);

        if ($reservation->user_id !== Auth::id()) {
            return response()->json([
                'success' => false,
                'message' => 'Action non autorisée ❌'
            ], 403);
        }

        $reservation->delete();

        return response()->json([
            'success' => true,
            'message' => 'Réservation annulée ❌',
            'data' => ['id' => $id]
        ]);
    }
}
