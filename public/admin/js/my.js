

function unChecked_inputes() {
    $('input[type="checkbox"]').prop('checked', false);
}

function beforeSendProgressBar() {
    $('#remove_buttons').hide();
    $('#remove_text').hide();
    $('#remove_progress_bar').show();
}

function ajaxSuccess(msg) {
    $('#remove_progress_bar').hide();
    $('#remove_success_text').text(msg[1]);
    $('#remove_success').show();
    setInterval(function () {
        window.location.reload();
    }, 2000);
}

function ajaxError(msg) {
    $('#remove_progress_bar').hide();
    $('#remove_failed_text').text(msg[1]);
    $('#remove_failed').show();
}

$('.check_box_all_items').click(function () {
    let is_checked = $(this).is(':checked');
    $('.check_box_items').prop('checked', is_checked);
})

$('.check_box_items').click(function () {
    let is_checked = $(this).is(':checked');
    if (!is_checked) {
        $('.check_box_all_items').prop('checked', is_checked);
    }
    if (is_checked) {
        let ids = [];
        $('.check_box_items:checked').each(function () {
            ids.push($(this).val());
        })
        if (ids.length == $('.check_box_items').length) {
            $('.check_box_all_items').prop('checked', is_checked);
        }
    }
})
// Show File Name
$('#image').change(function () {
    //get the file name
    var fileName = $(this).val();
    //replace the "Choose a file" label
    $(this).next('.custom-file-label').html(fileName);
});
// Show File Name
$('#file').change(function () {
    //get the file name
    var fileName = $(this).val();
    //replace the "Choose a file" label
    $(this).next('.custom-file-label').html(fileName);
});
// Show File Name
$('#images').change(function () {
    //get the file name
    var fileName = $(this).val();
    //replace the "Choose a file" label
    $(this).next('.custom-file-label').html(fileName);
});

function show_per_page(tag, url) {
    let per_page = $(tag).val();
    url = url + '/' + per_page;
    window.location.href = url;
}

function RemoveModal(id) {
    let modal = $('#remove_modal');
    $('#remove_failed').hide();
    $('#remove_success').hide();
    if (id == null) {
        let ids = [];
        $('.check_box_items:checked').each(function () {
            ids.push($(this).val());
        })
        if (ids.length == 0) {
            $('#remove_text').hide();
            $('#remove_buttons').hide();
            $('#group_remove_alert').show();
        } else {
            $('#remove_buttons').show();
            $('#group_remove').show();
            $('#single_remove').hide();
            $('#group_remove_alert').hide();
            $('#remove_text').text('آیا از حذف گروهی موارد انتخاب شده اطمینان دارید؟');
            $('#remove_text').show();
            $('#id').val(ids);
        }
    } else {
        $('#remove_text').text('آیا از حذف این مورد اطمینان دارید؟');
        $('#remove_text').show();
        $('#remove_buttons').show();
        $('#group_remove_alert').hide();
        $('#group_remove').hide();
        $('#single_remove').show();
        $('#id').val(id);
    }
    modal.modal('show');
}

function SaveForm(type, formId) {
    $('#closeType').val(type);
    $('#' + formId).submit();
}
//CKEDITOR
if ($('#short_description').length > 0){
    CKEDITOR.replace('short_description', {
        language: 'fa',
        filebrowserUploadUrl: "/ckeditor/image_upload",
        filebrowserUploadMethod: 'form'
    });
}if ($('#short_description_fa').length > 0){
    CKEDITOR.replace('short_description_fa', {
        language: 'fa',
        filebrowserUploadUrl: "/ckeditor/image_upload",
        filebrowserUploadMethod: 'form'
    });
}if ($('#short_description_en').length > 0){
    CKEDITOR.replace('short_description_en', {
        language: 'en',
        filebrowserUploadUrl: "/ckeditor/image_upload",
        filebrowserUploadMethod: 'form'
    });
}
//CKEDITOR
if ($('#description_fa').length>0) {
    CKEDITOR.replace('description_fa', {
        language: 'fa',
        filebrowserUploadUrl: "/ckeditor/image_upload",
        filebrowserUploadMethod: 'form'
    });
}
//CKEDITOR
if ($('#description_en').length>0) {
    CKEDITOR.replace('description_en', {
        language: 'fa',
        filebrowserUploadUrl: "/ckeditor/image_upload",
        filebrowserUploadMethod: 'form'
    });
}
//remove style
CKEDITOR.on('instanceReady', function (ev) {
    ev.editor.on('paste', function (evt) {
        if (evt.data.type == 'html') {
            evt.data.dataValue = evt.data.dataValue.replace(/ style=".*?"/g, '');
        }
    }, null, null, 9);
});
