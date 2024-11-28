<?php

namespace Database\Seeders;

use App\Models\Topic;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TopicSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'slug' => 'generale',
                'name' => 'Generale',
                'description' => 'Un luogo per discussioni generiche sui film: novità, curiosità e opinioni di ogni genere.',
            ],
            [
                'slug' => 'annunci',
                'name' => 'Annunci',
                'description' => 'Sezione dedicata agli annunci ufficiali del forum, inclusi aggiornamenti e novità.',
            ],
            [
                'slug' => 'supporto',
                'name' => 'Supporto',
                'description' => 'Hai problemi tecnici con il forum? Chiedi qui e ricevi aiuto dalla community o dagli admin.',
            ],
            [
                'slug' => 'suggerimenti',
                'name' => 'Suggerimenti',
                'description' => 'Condividi le tue idee per migliorare il forum o suggerisci nuove funzionalità.',
            ],
            [
                'slug' => 'bug',
                'name' => 'Bug',
                'description' => 'Segnala problemi o malfunzionamenti riscontrati nel forum. Aiutaci a migliorare!',
            ],
            [
                'slug' => 'domande',
                'name' => 'Domande',
                'description' => 'Hai domande sui film, attori o registi? Postale qui e trova risposte dalla community.',
            ],
            [
                'slug' => 'altro',
                'name' => 'Altro',
                'description' => 'Per discussioni che non rientrano nelle altre categorie. Sentiti libero di condividere qualsiasi cosa qui.',
            ],
        ];

        Topic::upsert($data, ['slug']);
    }
}
