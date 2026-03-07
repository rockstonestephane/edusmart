<?php
/*
|--------------------------------------------------------------------------
| EduSmart School — Configuration globale
|--------------------------------------------------------------------------
| Valeurs par défaut. En production, elles seront écrasées
| par la table `settings` gérée depuis l'espace admin.
*/
return [

    // ── Identité ─────────────────────────────────────────
    'name'        => env('SCHOOL_NAME',   'EduSmart School'),
    'slogan'      => env('SCHOOL_SLOGAN', 'School of Excellence'),
    'description' => env('SCHOOL_DESC',   'Établissement privé d\'enseignement général, fondé en 1989.'),
    'footer_desc' => env('SCHOOL_FOOTER_DESC', 'Établissement privé d\'enseignement général, fondé en 1989. Nous accompagnons chaque élève avec discipline, excellence académique et valeurs humaines, du primaire aux classes préparatoires.'),
    'founded'     => env('SCHOOL_FOUNDED', '1989'),
    'logo'        => env('SCHOOL_LOGO', null),

    // ── Coordonnées ───────────────────────────────────────
    'address'     => env('SCHOOL_ADDRESS', 'Yaoundé, Cameroun'),
    'phone'       => env('SCHOOL_PHONE',   '+237 222 00 00 00'),
    'phone2'      => env('SCHOOL_PHONE2',  null),
    'email'       => env('SCHOOL_EMAIL',   'contact@edusmart.cm'),
    'website'     => env('SCHOOL_WEBSITE', 'https://edusmart.cm'),

    // ── Horaires ──────────────────────────────────────────
    'hours' => [
        'label'  => 'Ouvert · Lun–Ven 7h30–17h30',
        'detail' => 'Lundi au Vendredi : 7h30 – 17h30',
    ],

    // ── Réseaux sociaux ───────────────────────────────────
    'social' => [
        'facebook'  => env('SCHOOL_FACEBOOK',  '#'),
        'instagram' => env('SCHOOL_INSTAGRAM', '#'),
        'twitter'   => env('SCHOOL_TWITTER',   '#'),
        'linkedin'  => env('SCHOOL_LINKEDIN',  '#'),
        'youtube'   => env('SCHOOL_YOUTUBE',   '#'),
    ],

    // ── Statistiques ──────────────────────────────────────
    'stats' => [
        'eleves'      => env('SCHOOL_STAT_ELEVES',      '2 500+'),
        'enseignants' => env('SCHOOL_STAT_ENSEIGNANTS',  '120+'),
        'experience'  => env('SCHOOL_STAT_EXPERIENCE',   '35+'),
        'reussite'    => env('SCHOOL_STAT_REUSSITE',     '98%'),
    ],

    // ── Accréditations (badges footer) ────────────────────
    'accreditations' => [
        'Accrédité MINESEC',
        'ISO 9001',
        'Bilingue',
    ],

    // ── Ticker (infos flash navbar) ───────────────────────
    'flash_infos' => [
        'Rentrée 2025–2026 : les inscriptions sont ouvertes — déposez votre dossier en ligne dès maintenant',
        'Résultats du concours d\'entrée en 6ème disponibles sur l\'Espace Parent',
        'Portes ouvertes samedi 22 mars 2025 de 9h à 17h — venez découvrir nos installations',
        'Félicitations à nos bacheliers : 100 % de réussite avec 42 % de mentions !',
        'Nouveau laboratoire informatique inauguré — 60 postes disponibles pour nos élèves',
    ],

    // ── Espace parent ─────────────────────────────────────
    'espace_parent_url' => env('SCHOOL_ESPACE_PARENT_URL', '#'),

    // ── Admin ─────────────────────────────────────────────
    'admin' => [
        'email'  => env('ADMIN_EMAIL',  'admin@edusmart.cm'),
        'name'   => env('ADMIN_NAME',   'Administrateur'),
        'prefix' => env('ADMIN_PREFIX', 'admin'),
    ],

    // ── Upload ────────────────────────────────────────────
    'upload' => [
        'disk'          => 'public',
        'max_size_kb'   => 4096,
        'image_formats' => ['jpg', 'jpeg', 'png', 'webp'],
        'paths' => [
            'hero'        => 'uploads/hero',
            'actualites'  => 'uploads/actualites',
            'formations'  => 'uploads/formations',
            'galerie'     => 'uploads/galerie',
            'temoignages' => 'uploads/temoignages',
            'settings'    => 'uploads/settings',
        ],
    ],

    // ── Pagination ────────────────────────────────────────
    'pagination' => [
        'actualites' => 9,
        'formations' => 12,
        'galerie'    => 12,
        'admin'      => 15,
    ],
];