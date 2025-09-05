<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WorkshopSession;
use App\Models\Workshop;

class WorkshopSessionController extends Controller
{
    /**
     * Liste des sessions d’un atelier avec réservations et places restantes
     */
    public function index($workshopId)
    {
        $workshop = Workshop::with(['workshopSessions' => function ($q) {
            $q->withCount('reservations'); // ajoute reservations_count
        }])->findOrFail($workshopId);

        $sessions = $workshop->workshopSessions->map(function ($s) {
            return [
                'id' => $s->id,
                'workshop_id' => $s->workshop_id,
                'session_number' => $s->session_number,
                'date' => $s->date->format('Y-m-d H:i'), // date + heure
                'capacity' => $s->capacity,
                'reservations_count' => $s->reservations_count,
                'remaining_places' => $s->capacity - $s->reservations_count,
            ];
        });

        return response()->json([
            'success' => true,
            'workshop' => [
                'id' => $workshop->id,
                'name' => $workshop->name,
                'workshopSessions' => $sessions,
            ]
        ]);
    }

    /**
     * Création d’une session
     */
    public function store(Request $request, $workshopId)
    {
        $workshop = Workshop::findOrFail($workshopId);

        $validated = $request->validate([
            'capacity' => 'required|integer|min:1',
            'date' => ['required', 'date_format:Y-m-d H:i'],
        ]);

        // Numéro de session automatique : max + 1
        $lastNumber = $workshop->workshopSessions()->max('session_number') ?? 0;
        $validated['session_number'] = $lastNumber + 1;
        $validated['workshop_id'] = $workshop->id;

        $session = WorkshopSession::create($validated);
        $session->loadCount('reservations');

        return response()->json([
            'success' => true,
            'message' => 'Session créée avec succès ✅',
            'data' => [
                'id' => $session->id,
                'workshop_id' => $session->workshop_id,
                'session_number' => $session->session_number,
                'date' => $session->date->format('Y-m-d H:i'),
                'capacity' => $session->capacity,
                'reservations_count' => $session->reservations_count,
                'remaining_places' => $session->capacity - $session->reservations_count,
            ]
        ], 201);
    }

    /**
     * Mise à jour d’une session
     */
    public function update(Request $request, $workshopId, $id)
    {
        $validated = $request->validate([
            'session_number' => 'integer',
            'capacity' => 'integer|min:1',
            'date' => 'date_format:Y-m-d H:i',
        ]);

        $session = WorkshopSession::findOrFail($id);
        $session->update($validated);
        $session->loadCount('reservations');

        return response()->json([
            'success' => true,
            'message' => 'Session mise à jour ✅',
            'data' => [
                'id' => $session->id,
                'workshop_id' => $session->workshop_id,
                'session_number' => $session->session_number,
                'date' => $session->date->format('Y-m-d H:i'),
                'capacity' => $session->capacity,
                'reservations_count' => $session->reservations_count,
                'remaining_places' => $session->capacity - $session->reservations_count,
            ]
        ]);
    }

    /**
     * Suppression d’une session
     */
    public function destroy($workshopId, $id)
    {
        $session = WorkshopSession::findOrFail($id);
        $session->delete();

        return response()->json([
            'success' => true,
            'message' => 'Session supprimée ❌',
            'data' => ['id' => $id]
        ]);
    }
}
