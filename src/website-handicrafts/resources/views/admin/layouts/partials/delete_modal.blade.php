<div class="modal fade" id="deleteConfirmationModal" tabindex="-1" aria-hidden="true"
    data-body-default="{{ __('admin/messages.confirm_delete_content') }}"
    data-error-bad-url="{{ __('admin/messages.error_bad_url') }}" data-deleting-text="{{ __('admin/messages.deleting') }}"
    data-delete-text="{{ __('admin/messages.modal_button_delete') }}"
    data-failed-text="{{ __('admin/messages.delete_failed') }}">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ __('admin/messages.confirm_delete_title') ?? 'Potwierdź usunięcie' }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Zamknij"></button>
            </div>
            <div class="modal-body">
                <p id="delete-body-text">
                    {{ __('admin/messages.confirm_delete_content') ?? 'Czy na pewno chcesz usunąć?' }}</p>
                <div id="delete-error" class="alert alert-danger d-none"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary"
                    data-bs-dismiss="modal">{{ __('admin/messages.modal_button_cancel') ?? 'Anuluj' }}</button>
                <button type="button" id="delete-confirm"
                    class="btn btn-danger">{{ __('admin/messages.modal_button_delete') ?? 'Usuń' }}</button>
            </div>
        </div>
    </div>
</div>
