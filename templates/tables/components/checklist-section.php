<div id="checklist-container<?= $entry->ID ?>" class="my-2 collapse">
    <div class="bg-info rounded p-3">
        <div class="d-flex justify-content-between pb-2 mb-3 border-bottom">
            <h5 class="text-light">
                <i class="fa-regular fa-list-check me-2"></i>Checklist
            </h5>
            <i class="fa-regular fa-xmark fa-lg text-light cursor-pointer" data-bs-toggle="collapse" href="#note-container<?= $entry->ID; ?>" role="button"></i>
        </div>


        <button class="btn btn-sm btn-light" data-bs-toggle="collapse" href="#checklist-container<?= $entry->ID; ?>" role="button">Close</button>
    </div>
</div>