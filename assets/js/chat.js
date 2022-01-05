function getDateTime(timestamp) {
    var formatted = new Date(timestamp);
    return `${formatted.getDate()}/${formatted.getMonth()+1}/${formatted.getFullYear()} • ${formatted.getHours()}:${formatted.getMinutes()}`
}

function cekPesanDariSiswa(id_siswa, id_wali) {
    var chat_box = $("#chat-messages");
    var last_id = parseInt(chat_box.children().last().attr("data-id"));
    $.ajax({
        url:"../controller/action_chat",
        method:"POST",
        data: {action:'get_chat',id_siswa:id_siswa, id_wali:id_wali},
        dataType:'json',
        complete: function(response){
            $("#chat-loading").hide();
        },
        success: function(response){
            console.log(response)
            var chat_data = response.data;
            for (let i = 0; i < chat_data.length; i++) {
                if (parseInt(chat_data[i].id_chat) > last_id || isNaN(last_id)) {
                    var html_div = `
                    <div class="card m-2 ${chat_data[i].is_from_murid == "1" ? "dari-siswa align-self-start" : "dari-wali align-self-end"}" data-id="${chat_data[i].id_chat}" id="${chat_data[i].murid_id+'-'+chat_data[i].guru_id+'-'+chat_data[i].id_chat}">
                        <div class="card-body px-2 pt-1 pb-0 ${chat_data[i].is_from_siswa == "1" ? "text-left" : "text-right" }">
                            ${chat_data[i].message}
                        </div>
                        <div class="msg-datetime py-0 px-2">
                            ${getDateTime(chat_data[i].timestamps)}
                        </div>
                    </div>
                    `;
                    $(html_div).hide().appendTo(chat_box).fadeIn(500);
                    document.getElementById('chat-messages').lastElementChild.scrollIntoView({ behavior: "smooth" });
                }
            }   
        },
        error: function(response){
            console.log(response);
        }
    });
}

function cekPesanDariWaliKelas(id_siswa, id_wali) {
    var chat_box = $("#chat-messages");
    try {
        var last_id = parseInt(chat_box.children().last().attr("data-id"));
    } catch (error) {
        var last_id = NaN;
    }
    $.ajax({
        url:"../controller/action_chat",
        method:"POST",
        data: {action:'get_chat',id_siswa:id_siswa, id_wali:id_wali},
        dataType:'json',
        complete: function(response){
            $("#chat-loading").hide();
        },
        success: function(response){
            console.log(response)
            var chat_data = response.data;
            for (let i = 0; i < chat_data.length; i++) {
                if (parseInt(chat_data[i].id_chat) > last_id || isNaN(last_id)) {
                    var html_div = `
                    <div class="card m-2 ${chat_data[i].is_from_murid == "0" ? "dari-siswa align-self-start" : "dari-wali align-self-end"}" data-id="${chat_data[i].id_chat}" id="${chat_data[i].murid_id+'-'+chat_data[i].guru_id+'-'+chat_data[i].id_chat}">
                        <div class="card-body px-2 pt-1 pb-0 ${chat_data[i].is_from_siswa == "1" ? "text-left" : "text-right" }">
                            ${chat_data[i].message}
                        </div>
                        <div class="msg-datetime py-0 px-2">
                            ${getDateTime(chat_data[i].timestamps)}
                        </div>
                    </div>
                    `;
                    $(html_div).hide().appendTo(chat_box).fadeIn(500);
                    document.getElementById('chat-messages').lastElementChild.scrollIntoView({ behavior: "smooth" });
                }
            }   
        },
        error: function(response){
            console.log(response);
        }
    });
}

function send_message_to_siswa(id_siswa, id_wali) {
    var input_pesan = $("#input-pesan");

    if (input_pesan.val().length > 0 && input_pesan.val() != "") {
        $.ajax({
            url:"../controller/action_chat",
            method:"POST",
            data:{action:'send_msg_to_siswa',id_siswa:id_siswa, id_wali:id_wali, message: input_pesan.val()},
            dataType:'json',
            success: function(response){
                cekPesanDariSiswa();
                input_pesan.val("");
            },
            error: function(response) {
                console.log(response)
            }
        });
    }
}
      
function send_message_to_wali_kelas(id_siswa, id_wali) {
    var input_pesan = $("#input-pesan");
    console.log(id_siswa);

    if (input_pesan.val().length > 0 && input_pesan.val() != "") {
        $.ajax({
            url:"../controller/action_chat",
            method:"POST",
            data:{action:'send_msg_to_wali_kelas',id_siswa:id_siswa, id_wali:id_wali, message: input_pesan.val()},
            dataType:'json',
            success: function(response){
                cekPesanDariWaliKelas();
                input_pesan.val("");
            },
            error: function(response) {
                console.log(response)
            }
        });
    }
}
