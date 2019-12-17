$(document).ready(function () {
    $("#center").change(function () {
        if ($('#center').val() != 0) {
            get_teacher_by_center_id();
        } else {
            get_teacher_free();
        }
    });

    $("#categoryDoc").change(function () {
        if ($('#categoryDoc').val() != 0) {
            get_document_by_category_id();
        }
    });

    $("#categoryTest").change(function () {
        if ($('#categoryTest').val() != 0) {
            get_test_by_category_id();
        }
    });

    $("#categoryNews").change(function () {
        if ($('#categoryNews').val() != 0) {
            get_news_by_category_id();
        }
    });

    $("#comments_doc").change(function () {
        get_comments_by_doc_id();
    });

    $("#comments_test").change(function () {
        get_comments_by_test_id();
    });

    $("#comments_news").change(function () {
        get_comments_by_news_id();
    });

    $("#city_id").change(function () {
        if ($('#city_id').val() != 0) {
            getDistrictByCodeCity();
        }
        if ($('#city_id').val() == 0) {
            $("#district_id").html($('<option>', {
                value: 0,
                text: "-- Chọn quận/huyện --",
            }));
        }
    });
    $("#grade_ids").select2();
    $("#subject_ids").select2();

    doc_meta();
    // cập nhật trạng thái duyệt từng tutorial
    toggleActiveTutotirial();
    // cập nhật tất cả trạng thái duyệt tutorials
    toggleActiveAllTutotirial();
    // cập nhật trạng thái nhận tutorial
    toggleConfirmTutotirial();
    // cập nhật tất cả trạng thái đã nhận tutorials
    toggleConfirmAllTutotirial();

    // định dạng tiền
    format_number();

    autoComment();

    replyComment();

    comment();

    deleteComment();

    editComment();

    loadMoreComment();

    // turn off autocomplete for all input
    $('input').attr('autocomplete', 'off');

    // so sánh giá trị 2 datetime picker,
    // compareDates();

    // thêm toottip cho button show, edit, delete
    addTooltipButton();

    addMoneyAjax();
    autoMoney();
    formatMoneyCoefficient();
});

function doc_meta() {
    var category_doc_meta_id = $("#category_doc_meta_id").val();
    var document_metas_html = $("#document_metas").html();

    $("#category_doc_meta_id").change(function () {
        if ($(this).val() == category_doc_meta_id) {
            $('#document_metas').html(document_metas_html);
        } else {
            get_document_metas_by_category_doc_meta_id($('#category_doc_meta_id').val());
        }
    });

    if ($('#document_metas').children().length == 0) {
        get_document_metas_by_category_doc_meta_id($('#category_doc_meta_id').val());
    }
}

// get all teacher of center
function get_teacher_by_center_id() {
    var id = $('#center').val();
    var teachers = [];
    $.ajax({
        url: '/api/admin/centers/' + id + '/teachers',
        type: 'get',
        success: success,
        error: error,
    });
    function success(data, status) {
        $("#teacher").html("");
        var defaultTeacher = {
            "id": 0,
            "name": "-- Chọn gia sư --",
            "description": "",
            "address": "",
            "phone": "",
            "email": "",
            "slug": "",
            "image": "",
            "user_id": 1,
            "center_id": 0,
            "created_at": "2017-06-08 15:44:45",
            "updated_at": "2017-06-14 10:24:53",
            "deleted_at": null
        };
        var teachers = [];
        teachers[0] = defaultTeacher;
        for (var i = 0; i < data.data.length; i++) {
            teachers.push(data.data[i]);
        }
        teachers.forEach(appendOption)
    }

    function appendOption(item, index, arr) {
        $("#teacher").append($('<option>', {
            value: item.id,
            text: item.name,
        }));
    }

    function error() {
    }
}

//get all document of category

function get_document_by_category_id() {
    var id = $('#categoryDoc').val();
    var documents = [];
    $.ajax({
        url: '/api/admin/documents/' + id + '/documents',
        type: 'get',
        success: success,
        error: error,
    });
    function success(data, status) {
        $("#document").html("");
        var defaultDocument = {
            "id": 0,
            "name": "-- Chọn tài liệu --"
        };
        var documents = [];
        documents[0] = defaultDocument;
        for (var i = 0; i < data.data.length; i++) {

            documents.push(data.data[i]);
        }

        documents.forEach(appendOption)
    }

    function appendOption(item, index, arr) {
        $("#document").append($('<option>', {
            value: item.id,
            text: item.name,
        }));
    }

    function error() {
    }
}

//get all test of category
function get_test_by_category_id() {
    var id = $('#categoryTest').val();
    var tests = [];
    $.ajax({
        url: '/api/admin/tests/' + id + '/tests',
        type: 'get',
        success: success,
        error: error,
    });
    function success(data, status) {
        $("#test").html("");
        var defaultTest = {
            "id": 0,
            "name": "-- Chọn đề thi --"
        };
        var tests = [];
        tests[0] = defaultTest;
        for (var i = 0; i < data.data.length; i++) {

            tests.push(data.data[i]);
        }

        tests.forEach(appendOption)
    }

    function appendOption(item, index, arr) {
        $("#test").append($('<option>', {
            value: item.id,
            text: item.name,
        }));
    }

    function error() {
    }
}

//get all news of category
function get_news_by_category_id() {
    var id = $('#categoryNews').val();
    var tests = [];
    $.ajax({
        url: '/api/admin/news/' + id + '/news',
        type: 'get',
        success: success,
        error: error,
    });
    function success(data, status) {
        $("#news").html("");
        var defaultNews = {
            "id": 0,
            "name": "-- Chọn tin tức --"
        };
        var news = [];
        news[0] = defaultNews;
        for (var i = 0; i < data.data.length; i++) {

            news.push(data.data[i]);
        }

        news.forEach(appendOption)
    }

    function appendOption(item, index, arr) {
        $("#news").append($('<option>', {
            value: item.id,
            text: item.name,
        }));
    }

    function error() {
    }
}

// get commemts of docs
function get_comments_by_doc_id() {
    var id = $('#comments_doc').val();
    var comments = [];
    $.ajax({
        url: '/api/admin/documents/' + id + '/comments',
        type: 'get',
        success: success,
        error: error,
    });
    function success(data, status) {
        $("#comments_parent").html("");
        var defaultComment = {
            "id": 0,
            "content": "-- Chọn giá trị --",
            "parent_id": 0,
            "user_id": 0,
            "document_id": 0,
            "created_at": "2017-06-15 17:34:00",
            "updated_at": "2017-06-15 17:34:00",
            "deleted_at": null
        };
        var comments = [];
        comments[0] = defaultComment;
        for (var i = 0; i < data.data.length; i++) {
            comments.push(data.data[i]);
        }
        comments.forEach(appendOption)
    }

    function appendOption(item, index, arr) {
        $("#comments_parent").append($('<option>', {
            value: item.id,
            text: item.content,
        }));
    }

    function error() {
    }
}

// get commemts of test
function get_comments_by_test_id() {
    var id = $('#comments_test').val();
    var comments = [];
    $.ajax({
        url: '/api/admin/tests/' + id + '/comments',
        type: 'get',
        success: success,
        error: error,
    });
    function success(data, status) {
        $("#commentTests_parent").html("");
        var defaultComment = {
            "id": 0,
            "content": "-- Chọn giá trị --",
            "parent_id": 0,
            "user_id": 0,
            "document_id": 0,
            "created_at": "2017-06-15 17:34:00",
            "updated_at": "2017-06-15 17:34:00",
            "deleted_at": null
        };
        var comments = [];
        comments[0] = defaultComment;
        for (var i = 0; i < data.data.length; i++) {
            comments.push(data.data[i]);
        }
        comments.forEach(appendOption)
    }

    function appendOption(item, index, arr) {
        $("#commentTests_parent").append($('<option>', {
            value: item.id,
            text: item.content,
        }));
    }

    function error() {
    }
}

// get comments of news
function get_comments_by_news_id() {
    var id = $('#comments_news').val();
    var comments = [];
    $.ajax({
        url: '/api/admin/news/' + id + '/comments',
        type: 'get',
        success: success,
        error: error,
    });
    function success(data, status) {
        $("#commentNews_parent").html("");
        var defaultComment = {
            "id": 0,
            "content": "-- Chọn giá trị --",
            "parent_id": 0,
            "user_id": 0,
            "news_id": 0,
            "created_at": "2017-06-15 17:34:00",
            "updated_at": "2017-06-15 17:34:00",
            "deleted_at": null
        };
        var comments = [];
        comments[0] = defaultComment;
        for (var i = 0; i < data.data.length; i++) {
            comments.push(data.data[i]);
        }
        comments.forEach(appendOption)
    }

    function appendOption(item, index, arr) {
        $("#commentNews_parent").append($('<option>', {
            value: item.id,
            text: item.content,
        }));
    }

    function error() {
    }
}


function get_teacher_free() {
    var id = $('#center').val();
    var teachers = [];
    $.ajax({
        url: '/api/admin/teachers/free/center',
        type: 'get',
        success: successs,
        error: error,
    });
    function successs(data, status) {
        $("#teacher").html("");
        var defaultTeacher = {
            "id": 0,
            "name": "-- Chọn gia sư --",
            "description": "",
            "address": "",
            "phone": "",
            "email": "",
            "slug": "",
            "image": "",
            "user_id": 1,
            "center_id": 0,
            "created_at": "2017-06-08 15:44:45",
            "updated_at": "2017-06-14 10:24:53",
            "deleted_at": null
        };
        var teachers = [];
        for (var i = 0; i < data.data.data.length; i++) {
            teachers.push(data.data.data[i]);
        }
        teachers.forEach(appendOption)
    }

    function appendOption(item, index, arr) {
        $("#teacher").append($('<option>', {
            value: item.id,
            text: item.name,
        }));
    }

    function error() {
    }
}

function get_document_metas_by_category_doc_meta_id(id) {
    $.ajax({
        url: '/api/admin/document_metas/getByCateId/' + id,
        type: 'GET',
        success: function (data) {
            var content = '';
            $.each(data.data.data, function (k, v) {
                content += "<div class='form-group col-sm-6'><label for='document_meta_" + v.id + "'>" + v.name + "</label>" +
                    "<input class='form-control' name='document_meta[" + v.id + "]' type='text' id='document_meta_" + v.id + "'>"
                    + "</div>";

            });
            $('#document_metas').html(content);
        },
        error: function (xhr, desc, err) {
        }
    });
}

function getDistrictByCodeCity() {
    var code = $('#city_id').val();
    var districts = [];
    $.ajax({
        url: '/api/admin/districts_by_code_city/' + code.toString(),
        type: 'get',
        success: success,
        error: error,
    });
    function success(data, status) {
        $("#district_id").html("");
        var defaultDistrict = {
            "id": 0,
            "name": "-- Chọn quận/huyện --",
        };
        var districts = [];
        districts[0] = defaultDistrict;
        for (var i = 0; i < data.data.length; i++) {
            districts.push(data.data[i]);
        }
        districts.forEach(appendOption)
    }

    function appendOption(item, index, arr) {
        if (item.id == $('#district_id').attr('value')) {
            $("#district_id").append($('<option>', {
                selected: 'selected',
                value: item.id,
                text: item.name,
            }));
        }
        else
            $("#district_id").append($('<option>', {
                value: item.id,
                text: item.name,
            }));
    }

    function error() {
    }
}
function format_number() {
    jQuery("#number-format").priceFormat({
        prefix: '',
        suffix: ' VNĐ',
        thousandsSeparator: '.',
        centsLimit: 0,
        clearOnEmpty: true
    });
}

function autoComment() {
    jQuery(".autocomment").click(function () {
        jQuery("#autoComment").val(jQuery(this).attr("id"));
        jQuery('#content').val('');
    })
}

function compareDates() {
    var start_date = new Date($('#start_date').val());
    var end_date = new Date($('#end_date').val());
    if ($('#end_date').val()) {
        if (end_date.getTime() < start_date.getTime()) {
            alert("Ngày bắt đầu phải nhỏ hơn ngày kết thúc!");
            return false
        }
    }
};
function addTooltipButton() {
    $('.glyphicon.glyphicon-eye-open').tooltip({
        title: "Xem",
        placement: "top"
    })

    $('.glyphicon.glyphicon-edit').tooltip({
        title: "Sửa",
        placement: "top"
    })

    $('.glyphicon.glyphicon-trash').tooltip({
        title: "Xóa",
        placement: "top"
    })

    $('.glyphicon.glyphicon-comment').tooltip({
        title: 'Trả lời',
        placement: "top"
    })

    $('.glyphicon.glyphicon-usd').tooltip({
        title: 'Nạp/Trừ tiền',
        placement: 'top'
    })
}


var handleiCheckAll = function () {
    var checkAll = $('input[type="checkbox"].check-all');
    var checkboxes = $('input[type="checkbox"].check-single');

    checkboxes.on('ifChanged', function (event) {
        if (checkboxes.filter(':checked').length == checkboxes.length) {
            checkAll.prop('checked', true);
        } else {
            checkAll.prop('checked', false);
        }
        checkAll.iCheck('update');
    });
}

// cập nhật trạng thái duyệt từng tutorial
function toggleActiveTutotirial() {
    $(document).on('click', '.activeUpdate', function (event) {
        event.preventDefault(event);
        $(this).tooltip('destroy');
        var inputData = $('#formUpdateActive').serialize();
        var dataId = $(this).attr('data-id');
        $.ajax({
            url: '/api/admin/tutorials/' + dataId + '/updateActive',
            type: 'PATCH',
            data: inputData,
            success: function (response) {
                var tutorial = response.data;

                if (tutorial.active) {
                    $("#items-" + tutorial.id).replaceWith("<button class='btn bg-olive btn-xs activeUpdate' data-id='" + tutorial.id + "' id='items-" + tutorial.id + "' data-toggle='tooltip' title='Bỏ duyệt'><i class='fa  fa-check'></i></button>");
                } else if (tutorial.active == 0 && !response.checkActive) {
                    $("#items-" + tutorial.id).replaceWith("<button class='btn btn-warning btn-xs activeUpdate' data-id='" + tutorial.id + "' id='items-" + tutorial.id + "' data-toggle='tooltip' title='Duyệt'><i class='fa  fa fa-close' ></i></button>");
                    $("#toggle").replaceWith("<a class='btn bg-olive' id='toggle' value='tutorials_activeAll'><i class='fa fa-check'></i> Duyệt tất cả</a>");
                    $("#hiddenActiveType").replaceWith("<input type='hidden' name='activeType' value='1' id='hiddenActiveType' />");
                }
                if (tutorial.checkActive) {
                    $("#toggle").replaceWith("<a class='btn btn-warning' id='toggle' value='tutorials_deActiveAll'><i class='fa fa-close'></i> Bỏ duyệt tất cả</a>");
                    $("#hiddenActiveType").replaceWith("<input type='hidden' name='activeType' value='0' id='hiddenActiveType' />");
                }
            },
            error: function (error) {
            }
        });
        return false;
    });
}

// cập nhật tất cả trạng thái duyệt tutorials
function toggleActiveAllTutotirial() {
    $(document).on('click', '#toggle', function (event) {
        var messages = $('#toggle').attr('value');
        var r;

        if (messages == 'tutorials_activeAll') {
            r = confirm('Bạn có chắc chắn tất cả Tin gia sư đã được duyệt?');
        }
        if (messages == 'tutorials_deActiveAll') {
            r = confirm('Bạn có chắc chắn tất cả Tin gia sư sẽ được bỏ duyệt?');
        }
        if (r == true) {
            $('#formActiveAll').submit();
        }
    });
    $(document).on('submit', '#formActiveAll', function (event) {
        event.preventDefault(event);
        var inputData = $('#formActiveAll').serializeArray();
        $.ajax({
            url: '/api/admin/tutorials/update/ActiveAll',
            type: 'PATCH',
            data: inputData,
            success: function (response) {
                var tutorials = response.data;
                for (var i = 1; i < response.data.length; i++) {
                    if (response.data[i].active) {
                        $("#items-" + response.data[i].id).replaceWith("<button class='btn bg-olive btn-xs activeUpdate' data-id='" + response.data[i].id + "' id='items-" + response.data[i].id + "' data-toggle='tooltip' title='Bỏ duyệt'><i class='fa  fa-check' data-toggle='tooltip'></i></button>");
                    } else {
                        $("#items-" + response.data[i].id).replaceWith("<button class='btn btn-warning btn-xs activeUpdate' data-id='" + response.data[i].id + "' id='items-" + response.data[i].id + "' data-toggle='tooltip' title='Duyệt'><i class='fa  fa fa-close' data-toggle='tooltip'></i></button>");
                    }
                }
                var activeType = response.data[0].activeType;
                if (activeType == 1) {
                    $("#toggle").replaceWith("<a class='btn btn-warning' id='toggle' value='tutorials_deActiveAll'><i class='fa fa-close'></i> Bỏ duyệt tất cả</a>");
                    $("#hiddenActiveType").replaceWith("<input type='hidden' name='activeType' value='0' id='hiddenActiveType' />");
                }
                if (activeType == 0) {
                    $("#toggle").replaceWith("<a class='btn bg-olive' id='toggle' value='tutorials_activeAll'><i class='fa fa-check'></i> Duyệt tất cả</a>");
                    $("#hiddenActiveType").replaceWith("<input type='hidden' name='activeType' value='1' id='hiddenActiveType' />");
                }
            },
            error: function (error) {
            }
        });
        return false;
    });
}

// cập nhật trạng thái nhận từng tutorial
function toggleConfirmTutotirial() {
    $(document).on('click', '.confirmUpdate', function (event) {
        event.preventDefault(event);
        $(this).tooltip('destroy');
        var inputData = $('#formUpdateConfirm').serialize();
        var dataId = $(this).attr('data-id');
        $.ajax({
            url: '/api/admin/tutorials/' + dataId + '/updateConfirm',
            type: 'PATCH',
            data: inputData,
            success: function (response) {
                var tutorial = response.data;
                if (tutorial.confirm) {
                    $("#updateItems-" + tutorial.id).replaceWith("<button class='btn btn-green btn-xs confirmUpdate' data-id='" + tutorial.id + "' id='updateItems-" + tutorial.id + "' data-toggle='tooltip' title='Bỏ nhận'><i class='fa  fa-check'></i></button>");
                } else if (tutorial.confirm == 0 && !response.checkConfirm) {
                    $("#updateItems-" + tutorial.id).replaceWith("<button class='btn btn-yellow btn-xs confirmUpdate' data-id='" + tutorial.id + "' id='updateItems-" + tutorial.id + "' data-toggle='tooltip' title='Nhận'><i class='fa  fa fa-close'></i></button>");
                    $("#toggleConfirm").replaceWith("<a class='btn btn-green' id='toggleConfirm' value='tutorials_comfirmAll'><i class='fa fa-check'></i> Nhận tất cả</a>");
                    $("#hiddenConfirmType").replaceWith("<input type='hidden' name='confirmType' value='1' id='hiddenConfirmType' />");
                }
                if (tutorial.checkConfirm) {
                    $("#toggleConfirm").replaceWith("<a class='btn btn-yellow' id='toggleConfirm' value='tutorials_unConfirmAll'><i class='fa fa-close'></i> Bỏ nhận tất cả</a>");
                    $("#hiddenConfirmType").replaceWith("<input type='hidden' name='confirmType' value='0' id='hiddenConfirmType' />");
                }
            },
            error: function (error) {
            }
        });
        return false;
    });
}

// cập nhật tất cả trạng thái đã nhận tutorials
function toggleConfirmAllTutotirial() {
    // cập nhật tất cả trạng thái đã nhận,
    $(document).on('click', '#toggleConfirm', function (event) {
        var messages = $('#toggleConfirm').attr('value');
        var r;

        if (messages == 'tutorials_comfirmAll') {
            r = confirm('Bạn có chắc chắn tất cả các lớp Gia sư đã được nhận?');
        }
        if (messages == 'tutorials_unConfirmAll') {
            r = confirm('Bạn có chắc chắn tất cả các lớp Gia sư sẽ được bỏ nhận?');
        }
        if (r == true) {
            $('#formConfirmAll').submit();
        }
    });
    $(document).on('submit', '#formConfirmAll', function (event) {
        event.preventDefault(event);
        var inputData = $('#formConfirmAll').serializeArray();
        $.ajax({
            url: '/api/admin/tutorials/update/ConfirmAll',
            type: 'PATCH',
            data: inputData,
            success: function (response) {
                var tutorials = response.data;
                for (var i = 1; i < response.data.length; i++) {
                    if (response.data[i].confirm) {
                        $("#updateItems-" + response.data[i].id).replaceWith("<button class='btn btn-green btn-xs confirmUpdate' data-id='" + response.data[i].id + "' id='updateItems-" + response.data[i].id + "' data-toggle='tooltip' title='Bỏ nhận'><i class='fa  fa-check'></i></button>");
                    } else {
                        $("#updateItems-" + response.data[i].id).replaceWith("<button class='btn btn-yellow btn-xs confirmUpdate' data-id='" + response.data[i].id + "' id='updateItems-" + response.data[i].id + "' data-toggle='tooltip' title='Nhận'><i class='fa  fa fa-close'></i></button>");
                    }
                }
                var comfirmType = response.data[0].comfirmType;
                if (comfirmType == 1) {
                    $("#toggleConfirm").replaceWith("<a class='btn btn-yellow' id='toggleConfirm' value='tutorials_unConfirmAll'><i class='fa fa-close'></i> Bỏ nhận tất cả</a>");
                    $("#hiddenConfirmType").replaceWith("<input type='hidden' name='confirmType' value='0' id='hiddenConfirmType' />");
                }
                if (comfirmType == 0) {
                    $("#toggleConfirm").replaceWith("<a class='btn btn-green' id='toggleConfirm' value='tutorials_comfirmAll'><i class='fa fa-check'></i> Nhận tất cả</a>");
                    $("#hiddenConfirmType").replaceWith("<input type='hidden' name='confirmType' value='1' id='hiddenConfirmType' />");
                }
            },
            error: function (error) {
            }
        });
        return false;
    });
}

function replyComment() {
    jQuery(document).on('click', '.reply', function (event) {
        jQuery(document).find('textarea').focus();
        var id = jQuery(this).closest('.the-comment').parent().attr('id');
        jQuery('#parent_id').val(id);
    });
}

function comment() {
    jQuery('#comment').submit(function (e) {

        e.preventDefault();

        var token = jQuery('input[name="_token"]').val();
        var content = jQuery("textarea[id='content']").val();
        var slug = jQuery('#slug').val();
        var parent_id = jQuery('#parent_id').val();
        var currentUrl = window.location.pathname.split('/')[2];

        var url = '';
        if (currentUrl == 'comments') {
            url = "/admin/comments/comment";
        }
        if (currentUrl == 'commentTests') {
            url = "/admin/commentTests/comment";
        }
        if (currentUrl == 'commentNews') {
            url = "/admin/commentNews/comment";
        }

        var formData = {
            _token: token,
            content: content,
            slug: slug,
            parent_id: parent_id
        };
        jQuery.ajax({
            type: "POST",
            url: url,
            data: formData,
            success: function (response) {
                jQuery('[data-toggle="tooltip"]').tooltip();

                if (content == undefined) {
                    alert('Chưa có bình luận');
                }

                if (response.user != undefined) {
                    jQuery('#no-comment').hide();
                    if (parent_id == 0) {
                        var lastcomment = "<li tabindex='-1' id='" + response.comment_id + "'class='comment depth-1 parent-" + response.comment_id + "'" + "value='" + response.comment_id + "'" + "style='display: list-item;'" + ">" +
                            "<div class='the-comment'>" +
                            "<div class='avatar'> " +
                            "<img src='/uploads/default-avatar.png' width='72' height='72' alt=''>" +
                            "</div>" +
                            "<div class='comment-box'>" +
                            "<div class='comment-author'>" +
                            "<a class='btn btn-default btn-sm pull-right delete_comment' style='margin-left: 10px;' id='delete_item'>Xóa</a>" +
                            "<a data-toggle='modal' data-target='#modalEdit' class='btn btn-default btn-sm pull-right' style='margin-left: 10px;' id='edit_item'></i>Chỉnh sửa</a>" +
                            "<a href='#comment'><button class='btn btn-default btn-sm pull-right reply' style='margin-left: 10px;'>" + "Trả lời" + "</button></a>" +
                            "<a class='btn btn-default btn-sm pull-right reply_count'>0 phản hồi</a>" +
                            "<h4 class='box-title'><a href='#'>" + response.user + "</a><small id='timeComment-" + response.comment_id + "'>" + response.updated_at + "</small></h4>" +
                            "</div>" +
                            "<div class='comment-text'>" +
                            "<p id='content-" + response.comment_id + "'>" + response.content + "</p>" +
                            "</div>" +
                            "</div>" +
                            "</div>" +
                            "</li>";
                        jQuery('#comment_list').prepend(lastcomment);
                        jQuery('#' + response.comment_id).attr('style', 'outline:0').focus();
                    } else {
                        var replycomment = "<ul class='children-" + response.comment_id + "'>" +
                            "<li tabindex='-1' id='" + parent_id + "'class='comment depth-2'" + "value='" + response.comment_id + "'style='display: list-item;'" + ">" +
                            "<div class='the-comment'>" +
                            "<div class='avatar'> " +
                            "<img src='/uploads/default-avatar.png' width='72' height='72' alt=''>" +
                            "</div>" +
                            "<div class='comment-box'>" +
                            "<div class='comment-author'>" +
                            "<a class='btn btn-default btn-sm pull-right delete_comment' style='margin-left: 10px;' id='delete_item'>Xóa</a>" +
                            "<a data-toggle='modal' data-target='#modalEdit' class='btn btn-default btn-sm pull-right' style='margin-left: 10px;' id='edit_item'></i>Chỉnh sửa</a>" +
                            "<a href='#comment'><button class='btn btn-default btn-sm pull-right reply'>" + "Trả lời" + "</button></a>" +
                            "<h4 class='box-title'><a href='#'>" + response.user + "</a><small id='timeComment-" + response.comment_id + "'>" + response.updated_at + "</small></h4>" +
                            "</div>" +
                            "<div class='comment-text'>" +
                            "<p id='content-" + response.comment_id + "'>" + response.content + "</p>" +
                            "</div>" +
                            "</div>" +
                            "</div>" +
                            "</li>" +
                            "</ul>";
                        jQuery('#' + parent_id).append(replycomment);
                        jQuery('#' + parent_id + '.depth-2').attr('style', 'outline:0').focus();
                    }

                    jQuery("textarea[id='content']").val("");
                    jQuery("#comment_count").html(response.comment_counts + " bình luận");
                    jQuery('#parent_id').val(0);
                    var replace_reply = parseInt(jQuery('#' + parent_id).find(".reply_count").text().split(' ')[0]) + 1;
                    jQuery('#' + parent_id).find(".reply_count").text(replace_reply + ' phản hồi');

                } else {
                    alert('Bạn cần phải đăng nhập để có thể bình luận');
                }
            },
            error: function (response) {
            }

        });
    });
}

function loadMoreComment() {
    var size_li = jQuery("#comment_list li").length;
    x = 4;
    jQuery('#comment_list li.depth-1:gt(' + x + ')').hide();
    jQuery('#loadMore').click(function () {
        x = (x + 5 <= size_li) ? x + 5 : size_li;
        jQuery('#comment_list li.depth-1:lt(' + x + ')').show();
        check = jQuery("#comment_list li.depth-1").length;
        if (x >= check) {
            jQuery('#loadMore').hide();
        }
    });

    jQuery('.reply_count').click(function () {
        var id = jQuery(this).closest('.the-comment').parent().attr('id');
        jQuery('#' + id + ' li.depth-2').show();
    });
}

//Xóa comment
function deleteComment() {
    $(document).on('click', '#delete_item', function (event) {
        var id = jQuery(this).closest('.the-comment').parent().attr('value');
        jQuery('#parent_id_delete').val(id);
        var r = confirm('Bạn có chắc chắn muốn xóa bình luận?');
        if (r == true) {
            $('#formDelete').submit();
        }
    });
    $(document).on('submit', '#formDelete', function (event) {
        event.preventDefault(event);
        var inputData = $('#formDelete').serialize();
        var parent_id = $('#parent_id_delete').attr('value');

        var currentUrl = window.location.pathname.split('/')[2];
        var url = '';
        if (currentUrl == 'comments') {
            url = '/admin/comments/' + parent_id;
        }
        if (currentUrl == 'commentTests') {
            url = '/admin/commentTests/' + parent_id;
        }
        if (currentUrl == 'commentNews') {
            url = '/admin/commentNews/' + parent_id;
        }

        $.ajax({
            url: url,
            type: 'DELETE',
            data: inputData,
            success: function (response) {
                if (parent_id == 0) {
                    jQuery('.parent-' + response.comment_id).replaceWith('');
                }
                else {
                    jQuery('.parent-' + response.comment_id).replaceWith('');
                    jQuery('.children-' + response.comment_id).replaceWith('');
                }
                jQuery("#comment_count").html(response.comment_counts + " bình luận");
                var replace_reply = parseInt(jQuery('#' + parent_id).find(".reply_count").text().split(' ')[0]) - 1;
                jQuery('#' + parent_id).find(".reply_count").text(replace_reply + ' phản hồi');
            },
            error: function (error) {
            }
        });
        return false;
    });
}

//Sửa comment, truyền params vào url
function editComment() {
    $(document).on('click', '#edit_item', function (event) {
        var id = jQuery(this).closest('.the-comment').parent().attr('value');
        jQuery('#editComment').val(id);
        var content = jQuery('#content-' + id).text();
        jQuery('#content').val(content);

    });
    $(document).on('submit', '#editForm', function (event) {
        event.preventDefault(event);
        var inputData = $('#editForm').serialize();
        var comment_id = $('#editComment').attr('value');

        var currentUrl = window.location.pathname.split('/')[2];
        var url = '';
        if (currentUrl == 'comments') {
            url = '/admin/comments/' + comment_id;
        }
        if (currentUrl == 'commentTests') {
            url = '/admin/commentTests/' + comment_id;
        }
        if (currentUrl == 'commentNews') {
            url = '/admin/commentNews/' + comment_id;
        }

        $.ajax({
            url: url,
            type: 'PATCH',
            data: inputData,
            success: function (response) {
                jQuery('#modalEdit').modal('hide');
                jQuery('#timeComment-' + response.comment_id).html(response.updated_at).attr("tabindex", "-1").attr('style', 'outline:0').focus();
                jQuery('#content-' + response.comment_id).html(response.content).attr("tabindex", "-1").attr('style', 'outline:0').focus();
            },
            error: function (error) {
            }
        });
        return false;
    });
}
function addMoneyAjax() {
    $('#addMoneyForm').submit(function (e) {
        e.preventDefault(e);
        var user_id = $('#user_id').val();
        var data = $(this).serialize();
        $.ajax({
            url: '/admin/users/' + user_id,
            type: $('#addMoneyForm').attr('method'),
            data: data,
            success: function (response) {
                if (response.success) {
                    $('#addMoneyModal').modal('hide');
                    $('#acc-' + response.id).html(response.account_balance);
                }
            }
        })
    });
    $('#addMoneyModal').on('hidden.bs.modal', function () {
        $('#cost_vnd').val('');
        $('#cost_know').val('');
        $('')
    })
}

function autoMoney() {
    formatInputVndAfterSet();
    formatInputKnowAfterSet();
    var coefficients = [];
    $.ajax({
        url: '/getCoefficient',
        type: 'POST',
        data: {
            _token: $('input[name="_token"]').val()
        },
        success: function (response) {
            coefficients = response;
        }
    });
    $('#cost_vnd').keyup(function () {
        var text = $('#cost_vnd').val();
        var value = text.replace(/^\D+|\./g, '');
        // var coefficients;
        if (value != 0) {
            var exchanged = false;
            var max_to = 0, max, use_default;
            // Xét ưu tiên thời gian nếu còn hiệu lực
            for (i = 0; i < coefficients.length; i++) {
                if (coefficients[i].cost_from < value && coefficients[i].cost_to >= value
                    && coefficients[i].apply_to != null && Date.parse(coefficients[i].apply_to) > Date.now()
                    && coefficients[i].apply_from != null && Date.parse(coefficients[i].apply_from)< Date.now()) {
                    var know = parseInt(value / coefficients[i].coefficient);
                    $('#cost_know').val(know > 1 ? parseInt(know) : 0);
                    formatInputKnowAfterSet();
                    exchanged = true;
                }
            }
            if (!exchanged) {
                //Xét giá trị mặc định của hệ thống
                for (i = 0; i < coefficients.length; i++) {
                    if (coefficients[i].cost_from < value && coefficients[i].cost_to >= value
                        && coefficients[i].apply_to == null && coefficients[i].apply_from == null) {
                        var know = parseInt(value / coefficients[i].coefficient);
                        $('#cost_know').val(know > 1 ? parseInt(know) : 0);
                        formatInputKnowAfterSet();
                        exchanged = true;
                    }
                    if (coefficients[i].cost_to > max_to && coefficients[i].cost_to<value && coefficients[i].apply_to == null && coefficients[i].apply_from == null) {
                        max_to = coefficients[i].cost_to;
                        max = i;
                    }
                }
                // Nếu không có giá trị mặc định có khoảng chứa giá trị, đổi theo hệ số mặc định của khoảng dưới gần nhất
                if (!exchanged) {
                    var know = parseInt(value / coefficients[max].coefficient);
                    $('#cost_know').val(know > 1 ? parseInt(know) : 0);
                    formatInputKnowAfterSet();
                }
            }
        }
        if ($('#cost_vnd').val() == '') {
            $('#cost_know').val('');
        }
    })
}

function formatMoneyCoefficient() {
    $('#coefficients_cost_from').priceFormat({
        prefix: 'VNĐ ',
        suffix: '',
        thousandsSeparator: '.',
        centsLimit: 0,
        clearOnEmpty: true
    });
    $('#coefficients_cost_to').priceFormat({
        prefix: 'VNĐ ',
        suffix: '',
        thousandsSeparator: '.',
        centsLimit: 0,
        clearOnEmpty: true
    });
}

function formatInputKnowAfterSet() {
    $('#cost_know').priceFormat({
        prefix: 'KNOW ',
        suffix: '',
        thousandsSeparator: '.',
        centsLimit: 0,
        clearOnEmpty: true
    });
}
function formatInputVndAfterSet() {
    $('#cost_vnd').priceFormat({
        prefix: 'VNĐ ',
        suffix: '',
        thousandsSeparator: '.',
        centsLimit: 0,
        clearOnEmpty: true
    });
}