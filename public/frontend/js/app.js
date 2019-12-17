jQuery(document).ready(function () {
    jQuery.ajaxSetup({
        headers: {'X-CSRF-Token': jQuery('meta[name=_token]').attr('content')}
    });

    loadMoreComment();
    switchModeView();
    replyComment();
    comment();
    loadMoreTransaction();
    tooltip();
    commentHistory();
    loadMoreDocComment();
    loadMoreTestComment();
    loadMoreNewsComment();
    autoModalAuth();
    modalMoneyConfirmSubmit();
    modalMoneyConfirmLinkSubmit();
    modalSendMailCode();
    modalShowDetailTutorialSubmit();
    showDetail();
    showHideSecondModal();
    cancelModal();
    loadMoreHome();
    modalSubmitRechargeCard();
    getInfo();
    commentDocumentModal();
    loginAjax();
    registerAjax();
    resetPassAjax();
    loadDistrictsByCity();
    showHidePassword();

    jQuery('#content-comment').keyup(actionComment);
    function actionComment() {
        if (jQuery('#content-comment').val().length > 0) {
            jQuery('#post-btn').prop("disabled", false);
            jQuery('#post-btn').prop("style", "");
        } else{
            jQuery('#post-btn').prop("disabled", true);
            jQuery('#post-btn').prop("style", "background-color: #f5f5f5; color: black");
        }
    }

    jQuery('select').select2({
        language: {
            noResults: function (params) {
                return "Không tìm thấy kết quả.";
            }
        }
    });

    jQuery('input[type=radio][name=trans]').change(function () {
        loadTransByContent(this.value);
    });
    jQuery('#modal-minus-money-link').on('hidden.bs.modal', function (){
        jQuery('#comment_id').val(0);
    })
});

function switchModeView() {
    var gridMode = jQuery('#grid-mode');
    var listMode = jQuery('#list-mode');

    gridMode.click(function () {
        /*DISPLAY GRID*/
        jQuery('.grid-mode').css("display", "block");
        jQuery('.list-mode').css("display", "none");

        /*ACTIVE BLOCK*/
        jQuery('.swap-block').addClass("active");
        jQuery('.swap-list').removeClass("active");

        /*REPLACE URL*/
        window.location.href = replaceUrlParam(window.location.href, 'mode', 'grid');

        /*SEARCH MODE*/
        jQuery('#mode').val('grid');
    });

    listMode.click(function () {
        /*DISPLAY LIST*/
        jQuery('.grid-mode').css("display", "none");
        jQuery('.list-mode').css("display", "block");

        /*ACTIVE LIST*/
        jQuery('.swap-block').removeClass("active");
        jQuery('.swap-list').addClass("active");

        /*REPLACE URL*/
        window.location.href = replaceUrlParam(window.location.href, 'mode', 'list');

        /*SEARCH MODE*/
        jQuery('#mode').val('list');
    });
}

function replaceUrlParam(url, paramName, paramValue) {
    if (paramValue == null)
        paramValue = '';
    var pattern = new RegExp('\\b(' + paramName + '=).*?(&|$)')
    if (url.search(pattern) >= 0) {
        return url.replace(pattern, '$1' + paramValue + '$2');
    }
    return url + (url.indexOf('?') > 0 ? '&' : '?') + paramName + '=' + paramValue
}

function replyComment() {
    jQuery(document).on('click', '.reply', function (event) {
        jQuery(document).find('textarea').focus();
        var id = jQuery(this).closest('.the-comment').parent().attr('id');
        jQuery('#parent_id').val(id);
    });
}

function comment() {
    jQuery('#comment_doc').submit(function (e) {
        e.preventDefault();
        var token = jQuery('input[name="_token"]').val();
        var content = jQuery("textarea[id='content-comment']").val();
        var slug = jQuery('#slug').val();
        var parent_id = jQuery('#parent_id').val();

        var currentUrl = window.location.pathname.split('/')[1];
        var url = '';
        if (currentUrl == 'de-thi') {
            url = "/de-thi/comment";
        }
        if (currentUrl == 'tai-lieu') {
            url = "/tai-lieu/comment";
            jQuery('#loading_comment').html('');
            jQuery('#loading_comment').html('<div class="text-center" style="margin: 5px 0 10px 0;"><div class="loader" align="center"></div></div>');
        }
        if (currentUrl == 'tin-tuc') {
            url = "/tin-tuc/comment";
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

                if (currentUrl == 'tai-lieu') {
                    jQuery('#loading_comment').html('');
                    jQuery('#modal-minus-money-comment').modal('hide');
                }
                jQuery('[data-toggle="tooltip"]').tooltip();

                if (content == undefined) {
                    alert('Chưa có bình luận');
                }

                if (response.user != undefined) {
                    jQuery('#no-comment').hide();
                    if (parent_id == 0) {
                        var lastcomment = "<li tabindex='-1' id='" + response.comment_id + "'class='comment depth-1'" + "style='display: list-item; outline: 0'" + ">" +
                            "<div class='the-comment'>" +
                            "<div class='avatar'> " +
                            "<img src='" + response.avatar + "' width='72' height='72' alt=''>" +
                            "</div>" +
                            "<div class='comment-box'>" +
                            "<div class='comment-author'>" +
                            "<button type='button' style='margin-left: 10px;' class='button btn-mini pull-right reply'>" + "Trả lời" + "</button>" +
                            "<a class='button btn-mini pull-right reply_count'>0 phản hồi</a>" +
                            "<h4 class='box-title'><a href='#'>" + response.user + "</a><small>" + response.updated_at + "</small></h4>" +
                            "</div>" +
                            "<div class='comment-text'>" +
                            "<p>" + response.content + "</p>" +
                            "</div>" +
                            "</div>" +
                            "</div>" +
                            "</li>";
                        jQuery('#comment_list').prepend(lastcomment);
                        jQuery('#' + response.comment_id).focus();
                    } else {
                        var replycomment = "<ul class='children'>" +
                            "<li tabindex='-1' id='" + parent_id + "'class='comment depth-2'" + "style='display: list-item; outline: 0'" + ">" +
                            "<div class='the-comment'>" +
                            "<div class='avatar'> " +
                            "<img src='" + response.avatar + "' width='72' height='72' alt=''>" +
                            "</div>" +
                            "<div class='comment-box'>" +
                            "<div class='comment-author'>" +
                            "<button type='button' class='button btn-mini pull-right reply'>" + "Trả lời" + "</button>" +
                            "<h4 class='box-title'><a href='#'>" + response.user + "</a><small>" + response.updated_at + "</small></h4>" +
                            "</div>" +
                            "<div class='comment-text'>" +
                            "<p>" + response.content + "</p>" +
                            "</div>" +
                            "</div>" +
                            "</div>" +
                            "</li>" +
                            "</ul>";
                        jQuery('#' + parent_id).append(replycomment);
                        jQuery('#' + parent_id + '.depth-2').focus();
                    }

                    jQuery("textarea[id='content-comment']").val('');
                    jQuery('#post-btn').prop("disabled", true);
                    jQuery('#post-btn').prop("style", "background-color: #f5f5f5; color: black");
                    jQuery("#comment_count").html(response.comment_counts + " bình luận");
                    jQuery("#comment_view").html(response.comment_counts + " / " + response.view_counts);
                    jQuery('#parent_id').val(0);
                    var replace_reply = parseInt(jQuery('#' + parent_id).find(".reply_count").text().split(' ')[0]) + 1;
                    jQuery('#' + parent_id).find(".reply_count").text(replace_reply + ' phản hồi');
                } else if (response.account_balance < response.know_comment) {
                    jQuery('.notice-recharge').html('<ul class="alert alert-danger">' +
                        '<li><p tabindex="-1" id="notice-recharge" style="margin-bottom: 0px; outline: 0">Tài khoản của bạn không đủ để thực hiện, vui lòng nạp thêm tiền!. <a href="#" style="margin-right: 10px; color: deepskyblue;" data-toggle="modal" data-target="#modal-recharge">  Nạp tiền</a>' +
                        '<button type="button" class="close pull-right" data-dismiss="alert" aria-hidden="true">×</button></p></li></ul>');
                    jQuery('#notice-recharge').focus();
                } else if (response.user == undefined) {
                    jQuery('.notice-recharge').html('<ul class="alert alert-danger">' +
                        '<li><p  tabindex="-1" id="notice-recharge" style="margin-bottom: 0px; outline: 0">Bạn cần đăng nhập để có thể bình luận!. <a href="#dang-nhap" style="margin-right: 10px; color: deepskyblue;" class="soap-popupbox"> Đăng nhập</a>' +
                        '<button type="button" class="close pull-right" data-dismiss="alert" aria-hidden="true">×</button></p></li></ul>');
                    jQuery('#notice-recharge').focus();
                }
            },
            error: function (response) {
                jQuery.each(response.responseJSON, function (key, val) {
                    jQuery('.notice-recharge').html('');
                    jQuery('.notice-recharge').html('<br><p style="color: red">' + val + '</p>')
                })
            }
        });
        return false;
    });
}

function loadMoreComment() {
    size_li = jQuery("#comment_list li").size();
    x = 5;
    jQuery('#comment_list li.depth-1:lt(' + x + ')').show();
    jQuery('#loadMore').click(function () {
        x = (x + 5 <= size_li) ? x + 5 : size_li;
        jQuery('#comment_list li.depth-1:lt(' + x + ')').show();
        check = jQuery("#comment_list li.depth-1").size();
        if (x >= check) {
            jQuery('#loadMore').hide();
        }
    });

    jQuery('.reply_count').click(function () {
        var id = jQuery(this).closest('.the-comment').parent().attr('id');
        jQuery('#' + id + ' li.depth-2').show();
    });
}

function loadMoreTransaction() {
    jQuery.each([0, 1, 2, 3, 4, 6], function (i, v) {
        var size_div = jQuery("#transaction-tab-"+v+" div.transaction_item").size();
        var x = 9;
        jQuery('#transaction-tab-'+v+' div.transaction_item:gt(' + x + ')').hide();

        jQuery('#loadMoreTrans-'+v).click(function () {
            x = (x +10 <= size_div) ? x + 10 : size_div;
            jQuery('#transaction-tab-'+v+' div.transaction_item:lt(' + x + ')').show();
            check = jQuery("#transaction-tab-"+v+" .transaction_item").size();

            if (x >= check) {
                jQuery('#loadMoreTrans-'+v).hide();
            }
        });
    });
}

function loginAjax() {

    jQuery('#login-form').submit(function (e) {
        e.preventDefault();
        jQuery('#notice-login').html('');
        jQuery('#notice-login').html('<div class="text-center" style="margin: 5px 0 10px 0;"><div class="loader" align="center"></div></div>');
        jQuery.ajax({
            type: jQuery('#login-form').attr('method'),
            url: jQuery('#login-form').attr('action'),
            data: jQuery('#login-form').serialize(),
            success: function (response) {
                if(response.success){
                    location.reload(0);
                }
                else
                    jQuery('#notice-login').html('<div class="alert-danger" style="margin: 5px 0 10px 0;"><p><strong>Thông tin tài khoản không chính xác</strong></p></div>');
            },
            error: function (data) {
                jQuery('#notice-login').html('<div class="alert-danger" style="margin: 5px 0 10px 0;"><p><strong>Thông tin tài khoản không chính xác</strong></p></div>');
            }
        });

    });
}

function registerAjax() {
    jQuery('#register-form').submit(function (e) {
        e.preventDefault(e);
        if (document.getElementById('agree').checked) {
            jQuery.each(['name', 'email', 'phone', 'password'], function (key) {
                jQuery('#reg-notice-' + key).html('');
            })
            jQuery('#notice-register').html('<div class="text-center" style="margin: 5px 0 10px 0;"><div class="loader" align="center"></div></div>')
            jQuery.ajax({
                type: jQuery(this).attr('method'),
                url: jQuery(this).attr('action'),
                data: jQuery('#register-form').serialize(),
                dataType: "json",
                success: function (response) {
                    if (response.success) {
                        var text = '<div class="text-center"><img src="/frontend/images/logo.png"></div><br>' + '<div class="alert-success" style="margin: 20px 0 20px 0; padding: 5px; text-align: center;"> ' +
                            '<p><strong>Đăng ký thành công!</strong><br>Cảm ơn bạn đã đăng ký tài khoản trên hệ thống của chúng tôi. Vui lòng kiểm tra hòm thư email để kích hoạt và sử dụng tài khoản. </p>' +
                            '</div>';
                        jQuery('#dang-ky').html(text);
                    }
                    else {
                        jQuery('#notice-register').html('');
                        jQuery.each(response, function (key, val) {
                            jQuery('#reg-notice-' + key).html('<p style="color: red">' + val + '</p>');
                        })
                    }
                },
                error: function (response) {
                    jQuery('#notice-register').html('');
                }
            });
        } else jQuery('#notice-register').html('<div class="alert-danger" style="margin: 5px 0 10px 0; padding: 5px;"><p>Bạn chưa đồng ý với các điều khoản sử dụng</p></div>');
    });
}

function resetPassAjax() {
    jQuery('#forgot-pass-form').submit(function (e) {
        e.preventDefault();
        jQuery('#notice-forgot-password').html('<div class="text-center" style="margin: 5px 0 10px 0; padding: 5px;"><div class="loader" align="center"></div></div>');
        jQuery.ajax({
            type: jQuery('#forgot-pass-form').attr('method'),
            url: jQuery('#forgot-pass-form').attr('action'),
            data: jQuery('#forgot-pass-form').serialize(),
            success: function (data) {
                if(data.success)
                    jQuery('#notice-forgot-password').html('<div class="alert-success"  style="margin: 5px 0 10px 0; padding: 5px;"><p><strong>Email hướng dẫn dã được gửi!</strong></p></div>');
                else
                    jQuery('#notice-forgot-password').html('<div class="alert-danger"  style="margin: 5px 0 10px 0; padding: 5px;"><p><strong>Email không chính xác, vui lòng kiểm tra lại</strong></p></div>');
            },
            error: function () {
                jQuery('#notice-forgot-password').html('');
                alert('Có lỗi xảy ra, vui lòng thử lại');
            }
        })
    })
}

function districtSelect() {
    var code = jQuery('#city_id').val();
    var districts = [];
    jQuery.ajax({
        url: '/api/admin/districts_by_code_city/' + code,
        type: 'get',
        success: success,
        error: error,
    });
    function success(data, status) {
        jQuery("#district_id").html("");
        var defaultDistrict = {
            "id": 0,
            "name": "-- Chọn Quận/Huyện --",
            "code": "",
            "type": "",
            "code_city": "",
            "created_at": "2017-06-08 15:44:45",
            "updated_at": "2017-06-14 10:24:53",
            "deleted_at": null
        };
        var districts = [];
        districts[0] = defaultDistrict;
        for (var i = 0; i < data.data.length; i++) {
            districts.push(data.data[i]);
        }
        districts.forEach(appendOption)
    }

    function appendOption(item, index, arr) {
        jQuery("#district_id").append(jQuery('<option>', {
            value: item.id,
            text: item.name,
        }));
    }

    function error() {
    }
}

function tooltip() {
    jQuery('.glyphicon.glyphicon-download-alt').tooltip({
        title: 'Nhấn để xem link',
        placement: "top"
    })

    jQuery(document).ajaxStop(function () {
        jQuery('.glyphicon.glyphicon-download-alt').tooltip({
            title: 'Nhấn để xem link',
            placement: "top"
        })
    });
}

function commentHistory() {
    jQuery('#docComment').show();
    jQuery('#testComment').hide();
    jQuery('#newsComment').hide();
    jQuery("input[name='filter']").change(function () {
        if (jQuery(this).val() == 1) {
            jQuery('#docComment').show();
            jQuery('#testComment').hide();
            jQuery('#newsComment').hide();
        }
        else if (jQuery(this).val() == 2) {
            jQuery('#docComment').hide();
            jQuery('#testComment').show();
            jQuery('#newsComment').hide();
        }
        else if (jQuery(this).val() == 3) {
            jQuery('#docComment').hide();
            jQuery('#testComment').hide();
            jQuery('#newsComment').show();
        }
    });
}

function loadMoreDocComment() {
    var size_div = jQuery("#doc_comment_list #doc_comment_item").size();
    x = 4;
    jQuery('#doc_comment_list tr#doc_comment_item:gt(' + x + ')').hide();

    jQuery('#loadMoreDoc').click(function () {
        x = (x + 5 <= size_div) ? x + 5 : size_div;
        jQuery('#doc_comment_list tr#doc_comment_item:lt(' + x + ')').show();
        check = jQuery("#doc_comment_list #doc_comment_item").size();

        if (x >= check) {
            jQuery('#loadMoreDoc').hide();
        }
    });
}

function loadMoreTestComment() {
    var size_div = jQuery("#test_comment_list #test_comment_item").size();
    x = 4;
    jQuery('#test_comment_list tr#test_comment_item:gt(' + x + ')').hide();

    jQuery('#loadMoreTest').click(function () {
        x = (x + 5 <= size_div) ? x + 5 : size_div;
        jQuery('#test_comment_list tr#test_comment_item:lt(' + x + ')').show();
        check = jQuery("#test_comment_list #test_comment_item").size();

        if (x >= check) {
            jQuery('#loadMoreTest').hide();
        }
    });
}

function loadMoreNewsComment() {
    var size_div = jQuery("#news_comment_list #news_comment_item").size();
    x = 4;
    jQuery('#news_comment_list tr#news_comment_item:gt(' + x + ')').hide();

    jQuery('#loadMoreNews').click(function () {
        x = (x + 5 <= size_div) ? x + 5 : size_div;
        jQuery('#news_comment_list tr#news_comment_item:lt(' + x + ')').show();
        check = jQuery("#news_comment_list #news_comment_item").size();

        if (x >= check) {
            jQuery('#loadMoreNews').hide();
        }
    });
}

function autoModalAuth() {
    jQuery('#modalAuth').modal('show');
}

function modalAuthSubmit() {
    jQuery('#auth-mail-form').unbind('submit').bind('submit', function (e) {
        e.preventDefault();
        jQuery('#auth-notice').html('<div class="loader" align="center"></div>');
        jQuery('#auth-error-email').html('');
        jQuery('#auth-error-phone').html('');
        jQuery('#auth-error-password').html('');
        jQuery.ajax({
            type: jQuery('#auth-mail-form').attr('method'),
            url: jQuery('#auth-mail-form').attr('action'),
            data: jQuery('#auth-mail-form').serialize(),
            success: function (response) {
                if (response.success) {
                    jQuery('#modalAuth').modal('hide');
                    location.reload(0);
                }
                else {
                    jQuery('#auth-notice').html('');
                    jQuery.each(response, function (key, val) {
                        jQuery('#auth-error-' + key).html('<p style="color: red;border-top-width: 10px;padding-top: 5px;">' + val + '</p>');
                    })
                }
            },
            error: function (response) {
                jQuery('#auth-notice').html('');
                jQuery.each(response.responseJSON, function (key, val) {
                    jQuery('#auth-error-' + key).html('<p style="color: red;border-top-width: 10px;padding-top: 5px;">' + val + '</p>');
                })
            }
        })
    });
}

function loadTransByContent(tab) {
    jQuery.each([0, 1, 2, 3, 4, 6], function (i, v) {
        jQuery('#transaction-tab-' + v).hide();
    })
    jQuery('#transaction-tab-' + tab).show();
}
function modalMoneyConfirmSubmit() {
    jQuery('#confirm_minus_money').submit(function (e) {
        jQuery('#loading_download_1').html('');
        jQuery('#loading_download_1').html('<div class="text-center" style="margin: 5px 0 10px 0;"><div class="loader" align="center"></div></div>');
        e.preventDefault();
        var token = jQuery('input[name="_token"]').val();

        var currentUrl = window.location.pathname.split('/')[1];
        var slug = jQuery('#slug').val();

        var url = '';
        if (currentUrl == 'de-thi') {
            url = "/de-thi/download";
        }
        if (currentUrl == 'tai-lieu') {
            url = "/tai-lieu/download";
        }

        var formData = {
            _token: token,
            slug: slug,
        };

        jQuery.ajax({
            type: "POST",
            url: url,
            data: formData,
            success: function (response) {
                jQuery('#loading_download_1').html('');
                if (response.user != undefined) {
                    jQuery('#modal-minus-money').modal('hide');
                    jQuery('#minus_money_file').replaceWith("<a id='minus_money_file' href='" + response.file + "' download class='button btn-small edit-profile-btn pull-right' style='background-color: #01b7f2;'>Download</a>");
                    jQuery('#minus_money_file')[0].click();
                    jQuery('#minus_money_file').replaceWith('<a id="minus_money_file" data-toggle="modal" data-target="#modal-minus-money" class="button btn-small edit-profile-btn pull-right" style="background-color: #01b7f2;">Download</a>');
                }
                else if (response.account_balance < response.know_download) {
                    jQuery('#modal-minus-money').modal('hide');
                    jQuery('.notice-recharge').html('<ul class="alert alert-danger">' +
                        '<li><p  tabindex="-1" id="notice-recharge" style="margin-bottom: 0px; outline: 0">Tài khoản của bạn không đủ để thực hiện, vui lòng nạp thêm tiền!. <a href="#" style="margin-right: 10px; color: deepskyblue;" data-toggle="modal" data-target="#modal-recharge">  Nạp tiền</a>' +
                        '<button type="button" class="close pull-right" data-dismiss="alert" aria-hidden="true">×</button></p></li></ul>');
                    jQuery('#notice-recharge').focus();
                }
            },
            error: function (response) {
                // jQuery.each(response.responseJSON, function (key, val) {
                //     jQuery('.notice-recharge').html('');
                //     jQuery('.notice-recharge').html('<br><p style="color: red">'+val+'</p>')
                // })
            }
        });
    });
}
function modalMoneyConfirmLinkSubmit() {
    jQuery('#confirm_minus_money_link').submit(function (e) {
        if(jQuery('#comment_id').val() > 0){
            jQuery('#loading_comment').html('');
            jQuery('#loading_comment').html('<div class="text-center" style="margin: 5px 0 10px 0;"><div class="loader" align="center"></div></div>');
        }
        jQuery('#loading_download_2').html('<div class="text-center" style="margin: 5px 0 10px 0;"><div class="loader" align="center"></div></div>');
        e.preventDefault();
        var token = jQuery('input[name="_token"]').val();

        var currentUrl = window.location.pathname.split('/')[1];
        var slug = jQuery('#slug').val();

        var url = '';
        if (currentUrl == 'de-thi') {
            url = "/de-thi/link-download";
        }
        if (currentUrl == 'tai-lieu') {
            url = "/tai-lieu/link-download";
        }

        var formData = {
            _token: token,
            slug: slug,
        };
        if(jQuery('#comment_id').val() > 0)
            formData.comment_id = jQuery('#comment_id').val();
        jQuery.ajax({
            type: "POST",
            url: url,
            data: formData,
            success: function (response) {
                jQuery('#loading_download_2').html('');
                if (response.user != undefined) {
                    jQuery('#modal-minus-money-link').modal('hide');
                    var win = window.open(response.link_download, '_blank');
                    if (win) {
                        win.focus();
                    } else {
                        window.location.href = response.link_download;
                    }
                    jQuery('#minus_money').replaceWith("<a id='minus_money' href='" + response.link_download + "' data-toggle='modal' data-target='#modal-minus-money-link' target='_blank' class='button btn-small edit-profile-btn pull-right' style='background-color: #01b7f2; margin-right: 15px'>Download</a>");
                    jQuery('#minus_money').replaceWith('<a id="minus_money" data-toggle="modal" data-target="#modal-minus-money-link" class="button btn-small edit-profile-btn pull-right" style="background-color: #01b7f2; margin-right: 15px">Download</a>');
                }else if(response.comment) {
                    jQuery('#modal-minus-money-link').modal('hide');
                    var win = window.open(response.link_download, '_blank');
                    if (win) {
                        win.focus();
                    } else {
                        window.location.href = response.link_download;
                    }
                }
                else if (response.account_balance < response.know_link_download) {
                    jQuery('#modal-minus-money-link').modal('hide');
                    jQuery('.notice-recharge').html('<ul class="alert alert-danger">'+
                        '<li><p  tabindex="-1" id="notice-recharge" style="margin-bottom: 0px; outline: 0">Tài khoản của bạn không đủ để thực hiện, vui lòng nạp thêm tiền!. <a href="#" style="margin-right: 10px; color: deepskyblue;" data-toggle="modal" data-target="#modal-recharge">  Nạp tiền</a>'+
                        '<button type="button" class="close pull-right" data-dismiss="alert" aria-hidden="true">×</button></p></li></ul>');
                    jQuery('#notice-recharge').focus();
                }
            },
            error: function (response) {
            }
        });
    });
}

function showHideSecondModal() {
    jQuery(document).on('click', '#receive_code', function (event) {
        jQuery('#modal_show_detail').modal('hide');
        jQuery('#email').val('');
        jQuery('#phone').val('');
        jQuery('#flash_messages_info').html('');
        jQuery('#flash_messages_info_email').html('');
        jQuery('#flash_messages_info_phone').html('');
    });
}

function cancelModal() {
    jQuery(document).on('click', '#cancel', function (event) {
        jQuery('#modal_show_detail').modal('show');
    });
}

function showDetail() {
    jQuery(document).on('click', '.minus_money', function (event) {
        var id = jQuery(this).attr('id');
        jQuery('.tutorial_id').val(id);
        jQuery('#code').val('');
        jQuery('.flash_messages').html('');
    });
}

function modalShowDetailTutorialSubmit() {
    jQuery('#confirm_minus_money_detail_tutorial').submit(function (e) {
        jQuery('#loading_show_detail').html('<div class="text-center" style="margin: 5px 0 10px 0;"><div class="loader" align="center"></div></div>');
        e.preventDefault();
        var token = jQuery('input[name="_token"]').val();
        var code = jQuery('input[name="code"]').val();
        var id = jQuery('.tutorial_id').val();
        var url = '/tim-gia-su/detail';

        var formData = {
            _token: token,
            id: id,
            code: code
        };

        jQuery.ajax({
            type: "POST",
            url: url,
            data: formData,
            success: function (response) {
                jQuery('#loading_show_detail').html('');
                if (!response.fail) {
                    jQuery('#modal_show_detail').modal('hide');
                    jQuery('#show_more_tutorial_' + response.id).html("<div id='show_more_tutorial_'" + response.id + "class='row time'><div class='col-xs-12'>" +
                        "<div class='row'><div class='col-md-5'>" +
                        "<i class='fa fa-mobile-phone yellow-color'></i>" +
                        "<span class='skin-color'> Số điện thoại</span></div>" +
                        "<div class='col-md-7'>" + response.phone + "</div></div></div>" +
                        "<div class='col-xs-12'><div class='row'><div class='col-md-5'>" +
                        "<i class='fa fa-envelope-o yellow-color'></i><span class='skin-color'> Email</span>" +
                        "</div><div class='col-md-7'>" + response.email + "</div></div></div>" +
                        "<div class='col-xs-12'><div class='row'><div class='col-md-5'><i class='fa fa-map-marker yellow-color'></i>" +
                        "<span class='skin-color'> Địa chỉ</span></div><div class='col-md-7'>" + response.address + "</div></div></div></div>");
                    jQuery('#' + response.id).replaceWith(' ');
                } else {
                    jQuery('.flash_messages').attr('style', 'color:red').html(response.error);
                }
            },
            error: function (response) {
            }
        });
    });
}
function modalSendMailCode() {
    jQuery('#confirm_send_mail').submit(function (e) {
        jQuery('#loading_tutorial').html('');
        jQuery('#loading_tutorial').html('<div class="text-center" style="margin: 5px 0 10px 0;"><div class="loader" align="center"></div></div>');

        e.preventDefault();
        var token = jQuery('input[name="_token"]').val();
        var id = jQuery('.tutorial_id').val();
        var url = '/tim-gia-su/sendMail';

        var formData = {
            _token: token,
            id: id,
        };

        jQuery.ajax({
            type: "POST",
            url: url,
            data: formData,
            success: function (response) {
                jQuery('#loading_tutorial').html('');
                jQuery('#modal_minus_money').modal('hide');
                if(response.success == 'fail'){
                    jQuery('#flash_error').html('Tài khoản của bạn chưa đủ KNOW và cần nạp thêm tiền!');
                    jQuery('#modal-recharge').modal('show');
                }
                else{
                    jQuery('#modal_show_detail').modal('show');
                    jQuery('.flash_messages').attr('style', ' ').html('Hệ thống đã gửi thành công email cho bạn. Nhập mã để xem chi tiết thông tin gia sư.');
                }
            },
            error: function (response) {
            }
        });
    });
}

function loadMoreHome() {
    var doc_line = 3;
    var max_doc = jQuery('#document-container > div').length - 2;
    jQuery('#loadMoreHomeDoc').click(function () {
        for (var i = doc_line; i < doc_line + 3; i++) {
            jQuery('#document-row-' + i).show();
        }

        doc_line += 3;
        if (doc_line >= max_doc) jQuery('#loadMoreHomeDoc').hide();
        // jQuery('#modal-load-more').modal('hide');
    });
    var test_line = 2;
    var max_test = jQuery('#test-container > div').length - 2;
    jQuery('#loadMoreHomeTest').click(function () {
        for (var i = test_line; i < doc_line + 2; i++) {
            jQuery('#test-row-' + test_line).show();
        }
        test_line += 2;
        if (test_line >= max_test) jQuery('#loadMoreHomeTest').hide();
    });
    var center_line = 1;
    var max_center = jQuery('#center-container > div').length - 2;
    jQuery('#loadMoreHomeCenter').click(function () {
        jQuery('#center-row-' + center_line).show();
        center_line++;
        if (center_line == max_center) jQuery('#loadMoreHomeCenter').hide();
    });
    var teacher_line = 1;
    var max_teacher = jQuery('#teacher-container > div').length - 2;
    jQuery('#loadMoreHomeTeacher').click(function () {
        jQuery('#teacher-row-' + teacher_line).show();
        teacher_line++;
        if (teacher_line == max_teacher) jQuery('#loadMoreHomeTeacher').hide();
    });
}

function modalSubmitRechargeCard() {
    jQuery('#modal_nap_the').submit(function (e) {
        e.preventDefault();
        jQuery('#loading').html('<div class="text-center" style="margin: 5px 0 10px 0;"><div class="loader" align="center"></div></div>');
        var url = '/nap-tien';
        jQuery.ajax({
            type: "POST",
            url: url,
            data: jQuery('#modal_nap_the').serialize(),
            success: function (response) {
                jQuery('#loading').html('');
                if (!response.fail) {
                    jQuery('#modal-recharge').modal('hide');
                    var currentUrl = window.location.pathname;
                    if(currentUrl.indexOf('/nguoi-dung')!== -1){
                        location.reload(0);
                        return;
                    }
                    //start set lại giá trị trống cho các trường
                    jQuery('#serial').val('');
                    jQuery('#pin').val('');
                    jQuery('#92').attr('checked','true');
                    //end
                    if (response.total >= response.know_tutorial) {
                        jQuery('#receive_code').attr('data-target', '#modal_minus_money');
                    }
                    jQuery('#modal_show_detail').modal('show');
                    if(response.amount != undefined && response.earn != undefined && response.user != undefined){
                        jQuery('.flash_messages').attr('style', ' ').html('Bạn đã nạp thành công <b>' + response.amount + ' VND</b> tương ứng <b>' + response.earn + ' KNOW</b> vào trong tài khoản.');

                        if(currentUrl.indexOf('/tai-lieu')!== -1 || currentUrl.indexOf('/de-thi')!== -1) {
                            //Hiển thị thông báo ở phần tài liệu và đề thi
                            jQuery('.notice-recharge').html('<ul class="alert alert-success ">' +
                                '<li><p tabindex="-1" id="notice-recharge" style="margin-bottom: 0px; outline: 0">Bạn đã nạp thành công ' + response.amount + 'đ. Bạn nhận được ' + response.earn + ' KNOW  vào trong tài khoản.' +
                                '<button type="button" class="close pull-right" data-dismiss="alert" aria-hidden="true">×</button></p></li></ul>');
                            jQuery('#notice-recharge').focus();
                        }
                    }else if(response.amount != undefined && response.earn != undefined && response.user == undefined){
                        jQuery('.flash_messages').attr('style', ' ').html('Bạn đã nạp thành công <b>' + response.amount + ' VND</b> tương ứng <b>' + response.earn + ' KNOW</b> vào trong tài khoản. Hệ thống đã gửi thành công email cho bạn, kiểm tra email để tiếp tục thao tác!');
                    }
                    if(response.amount != undefined && response.earn != undefined && response.user == undefined && response.account_balance < response.know_tutorial){
                        jQuery('.flash_messages').attr('style', ' ').html('Bạn đã nạp thành công <b>' + response.amount + ' VND</b> tương ứng <b>' + response.earn + ' KNOW</b> vào trong tài khoản. Hệ thống đã gửi thành công email cho bạn, kiểm tra email để tiếp tục thao tác!');
                        jQuery('#receive_code').replaceWith('<a href="#dang-nhap" class="soap-popupbox pull-left" style="color: deepskyblue;">Đăng nhập</a>');
                    }
                }
                else {
                    jQuery('#flash_error').html(response.error);
                }
            },
            error: function (response) {
            }
        });
    });
}

function getInfo() {
    jQuery('#get_info').submit(function (e) {
        e.preventDefault();
        jQuery('#loading_info').html('<div class="text-center" style="margin: 5px 0 10px 0;"><div class="loader" align="center"></div></div>');
        var url = '/check-user';
        //start truyền giá trị email và phone vào input hidden của form nạp thẻ
        var email = jQuery('#email').val();
        var phone = jQuery('#phone').val();
        jQuery('.info_phone').val(phone);
        jQuery('.info_email').val(email);
        //end

        jQuery.ajax({
            type: "POST",
            url: url,
            data: jQuery('#get_info').serialize(),
            success: function (response) {
                if(response.user != undefined){
                    jQuery('#loading_info').html('');
                    jQuery('#flash_messages_info_email').html('');
                    jQuery('#flash_messages_info_phone').html('');
                    jQuery('#flash_messages_info').html('Thông tin email đã có tài khoản sử dụng, vui lòng đăng nhập để tiếp tục thao tác!. <a href="#dang-nhap" class="soap-popupbox" style="margin-right: 10px; color: deepskyblue;">  Đăng nhập</a>');
                    jQuery('#email_or_phone').val(email);
                }
                else if(response.fail){
                    jQuery('#loading_info').html('');
                    jQuery('#modal_get_info').modal('hide');
                    jQuery('#modal-recharge').modal('show');
                }
                else{
                    jQuery('#loading_info').html('');
                    jQuery('#flash_messages_info_email').html('');
                    jQuery('#flash_messages_info_phone').html('');
                    jQuery.each(response, function (key, val) {
                        jQuery('#flash_messages_info_' + key).html('<p style="color: red; padding-top: 5px;">' + val + '</p>');
                    })
                }
            },
            error: function(response){
            }
        });
    });
}
function commentDocumentModal() {
    jQuery('#confirm_minus_money_comment').submit(function (e) {
        e.preventDefault(e);
        jQuery('#comment_doc').submit();
    })
}

function modalDownloadFromComment(id, slug) {
    console.log(slug);
    jQuery('#comment_id').val(id);
    jQuery('#slug').val(slug);
    jQuery('#modal-minus-money-link').modal('show');
}

function loadDistrictsByCity() {
    if(jQuery("#city_id").val()!=0){
        districtSelect();
    }
    jQuery("#city_id").change(function () {
        if (jQuery('#city_id').val() != 0) {
            districtSelect();
        }
        if (jQuery('#city_id').val() == 0) {
            jQuery("#district_id").html(jQuery('<option>', {
                value: 0,
                text: "-- Chọn Quận/Huyện --",
            }));
        }
    });
}
function showHidePassword(){
    jQuery('#password').keyup(function () {
        if(jQuery('#password').val().length > 0)
            jQuery('#show-hide-password').html('<i class="fa fa-eye"></i>');
        else{
            jQuery('#show-hide-password').html('<i class="glyphicon glyphicon-lock"></i>');
        }
    });
    jQuery('#show-hide-password').mousedown(function () {
        document.getElementById('password').type="text";
    });

    jQuery('#show-hide-password').mouseup(function () {
        document.getElementById('password').type="password";
    });
}