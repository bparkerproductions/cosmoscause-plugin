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
                <img id="site-logo" class="w-100" style="max-width: 200px;" src="<?= get_field('site_main_logo', 'option')['url'] ?>" />
            </div>
            <div class="col d-flex flex-column align-items-start justify-content-center">
                <h1 class="text-white"><?php esc_html_e('Cosmos Cause Database', 'cosmoscause'); ?></h1>
                <p><?php esc_html_e('Manage form submissions, applicants, and more.'); ?></p>
            </div>
        </div>
    </div>

    <section>

        <!-- Tabs for Pet Application and Foster Application -->
        <ul class="nav nav-tabs my-3" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="pet-application-tab" data-bs-toggle="tab" data-bs-target="#pet-application" type="button" role="tab" aria-controls="pet-application" aria-selected="true">Pet Applications</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="foster-application-tab" data-bs-toggle="tab" data-bs-target="#foster-application" type="button" role="tab" aria-controls="foster-application" aria-selected="false">Foster Applications</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="surrender-application-tab" data-bs-toggle="tab" data-bs-target="#surrender-application" type="button" role="tab" aria-controls="surrender-application" aria-selected="false">Surrender Applications</button>
            </li>
        </ul>
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="pet-application" role="tabpanel" aria-labelledby="pet-application-tab">
                <?php if (class_exists('GFAPI')) :
                    include_once plugin_dir_path(__FILE__) . 'tables/pet-application-table.php';
                    Cosmoscause\PetApplication\display_entries();
                endif; ?>
            </div>
            <div class="tab-pane fade" id="foster-application" role="tabpanel" aria-labelledby="foster-application-tab">
                <?php if (class_exists('GFAPI')) :
                    include_once plugin_dir_path(__FILE__) . 'tables/foster-application-table.php';
                    Cosmoscause\FosterApplication\display_entries();
                endif; ?>
            </div>
            <div class="tab-pane fade" id="surrender-application" role="tabpanel" aria-labelledby="surrender-application-tab">
                <?php if (class_exists('GFAPI')) :
                    include_once plugin_dir_path(__FILE__) . 'tables/surrender-application-table.php';
                    Cosmoscause\SurrenderApplication\display_entries();
                endif; ?>
            </div>
        </div>
    </section>
</div>