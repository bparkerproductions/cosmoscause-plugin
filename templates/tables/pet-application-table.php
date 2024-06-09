<?php

namespace Cosmoscause\PetApplication;

function display_entries()
{ ?>
    <table id="pet-application-table" class="table table-striped table-bordered">
        <thead>
            <tr>
                <th><?php esc_html_e('Entry', 'cosmoscause-plugin'); ?></th>
                <th><?php esc_html_e('Applied for', 'cosmoscause-plugin'); ?></th>
                <th><?php esc_html_e('Applicant(s)', 'cosmoscause-plugin'); ?></th>
                <th><?php esc_html_e('Contact', 'cosmoscause-plugin'); ?></th>
                <th><?php esc_html_e('Date', 'cosmoscause-plugin'); ?></th>

                <!-- Approved status -->
                <th><?php esc_html_e('Status', 'cosmoscause-plugin'); ?></th>
            </tr>
        </thead>
        <tbody>
            <?php generate_table_rows(); ?>
        </tbody>
    </table>
    <?php }

function generate_table_rows()
{
    $database_entries = get_posts(array(
        'post_type' => 'application_entry',
        'posts_per_page' => -1
    ));
    foreach ($database_entries as $entry) :

        $entry_id = get_post_meta($entry->ID, '_gf_entry_id', true);
        $applicant_approval_status = get_post_meta($entry->ID, '_applicant_approval_status', true);
        $pet_name = get_post_meta($entry->ID, '_pet_name', true);
        $applicant_names = get_post_meta($entry->ID, '_applicant_names', true);
        $applicant_address = get_post_meta($entry->ID, '_applicant_address', true);
        $phone_number = get_post_meta($entry->ID, '_applicant_phone_number', true);
        $email = get_post_meta($entry->ID, '_applicant_email', true);
        $application_date = get_post_meta($entry->ID, '_gf_entry_date', true);
        $reference_name = get_post_meta($entry->ID, '_reference_name', true);
        $reference_phone = get_post_meta($entry->ID, '_reference_phone', true);
        $veterinatian_list = unserialize(get_post_meta($entry->ID, '_veterinarian_list', true));
        $application_url = get_post_meta($entry->ID, '_application_url', true);
    ?>
        <tr class="position-relative">
            <td>
                <?php include plugin_dir_path(__FILE__) . 'parts/entry-ui-buttons.php'; ?>
                <div class="table__component-container">
                    <?php include plugin_dir_path(__FILE__) . 'components/notes-section.php'; ?>
                </div>
            </td>
            <td><?= esc_html($pet_name) ?></td>
            <td><?= esc_html($applicant_names); ?></td>
            <td>
                <?php include plugin_dir_path(__FILE__) . 'parts/contact-info.php'; ?>

                <div class=" my-1">
                    <?php if ($veterinatian_list !== false) :
                        foreach ($veterinatian_list as $vet) :
                            $vet_name = $vet['Name'];
                            $vet_phone = $vet['Phone Number']; ?>
                            <a class="me-2 text-decoration-none" href="tel:<?= esc_html($vet_phone) ?>" title="Veterinarian Phone Number">
                                <span class="me-2"><i class="fa-duotone fa-phone"></i></span><?= $vet_name ?> <span class="fst-italic fs-sm">(Veterinarian)</span>
                            </a>
                        <?php endforeach;
                    else : ?>
                        <p class="text-black-50 fst-italic">No veterinarian provided</p>
                    <?php endif; ?>
                </div>
            </td>
            <td>
                <span class="fst-italic fs-sm"><?= esc_html($application_date); ?></span>
            </td>
            <td>
                <div class="actions-container">
                    <?php include plugin_dir_path(__FILE__) . 'parts/approve-deny-buttons.php'; ?>

                    <div class="contract-generation <?= $applicant_approval_status !== 'Approved' ? 'd-none' : ''; ?>">
                        <hr>
                        <div class="mt-2">
                            <button role="button" class="btn btn-sm btn-info text-white contract-generation__button">Get Contract Link</button>

                            <div class="d-none contract-generation__link-container mt-2">
                                <div class="d-flex align-items-center">
                                    <i class="fa-regular fa-arrow-up-right-from-square me-2 fa-sm text-dark"></i>
                                    <a data-address="<?= $applicant_address; ?>" data-phone-number="<?= $phone_number; ?>" data-email="<?= $email; ?>" data-applicant-name="<?= $applicant_names; ?>" data-pet-name="<?= $pet_name ?>" target="_blank" class="contract-generation__link" href="#" title="Open Contract Link"> Contract Link</a>

                                    <span class="contract-generation__email ms-2 cursor-pointer" data-recipient-email="<?= $email; ?>" title="Send contract link to <?= $email; ?>"><i class="fa-solid fa-envelope fa-2x text-info"></i></span>
                                </div>
                                <p class="fs-sm contract-generation__message d-none mt-2"></p>
                            </div>
                        </div>
                    </div>
                </div>
            </td>
        </tr>

<?php endforeach;
}
