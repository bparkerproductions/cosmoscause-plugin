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
        $phone_number = get_post_meta($entry->ID, '_applicant_phone_number', true);
        $email = get_post_meta($entry->ID, '_applicant_email', true);
        $application_date = get_post_meta($entry->ID, '_application_date', true);
        $reference_name = get_post_meta($entry->ID, '_reference_name', true);
        $reference_phone = get_post_meta($entry->ID, '_reference_phone', true);
        $veterinatian_list = unserialize(get_post_meta($entry->ID, '_veterinarian_list', true));
        $application_url = get_post_meta($entry->ID, '_application_url', true); ?>
        <tr>
            <td>
                <a class="text-decoration-none" href="<?= esc_url($application_url) ?>" target="_blank">
                    <i class="fa-regular fa-arrow-up-right-from-square"></i> <?= $entry_id ?>
                </a>
            </td>
            <td><?= esc_html($pet_name) ?></td>
            <td><?= esc_html($applicant_names); ?></td>
            <td>
                <div>
                    <a class="me-2 text-decoration-none" href="mailto:<?= esc_html($email) ?>" title="Applicant Email">
                        <span class="me-2"><i class="fa-sharp fa-light fa-envelope"></i></span>Email
                    </a>
                    <a class="text-decoration-none" href="tel:<?= esc_html($phone_number) ?>" title="Applicant Phone Number">
                        <span class="me-2"><i class="fa-duotone fa-phone"></i></span>Phone
                    </a>
                </div>
                <div class="my-1">
                    <?php if ($reference_name) : ?>
                        <a class="me-2 text-decoration-none" href="tel:<?= esc_html($reference_phone) ?>" title="Reference Phone Number>
                            <span class=" me-2"><i class="fa-duotone fa-phone"></i></span><?= $reference_name ?>(Reference)
                        </a>
                    <?php else : ?>
                        <p class="text-black-50 fst-italic">No reference provided</p>
                    <?php endif; ?>
                </div>
                <div class="my-1">
                    <?php if ($veterinatian_list !== false) :
                        foreach ($veterinatian_list as $vet) :
                            $vet_name = $vet['Name'];
                            $vet_phone = $vet['Phone Number']; ?>
                            <a class="me-2 text-decoration-none" href="tel:<?= esc_html($vet_phone) ?>" title="Veterinarian Phone Number">
                                <span class="me-2"><i class="fa-duotone fa-phone"></i></span><?= $vet_name ?>(Veterinarian)
                            </a>
                        <?php endforeach;
                    else : ?>
                        <p class="text-black-50 fst-italic">No veterinarian provided</p>
                    <?php endif; ?>
                </div>
            </td>
            <td><?= esc_html($application_date); ?></td>
            <td>
                <?php include plugin_dir_path(__FILE__) . 'approve-deny-buttons.php'; ?>
            </td>
        </tr>
<?php endforeach;
}
