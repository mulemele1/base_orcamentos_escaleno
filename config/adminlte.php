<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Title
    |--------------------------------------------------------------------------
    |
    | Here you can change the default title of your admin panel.
    |
    | For detailed instructions you can look the title section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'title' => 'Sistema de Gestão de Obras',
    'title_prefix' => '',
    'title_postfix' => '',

    /*
    |--------------------------------------------------------------------------
    | Favicon
    |--------------------------------------------------------------------------
    |
    | Here you can activate the favicon.
    |
    | For detailed instructions you can look the favicon section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'use_ico_only' => false,
    'use_full_favicon' => false,

    /*
    |--------------------------------------------------------------------------
    | Logo
    |--------------------------------------------------------------------------
    |
    | Here you can change the logo of your admin panel.
    |
    | For detailed instructions you can look the logo section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'logo' => '<b>Gestão - </b>Obras',
    'logo_img' => 'vendor/adminlte/dist/img/BRANCO_GRADIENTE.png',
    'logo_img_class' => 'brand-image img-circle elevation-3',
    'logo_img_xl' => null,
    'logo_img_xl_class' => 'brand-image-xs',
    'logo_img_alt' => 'Gestão de Obras',

    /*
    |--------------------------------------------------------------------------
    | User Menu
    |--------------------------------------------------------------------------
    |
    | Here you can activate and change the user menu.
    |
    | For detailed instructions you can look the user menu section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'usermenu_enabled' => true,
    'usermenu_header' => false,
    'usermenu_header_class' => 'bg-secondary',
    'usermenu_image' => true,
    'usermenu_desc' => false,
    'usermenu_profile_url' => false,

    /*
    |--------------------------------------------------------------------------
    | Layout
    |--------------------------------------------------------------------------
    |
    | Here we change the layout of your admin panel.
    |
    | For detailed instructions you can look the layout section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    'layout_topnav' => null,
    'layout_boxed' => null,
    'layout_fixed_sidebar' => true,
    'layout_fixed_navbar' => true,
    'layout_fixed_footer' => true,
    'layout_dark_mode' => null,

    /*
    |--------------------------------------------------------------------------
    | Authentication Views Classes
    |--------------------------------------------------------------------------
    |
    | Here you can change the look and behavior of the authentication views.
    |
    | For detailed instructions you can look the auth classes section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    'classes_auth_card' => 'card card-outline card-danger',
    'classes_auth_header' => '',
    'classes_auth_body' => '',
    'classes_auth_footer' => '',
    'classes_auth_icon' => '',
    'classes_auth_btn' => 'btn bg-lightblue',

    /*
    |--------------------------------------------------------------------------
    | Admin Panel Classes
    |--------------------------------------------------------------------------
    |
    | Here you can change the look and behavior of the admin panel.
    |
    | For detailed instructions you can look the admin panel classes here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    'classes_body' => '',
    'classes_brand' => '',
    'classes_brand_text' => '',
    'classes_content_wrapper' => '',
    'classes_content_header' => '',
    'classes_content' => '',
    'classes_sidebar' => 'sidebar-dark-danger elevation-4',
    'classes_sidebar_nav' => '',
    'classes_topnav' => 'navbar-white navbar-light',
    'classes_topnav_nav' => 'navbar-expand',
    'classes_topnav_container' => 'container',

    /*
    |--------------------------------------------------------------------------
    | Sidebar
    |--------------------------------------------------------------------------
    |
    | Here we can modify the sidebar of the admin panel.
    |
    | For detailed instructions you can look the sidebar section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    'sidebar_mini' => 'lg',
    'sidebar_collapse' => false,
    'sidebar_collapse_auto_size' => false,
    'sidebar_collapse_remember' => false,
    'sidebar_collapse_remember_no_transition' => true,
    'sidebar_scrollbar_theme' => 'os-theme-light',
    'sidebar_scrollbar_auto_hide' => 'l',
    'sidebar_nav_accordion' => true,
    'sidebar_nav_animation_speed' => 300,

    /*
    |--------------------------------------------------------------------------
    | Control Sidebar (Right Sidebar)
    |--------------------------------------------------------------------------
    |
    | Here we can modify the right sidebar aka control sidebar of the admin panel.
    |
    | For detailed instructions you can look the right sidebar section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    'right_sidebar' => false,
    'right_sidebar_icon' => 'fas fa-cogs',
    'right_sidebar_theme' => 'dark',
    'right_sidebar_slide' => true,
    'right_sidebar_push' => true,
    'right_sidebar_scrollbar_theme' => 'os-theme-light',
    'right_sidebar_scrollbar_auto_hide' => 'l',

    /*
    |--------------------------------------------------------------------------
    | URLs
    |--------------------------------------------------------------------------
    |
    | Here we can modify the url settings of the admin panel.
    |
    | For detailed instructions you can look the urls section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'use_route_url' => false,
    'dashboard_url' => 'home',
    'logout_url' => 'logout',
    'login_url' => 'login',
    'register_url' => false,
    'password_reset_url' => false,
    'password_email_url' => false,
    'profile_url' => false,

    /*
    |--------------------------------------------------------------------------
    | Laravel Mix
    |--------------------------------------------------------------------------
    |
    | Here we can enable the Laravel Mix option for the admin panel.
    |
    | For detailed instructions you can look the laravel mix section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Other-Configuration
    |
    */

    'enabled_laravel_mix' => false,
    'laravel_mix_css_path' => 'css/app.css',
    'laravel_mix_js_path' => 'js/app.js',

    /*
    |--------------------------------------------------------------------------
    | Menu Items
    |--------------------------------------------------------------------------
    |
    | Here we can modify the sidebar/top navigation of the admin panel.
    |
    | For detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Menu-Configuration
    |
    */


    'menu' => [
    // ============================================
    // DASHBOARD PRINCIPAL
    // ============================================
    [
        'text' => 'DASHBOARD',
        'url'  => 'home',
        'icon' => 'fas fa-fw fa-chart-pie',
        'can'  => 'is_user',
    ],

    // ============================================
    // CADASTROS BÁSICOS
    // ============================================
    [
        'text' => 'CADASTROS',
        'icon' => 'fas fa-fw fa-database',
        'can'  => 'is_user',
        'submenu' => [
            
             [
                'text' => 'Projetos',
                'icon' => 'fas fa-fw fa-building',
                'url'  => 'projetos',
                'can'  => 'is_admin',
            ],
            
            /*[
                'text' => 'Clientes',
                'icon' => 'fas fa-fw fa-user-tie',
                'url'  => 'clientes/list',
                'can'  => 'is_admin',
            ],*/
            
            [
                'text' => 'Fornecedores',
                'icon' => 'fas fa-fw fa-user-secret',
                'url'  => 'fornecedores/list',
                'can'  => 'is_admin',
            ],
            [
                'text' => 'Materiais',
                'icon' => 'fas fa-fw fa-cubes',
                'url'  => 'materiais/list',
                'can'  => 'is_admin',
            ],
            
            /*[
                'text' => 'Participantes',
                'icon' => 'fas fa-fw fa-users-cog',
                'url'  => 'participantes/list',
                'can'  => 'is_user',
            ],
            
            [
                'text' => 'Recepção',
                'icon' => 'fas fa-fw fa-headset',
                'url'  => 'recepcaos/list',
                'can'  => 'is_admin',
            ],
            [
                'text' => 'Gestão',
                'icon' => 'fas fa-fw fa-chart-line',
                'url'  => 'gestaos/list',
                'can'  => 'is_admin',
            ],
            [
                'text' => 'Gerência',
                'icon' => 'fas fa-fw fa-tasks',
                'url'  => 'gerencias/list',
                'can'  => 'is_admin',
            ],
            [
                'text' => 'Fontes',
                'icon' => 'fas fa-fw fa-water',
                'url'  => 'fontes/list',
                'can'  => 'is_admin',
            ],*/
        ],
    ],

    // ============================================
    // MÓDULO DE MEDIÇÃO
    // ============================================
    [
        'text' => 'MEDIÇÃO',
        'icon' => 'fas fa-fw fa-calculator',
        'can'  => 'is_user',
        'submenu' => [
            /*[
                'text' => 'Módulo de Medição',
                'icon' => 'fas fa-fw fa-file-invoice-dollar',
                'url'  => 'itens-orcamento/list',
                'can'  => 'is_admin',
            ],*/
            [
                'text' => 'Modulos',
                'icon' => 'fas fa-fw fa-truck-loading',
                'url'  => 'categorias-obra/list',
                'can'  => 'is_admin',
            ],
            [
                'text' => 'Capitulos',
                'icon' => 'fas fa-fw fa-clipboard-list',
                'url'  => 'atividades/list',
                'can'  => 'is_admin',
            ],
            [
                'text' => 'Actividades',
                'icon' => 'fas fa-fw fa-list-ul',
                'url'  => 'subatividades/list',
                'can'  => 'is_user',
            ],
            
        ],
    ],
    // ============================================
    // ORÇAMENTOS
    // ============================================
    [
        'text' => 'ORÇAMENTOS',
        'icon' => 'fas fa-fw fa-calculator',
        'can'  => 'is_user',
        'submenu' => [
            [
                'text' => 'Composição de Custos',
                'icon' => 'fas fa-fw fa-cogs',
                'url'  => 'composicoes/list',
                'can'  => 'is_admin',
            ],
            [
                'text' => 'Orçamentos',
                'icon' => 'fas fa-fw fa-file-invoice-dollar',
                'url'  => 'orcamentos',
                'can'  => 'is_admin',
            ],
            
        ],
    ],

    // ============================================
    // RELATÓRIOS E ANÁLISES
    // ============================================
    [
        'text' => 'RELATÓRIOS',
        'icon' => 'fas fa-fw fa-chart-bar',
        'can'  => 'is_admin',
        'submenu' => [
            [
                'text' => 'Relatório Geral',
                'icon' => 'fas fa-fw fa-chart-pie',
                'url'  => 'summary',
                'can'  => 'is_admin',
            ],
            /*[
                'text' => 'Relatórios DAF',
                'icon' => 'fas fa-fw fa-file-invoice',
                'submenu' => [
                    [
                        'text' => 'Por Projeto',
                        'url'  => 'relatorios/fontedaf/ano',
                        'icon' => 'fas fa-fw fa-calendar-alt',
                    ],
                    [
                        'text' => 'Por Local',
                        'url'  => 'relatorios/fontedaf/anos',
                        'icon' => 'fas fa-fw fa-map-marker-alt',
                    ],
                ],
            ],
            [
                'text' => 'Relatórios Secretaria',
                'icon' => 'fas fa-fw fa-user-tie',
                'submenu' => [
                    [
                        'text' => 'Por Projeto',
                        'url'  => 'relatorios/administracao/ano',
                        'icon' => 'fas fa-fw fa-calendar-alt',
                    ],
                    [
                        'text' => 'Todos Projetos',
                        'url'  => 'relatorios/administracao/anos',
                        'icon' => 'fas fa-fw fa-folder-open',
                    ],
                ],
            ],
            [
                'text' => 'Relatórios Recepção',
                'icon' => 'fas fa-fw fa-concierge-bell',
                'submenu' => [
                    [
                        'text' => 'Por Projeto',
                        'url'  => 'relatorios/recepcao/anos',
                        'icon' => 'fas fa-fw fa-calendar-alt',
                    ],
                    [
                        'text' => 'Por Local',
                        'url'  => 'relatorios/recepcao/ano',
                        'icon' => 'fas fa-fw fa-map-marker-alt',
                    ],
                ],
            ],
            [
                'text' => 'Relatórios Participantes',
                'icon' => 'fas fa-fw fa-users',
                'submenu' => [
                    [
                        'text' => 'Por Projeto',
                        'url'  => 'relatorios/participanteDN/anoN',
                        'icon' => 'fas fa-fw fa-calendar-alt',
                    ],
                ],
            ],*/
        ],
    ],

    // ============================================
    // CONFIGURAÇÕES
    // ============================================
    [
        'text' => 'CONFIGURAÇÕES',
        'icon' => 'fas fa-fw fa-cog',
        'can'  => 'is_admin',
        'submenu' => [
            [
                'text' => 'Configurações',
                'icon' => 'fas fa-fw fa-sliders-h',
                'url'  => 'configuracoes/index',
                'can'  => 'is_admin',
            ],
            [
                'text' => 'Dashboard Preços',
                'icon' => 'fas fa-fw fa-chart-line',
                'url'  => 'precos/dashboard',
                'can'  => 'is_admin',
            ],
            [
                'text' => 'Preços',
                'icon' => 'fas fa-fw fa-tags',
                'url'  => 'precos/list',
                'can'  => 'is_admin',
            ],
        ],
    ],

    // ============================================
    // ADMINISTRAÇÃO (Usuários)
    // ============================================
    [
        'text' => 'ADMINISTRAÇÃO',
        'icon' => 'fas fa-fw fa-user-shield',
        'can'  => 'is_super',
        'submenu' => [
            [
                'text' => 'Usuários',
                'icon' => 'fas fa-fw fa-users-cog',
                'url'  => 'users/list',
                'can'  => 'is_super',
            ],
        ],
    ],
],

    /*
    |--------------------------------------------------------------------------
    | Menu Filters
    |--------------------------------------------------------------------------
    |
    | Here we can modify the menu filters of the admin panel.
    |
    | For detailed instructions you can look the menu filters section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Menu-Configuration
    |
    */

    'filters' => [
        JeroenNoten\LaravelAdminLte\Menu\Filters\GateFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\HrefFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\SearchFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\ActiveFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\ClassesFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\LangFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\DataFilter::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Plugins Initialization
    |--------------------------------------------------------------------------
    |
    | Here we can modify the plugins used inside the admin panel.
    |
    | For detailed instructions you can look the plugins section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Plugins-Configuration
    |
    */

    'plugins' => [
        'Datatables' => [
            'active' => true,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js',
                ],
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js',
                ],
                [
                    'type' => 'css',
                    'asset' => false,
                    'location' => '//cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css',
                ],
            ],
        ],
        'Select2' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js',
                ],
                [
                    'type' => 'css',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.css',
                ],
            ],
        ],
        'Chartjs' => [
            'active' => true,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.0/Chart.bundle.min.js',
                ],
            ],
        ],
        'Sweetalert2' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdn.jsdelivr.net/npm/sweetalert2@8',
                ],
            ],
        ],
        'Pace' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'css',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/pace/1.0.2/themes/blue/pace-theme-center-radar.min.css',
                ],
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/pace/1.0.2/pace.min.js',
                ],
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | IFrame
    |--------------------------------------------------------------------------
    |
    | Here we change the IFrame mode configuration. Note these changes will
    | only apply to the view that extends and enable the IFrame mode.
    |
    | For detailed instructions you can look the iframe mode section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/IFrame-Mode-Configuration
    |
    */

    'iframe' => [
        'default_tab' => [
            'url' => null,
            'title' => null,
        ],
        'buttons' => [
            'close' => true,
            'close_all' => true,
            'close_all_other' => true,
            'scroll_left' => true,
            'scroll_right' => true,
            'fullscreen' => true,
        ],
        'options' => [
            'loading_screen' => 1000,
            'auto_show_new_tab' => true,
            'use_navbar_items' => true,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Livewire
    |--------------------------------------------------------------------------
    |
    | Here we can enable the Livewire support.
    |
    | For detailed instructions you can look the livewire here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Other-Configuration
    |
    */

    'livewire' => false,
];
