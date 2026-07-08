<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\City;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

final class ImportCommunes extends Command
{
    protected $signature = 'app:commune:import';

    protected $description = 'Import all communes from geo api gouv';

    public function handle(): void
    {
        $this->info('Téléchargement des communes...');

        $response = Http::timeout(60)->get('https://geo.api.gouv.fr/communes', [
            'fields' => 'nom,code,codesPostaux,departement,region,centre',
            'format' => 'json',
        ]);

        if (!$response->successful()) {
            $this->error('Erreur lors du téléchargement.');
            return;
        }

        $communes = $response->json();

        $this->info(count($communes) . ' communes récupérées.');

        City::truncate();

        foreach (array_chunk($communes, 500) as $chunk) {
            $data = [];

            foreach ($chunk as $commune) {
                $codesPostaux = $commune['codesPostaux'] ?? [];

                $data[] = [
                    'nom' => $commune['nom'],
                    'postal_codes' => json_encode($codesPostaux),
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            City::insert($data);
        }

        $this->info('Import terminé.');
    }
}
