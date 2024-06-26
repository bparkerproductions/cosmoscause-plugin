<?php

/**
 * Register a hidden CPT for Pet Application database entries
 */
function cosmoscause_register_pet_application_database_entry_cpt()
{
    $args = array(
        'label'                 => __('Pet Application Entry', 'text_domain'),
        'description'           => __('Database items for the pet application entries', 'text_domain'),
        'supports'              => array('custom-fields'),
        'hierarchical'          => false,
        'public'                => true,
        'show_ui'               => false,
        'show_in_admin_bar'     => false,
        'show_in_nav_menus'     => false,
        'can_export'            => true,
        'has_archive'           => false,
        'exclude_from_search'   => true,
        'publicly_queryable'    => false,
        'capability_type'       => 'post',
    );
    register_post_type('application_entry', $args);
}

/**
 * Register a hidden CPT for Surrender database entries
 */
function cosmoscause_register_surrender_database_entry_cpt()
{
    $args = array(
        'label'                 => __('Surrender Application Entry', 'text_domain'),
        'description'           => __('Database items for the surrender application entries', 'text_domain'),
        'supports'              => array('custom-fields'),
        'hierarchical'          => false,
        'public'                => true,
        'show_ui'               => true,
        'show_in_admin_bar'     => false,
        'show_in_nav_menus'     => false,
        'can_export'            => true,
        'has_archive'           => false,
        'exclude_from_search'   => true,
        'publicly_queryable'    => false,
        'capability_type'       => 'post',
    );
    register_post_type('surrender_entry', $args);
}

/**
 * Register a hidden CPT for Foster Application database entries
 */
function cosmoscause_register_foster_application_database_entry_cpt()
{
    $args = array(
        'label'                 => __('Foster Application Entry', 'text_domain'),
        'description'           => __('Database items for the foster application entries', 'text_domain'),
        'supports'              => array('custom-fields'),
        'hierarchical'          => false,
        'public'                => true,
        'show_ui'               => false,
        'show_in_admin_bar'     => false,
        'show_in_nav_menus'     => false,
        'can_export'            => true,
        'has_archive'           => false,
        'exclude_from_search'   => true,
        'publicly_queryable'    => false,
        'capability_type'       => 'post',
    );
    register_post_type('foster_entry', $args);
}

function cosmoscause_register_cpts()
{
    // Pet application entries
    if (!post_type_exists('application_entry')) {
        cosmoscause_register_pet_application_database_entry_cpt();
    }

    if (!post_type_exists('foster_entry')) {
        cosmoscause_register_foster_application_database_entry_cpt();
    }

    if (!post_type_exists('surrender_entry')) {
        cosmoscause_register_surrender_database_entry_cpt();
    }
}

add_action('init', 'cosmoscause_register_cpts');
