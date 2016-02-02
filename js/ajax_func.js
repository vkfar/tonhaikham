$(function() {

    // Load table
    var G_TABLE = "";
    var B_TABLE = "";
    $(".btn_load_table").click(function() {
        $("#box_table_detail").html("<img src='img_project/ajax-loader.gif'>");
        $("#btn_close_table_box").show('fast');
        var table_type = $(this).attr('data-id');
        $.post("ajax/ajax_load_table.php", {table_type: table_type}, function(data) {
            $("#box_table_detail").hide();
            $("#box_table_detail").html(data).css("background-color", "#D2322D");
            $("#box_table_detail").slideDown('fast');
        });
    });
    // end Load table
    // 
    // 
    // close load table
    $("#btn_close_table_box").click(function() {
        $("#btn_close_table_box").hide('slow');
        $("#search_table").val("");
        $("#box_table_detail").slideUp('slow').html("");
    });
    //end  close load table
    //
    // load menu item
    $("#box_menu").on("click", ".btn_menu", function() {
        $("#box_menu>ul>li").removeClass("active");
        $(this).parent().addClass("active");
        $("#box_menu_item").html("<img src='img_project/ajax-loader.gif'>");
        $.post("ajax/ajax_load_food_item.php", {menu: $(this).attr("data-id")}, function(data) {
            $("#box_menu_item").html(data);
        });

    });
    //end  load menu item
    //
    // click item or food
    $("#box_menu_item").on("click", ".btn_menu_item", function() {
        if (G_TABLE == "") {
            alert("Please choose table");
        } else {
            if (B_TABLE == "booking") {
                alert("Please Confirm Reservation!");
            } else {

                var item = $(this).attr("data-id");
                $.post("ajax/ajax_order.php", {table: G_TABLE, item: item}, function(data) {
                    if (data.result == "ok") {
                        $.post("ajax/ajax_load_table_bill.php", {table: G_TABLE}, function(data) {
                            $("#box_bill").html(data);
                        });
                    } else {
                        alert("error");
                    }
                }, 'json');
            }
        }
    });

    $("#box_table_detail").on("click", ".btn-table", function() {
        $("#btn_close_table_box").hide('slow');
        $("#box_table_detail").slideUp().html("");
        $("#box_bill").html("<img src='img_project/ajax-loader.gif'>");
        G_TABLE = $(this).attr('data-id');
        $.post("ajax/ajax_load_table_bill.php", {table: G_TABLE}, function(data) {
            $("#box_bill").html(data);
        });
        if ($(this).attr('data-type') == "3") {
            B_TABLE = "booking";
        } else {
            B_TABLE = "";
        }


    });

    $("#box_table_detail").on("click", ".btn-table-change", function() {
        if (confirm("Do you want to move table")) {


            $("#btn_close_table_box").hide('slow');
            $("#box_table_detail").slideUp().html("");
            $("#box_bill").html("<img src='img_project/ajax-loader.gif'>");
            var old_table = G_TABLE;
            G_TABLE = $(this).attr('data-id');
            $.post("ajax/ajax_change_table.php", {old_t: old_table, new_t: G_TABLE}, function(data) {
                if (data.result == "yes") {
                    $.post("ajax/ajax_load_table_bill.php", {table: G_TABLE}, function(data) {
                        $("#box_bill").html(data);
                    });
                } else {
                    alert("error");
                }
            }, 'json');
        }

    });


    //end  item or food

    //btn confirm order

    $("#box_bill").on("click", "#btn-confirm-order", function() {
        $.post("ajax/ajax_confirm_order.php", {table: G_TABLE}, function(data) {
            if (data.result == "ok") {
                $.post("ajax/ajax_load_table_bill.php", {table: G_TABLE}, function(data) {
                    $("#box_bill").html(data);
                });
            } else {
                alert("error");
            }
        }, 'json');
    });

    // member discount btn_member_discount
    $("#box_bill").on("click", ".btn_member_verify", function() {
        $(".modal-title").html("Member Verify");
        var htm_m_vl = '<form role="form">';
        htm_m_vl += '<div class="form-group">';
        htm_m_vl += '<label>Member Code:</label>';
        htm_m_vl += '<input type="text" class="form-control" id="member_code_verify">';
        htm_m_vl += '</div>';
        htm_m_vl += '</form>';
        $(".modal-footer").html('<button type="button" class="btn btn-primary btn_member_verify_confirm">Confirm</button>');
        $(".modal-body").html(htm_m_vl);
    });

    $(".modal-footer").on("click", ".btn_member_verify_confirm", function() {
        var member_code_verify = $("#member_code_verify").val();
        $.post("ajax/ajax_confirm_member_verify.php", {mem_code: member_code_verify, table: G_TABLE}, function(data) {
            if (data.result == "yes") {
                if (data.result_txt == "yes") {
                    $.post("ajax/ajax_load_table_bill.php", {table: G_TABLE}, function(data) {
                        $("#box_bill").html(data);
                        $("#this_modal").modal('hide');
                    });
                } else {
                    alert(data.result_txt);
                }

            } else {
                alert("Error");
            }
        }, 'json');
    });

    $("#box_bill").on("click", ".btn_remove_verify", function() {
        if (confirm("Do you want to remvoe member verify?")) {
            $.post("ajax/ajax_remove_member_verify.php", {table: G_TABLE}, function(data) {
                if (data.result == "yes") {
                    $.post("ajax/ajax_load_table_bill.php", {table: G_TABLE}, function(data) {
                        $("#box_bill").html(data);
                    });
                } else {
                    alert("Error");
                }
            }, 'json');
        }
    });

    // end member discount

    //reservation 
    $("#box_bill").on("click", ".btn-reservation-confirm", function() {
        var reservation_id = $(".txt_reservation_id").val();
        if (confirm("Do you want to confirm reservation?")) {
            $.post("ajax/ajax_reservation_process.php", {table: G_TABLE, reservation_id: reservation_id, type: "confirm"}, function(data) {
                B_TABLE = "";
                if (data.result == "ok") {
                    $.post("ajax/ajax_load_table_bill.php", {table: G_TABLE}, function(data) {
                        $("#box_bill").html(data);
                    });
                } else {
                    alert("error");
                }
            }, 'json');
        }
    });
    $("#box_bill").on("click", ".btn-reservation-cancle", function() {
        var reservation_id = $(".txt_reservation_id").val();
        if (confirm("Do you want to cancle reservation?")) {
            $.post("ajax/ajax_reservation_process.php", {table: G_TABLE, reservation_id: reservation_id, type: "cancle"}, function(data) {
                B_TABLE = "";
                if (data.result == "ok") {
                    $.post("ajax/ajax_load_table_bill.php", {table: G_TABLE}, function(data) {
                        $("#box_bill").html(data);
                    });
                } else {
                    alert("error");
                }
            }, 'json');
        }
    });

    $("#box_bill").on("click", ".btn_load_reservation_new", function() {
        $(".modal-title").html("Add Table Reservation");
        $(".modal-body").html("Loading...");
        $.post("ajax/ajax_load_reservation_add.php", {}, function(data) {
            $(".modal-body").html(data);
        });
        var html_f = '<button type="button" class="btn btn-default" data-dismiss="modal">Close</button><button type="button" class="btn btn-primary" id="btn_save_reservation">Save</button>';
        $(".modal-footer").html(html_f);
    });

    $(".modal-footer").on("click", "#btn_save_reservation", function() {
        var b_name = $("#txt_b_name").val();
        var b_tell = $("#txt_b_tell").val();
        var b_date = $("#txt_b_date").val();
        var b_note = $("#txt_b_note").val();
        $.post("ajax/ajax_booking_table.php", {name: b_name, tell: b_tell, date: b_date, table: G_TABLE, note: b_note}, function(data) {
            if (data.result == 'ok') {
                if (data.msg == "no") {
                    B_TABLE = "booking";
                    $.post("ajax/ajax_load_table_bill.php", {table: G_TABLE}, function(data) {
                        $("#box_bill").html(data);
                        $("#this_modal").modal('hide');
                    });
                } else {
                    alert(data.msg);
                }
            } else {
                alert("error");
            }
        }, 'json');
    });


    $("#box_bill").on("click", ".btn-reservation-edit", function() {

        var reservation_id = $(".txt_reservation_id").val();
        $(".modal-title").html("Edit Table Reservation");
        $(".modal-body").html("Loading...");
        $.post("ajax/ajax_load_reservation_edit.php", {reservation_id: reservation_id}, function(data) {
            $(".modal-body").html(data);
        });
        var html_f = '<button type="button" class="btn btn-default" data-dismiss="modal">Close</button><button type="button" class="btn btn-primary" id="btn_edit_reservation">Save changes</button>';
        $(".modal-footer").html(html_f);
    });

    $(".modal-footer").on("click", "#btn_edit_reservation", function() {
        var b_name = $("#txt_b_name").val();
        var b_tell = $("#txt_b_tell").val();
        var b_date = $("#txt_b_date").val();
        var b_note = $("#txt_b_note").val();
        var reservation_id = $(".txt_reservation_id").val();
        $.post("ajax/ajax_booking_table_edit.php", {name: b_name, tell: b_tell, date: b_date, reservation_id: reservation_id, note: b_note}, function(data) {
            if (data.result == 'ok') {
                if (data.msg == "no") {
                    $.post("ajax/ajax_load_table_bill.php", {table: G_TABLE}, function(data) {
                        $("#box_bill").html(data);
                        $("#this_modal").modal('hide');
                    });
                } else {
                    alert(data.msg);
                }
            } else {
                alert("error");
            }
        }, 'json');

    });

    $("#box_bill").on("click", ".btn-reservation-del", function() {
        var reservation_id = $(".txt_reservation_id").val();
        if (confirm("Do you want to delete reservation?")) {
            $.post("ajax/ajax_reservation_process.php", {table: G_TABLE, reservation_id: reservation_id, type: "delete"}, function(data) {
                if (data.result == "ok") {
                    B_TABLE = "";
                    $.post("ajax/ajax_load_table_bill.php", {table: G_TABLE}, function(data) {
                        $("#box_bill").html(data);
                    });
                } else {
                    alert("error");
                }
            }, 'json');
        }
    });

    //end reservation


    // print-bill

    $("#box_bill").on("click", "#btn-printbill", function() {
        window.open('print_bill.php?table=' + G_TABLE, '_blank');
    });



    // payment btn-payment
    $("#box_bill").on("click", "#btn-payment", function() {

        $(".modal-title").html("Payment");
        $.post("ajax/ajax_load_payment.php", {table: G_TABLE}, function(data) {
            $(".modal-body").html(data);
        });

        var html_f = '';

        $(".modal-footer").html(html_f);
    });

    $("#box_bill").on("click", ".btn_chg_table", function() {

        $("#box_table_detail").html("<img src='img_project/ajax-loader.gif'>");
        $("#btn_close_table_box").show('fast');

        $.post("ajax/ajax_load_table.php", {table_type: "change_table"}, function(data) {
            $("#box_table_detail").hide();
            $("#box_table_detail").html(data).css("background-color", "#FFFFFF");
            $("#box_table_detail").slideDown('fast');
        });

    });

    $(".modal-content").on("keyup", "#txt-total-paid", function() {
        var total_paid = parseInt($("#txt-total-order").val());
        var paid = parseInt($("#txt-total-paid").val());
        var ordernum_id = parseInt($("#ordernum_id").val());
        if (total_paid <= paid) {
            $("#txt-chage").html(paid - total_paid);
            $(".modal-footer").html('<button type="button" class="btn btn-primary" id="btn_save_paid" data-id="' + ordernum_id + '">Save</button>');
        } else {
            $("#txt-chage").html("Not Enough Money");
            $(".modal-footer").html("");
        }
    });

    $(".modal-footer").on("click", "#btn_save_paid", function() {
        var ordernum_id = $(this).attr("data-id");
        var paid = $("#txt-total-paid").val();

        $.post("ajax/ajax_save_paid.php", {id: ordernum_id}, function(data) {
            if (data.result == "yes") {
                window.location.href = 'receipt.php?id=' + ordernum_id + "&paid=" + paid;
            } else {
                alert("error");
            }
        }, 'json');

    });
    //end pay

    // .remove_item btn remove item order
    $("#box_bill").on("click", ".remove_item", function() {
        var this_item = $(this).parent().parent().attr('data-id');

        $.post("ajax/ajax_remove_item.php", {item: this_item, table: G_TABLE}, function(data) {
            if (data.result == "ok") {
                $.post("ajax/ajax_load_table_bill.php", {table: G_TABLE}, function(data) {
                    $("#box_bill").html(data);
                });
            } else {
                alert("Error!");
            }
        }, 'json');
    });

    //end remove_item

    $("#box_bill").on("click", ".item_q", function() {
        var this_val = $(this).text();
        var this_item = $(this).parent().parent().attr('data-id');
        $(".modal-title").html("Change Quantity");
        var html_b = '<form role="form"><div class="form-group"><label>Enter Quantity</label><input type="hidden" id="txt_chg_item" value="' + this_item + '"><input type="text" class="form-control" id="txt_chg_q" placeholder="' + this_val + '"></div></form>';
        var html_f = '<button type="button" class="btn btn-default" data-dismiss="modal">Close</button><button type="button" class="btn btn-primary" id="btn_chg_q">Save changes</button>';
        $(".modal-body").html(html_b);
        $(".modal-footer").html(html_f);
    });
    $(".modal-footer").on("click", "#btn_chg_q", function() {
        var quantity = $.trim($("#txt_chg_q").val());
        var item = $("#txt_chg_item").val();
        $.post("ajax/ajax_editor_quantity.php", {quantity: quantity, item: item}, function(data) {
            if (data.result == "ok") {
                $.post("ajax/ajax_load_table_bill.php", {table: G_TABLE}, function(data) {
                    $("#box_bill").html(data);
                    $("#this_modal").modal('hide');
                });
            } else {
                alert("Error");
            }
        }, 'json');
    });

    $("#box_bill").on("click", ".btn_load_new_table_again", function() {
        $.post("ajax/ajax_load_table_bill.php", {table: G_TABLE}, function(data) {
            $("#box_bill").html(data);
        });
    });
    $("#box_bill").on("click", ".btn_cancle_table", function() {
        $.post("ajax/ajax_cancle_table.php", {table: G_TABLE}, function(data) {
            if (data.result == "ok") {
                $.post("ajax/ajax_load_table_bill.php", {table: G_TABLE}, function(data) {
                    $("#box_bill").html(data);
                });
            } else {
                alert("Error!");
            }
        }, 'json');

    });

    $("#btn_search_menu_pos").click(function() {
        var menu = $("#txt_menu_search").val();
        var type = $("#txt_menu_type_search").val();
        $("#box_menu>ul>li").removeClass("active");
        $("#box_menu_item").html("<img src='img_project/ajax-loader.gif'>");
        $.post("ajax/ajax_load_food_item.php", {menu: menu, menu_type: type}, function(data) {
            $("#box_menu_item").html(data);
        });

    });
    $("#txt_menu_type_search").change(function() {
        $("#txt_menu_search").remove();
        if ($(this).val() == "Status") {
            var search_html = '<select style="border: 1px solid #cccccc;padding: 3px;" id="txt_menu_search"><option value="1">Disable</option><option value="2">Enable</option></select>';
        } else {
            var search_html = '<input type="text" id="txt_menu_search"  placeholder="food info for search ..." style="border: 1px solid #cccccc;padding: 3px;">';
        }
        $("#box_pos_search").prepend(search_html);
    });

    $("#search_table").focus(function() {
        $("#box_table_detail").html("<img src='img_project/ajax-loader.gif'>");
        $("#btn_close_table_box").show('fast');
        var table_search = $(this).val();
        $.post("ajax/ajax_load_table_search.php", {table_search: table_search}, function(data) {
            $("#box_table_detail").hide();
            $("#box_table_detail").html(data).css("background-color", "#D2322D");
            $("#box_table_detail").slideDown('fast');
        });
    });
    $("#search_table").keyup(function() {
        $("#box_table_detail").html("<img src='img_project/ajax-loader.gif'>");
        $("#btn_close_table_box").show('fast');
        var table_search = $(this).val();
        $.post("ajax/ajax_load_table_search.php", {table_search: table_search}, function(data) {
            $("#box_table_detail").hide();
            $("#box_table_detail").html(data).css("background-color", "#D2322D");
            $("#box_table_detail").slideDown('fast');
        });
    });












});

