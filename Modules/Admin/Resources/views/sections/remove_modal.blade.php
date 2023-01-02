<div class="modal fade" id="remove_modal" tabindex="-1" style="display: none;" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="بستن"></button>
            </div>
            <div class="modal-body">
                <div id="group_remove_alert" style="display: none">
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        هیچ موردی را برای حذف گروهی انتخاب نکرده اید!
                    </div>
                </div>
                <p id="remove_text">
                    آیا از حذف این مورد اطمینان دارید؟
                </p>
                <div id="remove_progress_bar" style="display: none">
                    <p>لطفا کمی صبر کنید...</p>
                    <div class="progress mt-3 mb-3">
                        <div class="progress-bar progress-bar-striped bg-danger progress-bar-animated" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>
                <div id="remove_success" style="display: none">
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="bi bi-check-circle"></i>
                        <span id="remove_success_text"></span>
                    </div>
                </div>
                <div id="remove_failed" style="display: none">
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="bi bi-x-circle"></i>
                        <span id="remove_failed_text"></span>
                    </div>
                </div>
            </div>
            <div class="modal-footer" id="remove_buttons">
                <button id="single_remove" type="button" class="btn btn-primary" onclick="Remove()">حذف کن</button>
                <button id="group_remove" type="button" class="btn btn-primary" onclick="GroupRemove()">حذف کن</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">بستن</button>
                <input id="id" type="hidden" value="">
            </div>
        </div>
    </div>
</div>
