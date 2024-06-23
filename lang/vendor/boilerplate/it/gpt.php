<?php

return [
    'tooltip'   => 'Genera testo con GPT',
    'title'     => 'Genera con GPT',
    'error'     => 'Qualcosa è andato storto, per favore riprova',
    'copy'      => 'Contenuto copiato negli appunti',
    'copyerror' => 'Impossibile copiare il contenuto negli appunti',
    'tabs'      => [
        'wizard'   => 'Generatore guidato',
        'prompt'   => 'Inserimento manuale',
        'selected' => 'Contenuto selezionato',
    ],
    'form'      => [
        'copy'     => 'Copia',
        'actas'    => 'Scrivi come',
        'topic'    => 'Argomento',
        'keywords' => 'Parole chiave',
        'prompt'   => 'Prompt',
        'pov'      => [
            'label'         => 'Punto di vista',
            'firstsingular' => 'Prima persona singolare (io, me, mio, mia)',
            'firstplural'   => 'Prima persona plurale (noi, ci, nostro, nostra)',
            'second'        => 'Seconda persona (tu, te, tuo, tua)',
            'third'         => 'Terza persona (egli, ella, esso, loro)',
        ],
        'tone'     => [
            'label'         => 'Tono',
            'professionnal' => 'Professionale',
            'formal'        => 'Formale',
            'casual'        => 'Informale',
            'friendly'      => 'Amichevole',
            'humorous'      => 'Umoristico',
        ],
        'language' => 'Lingua',
        'submit'   => 'Genera testo',
        'undo'     => 'Annulla',
        'modify'   => 'Modifica',
        'confirm'  => 'Conferma',
        'type'     => [
            'label'        => 'Tipo di testo',
            'tagline'      => 'Titolo / Slogan',
            'introduction' => 'Introduzione',
            'summary'      => 'Sommario',
            'article'      => 'Articolo',
        ],
        'rewrite'  => [
            'original' => 'Contenuto selezionato',
            'type'     => [
                'label'           => 'Azione',
                'summarize'       => 'Sintetizza',
                'expand'          => 'Espandi',
                'rewrite'         => 'Riscrivi',
                'paraphrase'      => 'Parafrasa',
                'grammar'         => 'Correggi grammatica e ortografia',
                'question'        => 'Genera una domanda',
                'title'           => 'Suggerisci un titolo',
                'conclusion'      => 'Scrivi una conclusione',
                'counterargument' => 'Fornisci un contro-argomento',
                'translate'       => 'Traduci',
            ],
        ],
    ],
];
