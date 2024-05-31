<div id="note-container<?= $entry->ID ?>" class="p-3 collapse">
    <div class="bg-info rounded p-3">
        <h5 class="pb-2 border-bottom text-light">
            <i class="fa-light fa-notes me-2 fa-2x"></i>Notes
        </h5>

        <div class="my-2">
            <?php
            $content = '';
            $editor_id = 'custom_editor' . $entry->ID;
            $settings = array(
                'textarea_name' => 'custom_editor' . $entry->ID,
                'media_buttons' => false,
                'teeny'         => true,
                'textarea_rows' => 25,
                'tinymce'       => array(
                    'toolbar1' => 'bold italic underline strikethrough | formatselect | bullist numlist | undo redo',
                ),
                'quicktags'     => false,
            );

            wp_editor($content, $editor_id, $settings); ?>
        </div>

        <button class="btn btn-sm btn-light" data-bs-toggle="collapse" href="#note-container<?= $entry->ID; ?>" role="button">Close</button>
    </div>
</div>