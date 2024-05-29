<?php
// Ensure this file is included in WordPress
if (!defined('ABSPATH')) {
    exit;
}

// Check for user capabilities
if (!current_user_can('manage_options')) {
    return;
}

?>
<div class="wrap">
    <div class="alert bg-info text-white mb-2">
        <div class="row">
            <div class="col-lg-1">
                <img id="site-logo" class="w-100" src="<?= get_field('site_main_logo', 'option')['url'] ?>" />
            </div>
            <div class="col d-flex flex-column align-items-start justify-content-center">
                <h1 class="text-white"><?php esc_html_e('Cosmos Cause Database', 'cosmoscause'); ?></h1>
                <p><?php esc_html_e('Manage form submissions, applicants, and more.'); ?></p>
            </div>
        </div>
    </div>

    <section>
        <?php if (class_exists('GFAPI')) :
            include_once plugin_dir_path(__FILE__) . 'pet-application-table.php';
            display_pet_application_entries();
        endif; ?>
    </section>
</div>