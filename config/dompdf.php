<?php

return [
    'show_warnings' => false,
    'orientation' => 'portrait',

    'defines' => [
        'font_dir' => storage_path('fonts/'), // Path ke storage/fonts
        'font_cache' => storage_path('fonts/'),
        'temp_dir' => sys_get_temp_dir(),
        'chroot' => base_path(),
        'enable_font_subsetting' => false,
        'pdf_backend' => 'CPDF',
        'default_media_type' => 'screen',
        'default_paper_size' => 'a4',
        'dpi' => 96,
        'enable_php' => false,
        'enable_javascript' => true,
        'enable_remote' => true,
        'font_height_ratio' => 1.1,
        'enable_html5_parser' => false,
    ],

    'defaults' => [
        'font' => 'arial',
    ],
];
