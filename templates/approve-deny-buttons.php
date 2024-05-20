<?php
if (!defined('ABSPATH')) {
    exit;
}

$approve_url = admin_url('admin.php?page=gf_entries&view=entry&id=' . $form_id . '&lid=' . $entry_id . '&action=approve');
$deny_url = admin_url('admin.php?page=gf_entries&view=entry&id=' . $form_id . '&lid=' . $entry_id . '&action=deny');
?>

<div>
    <a href="<?= esc_url($approve_url); ?>" class="btn btn-success text-white">
        Approve Application
    </a>
    <a href="<?= esc_url($deny_url); ?>" class="btn btn-danger text-white" style="margin-left: 10px;">
        Deny Application
    </a>
</div>