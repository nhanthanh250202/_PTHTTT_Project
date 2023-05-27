function hiddenDisplay() {
    $(".annouform").css("display", "none");
}
function switchTab(tab1,tab2,text_tab1,text_tab2) {
    tab1_name = "#"+tab1;
    tab2_name = "#"+tab2;
    
    if ($(tab2_name).css("display")=="none") {
        $(tab2_name).css("display", "flex");
        $(tab1_name).css("display", "none");
        $(event.target).text(text_tab2);
    }else{
        $(tab1_name).css("display", "flex");
        $(tab2_name).css("display", "none");
        $(event.target).text(text_tab1);
    }
}
function switchView() {
    if ($(event.target).hasClass("rotate-180-ccw")) {
        $(event.target).removeClass("rotate-180-ccw");
        $(event.target).addClass("rotate-180-cw");
    }else{
        $(event.target).removeClass("rotate-180-cw");
        $(event.target).addClass("rotate-180-ccw");
    }
}

$(document).ready(function () {
    var active_tab = "";
    function updateCurrentTab() {
        if ($("#group-tab-1").hasClass("active-tab-btn")) {
            active_tab = "tab-1";
        }else if ($("#group-tab-2").hasClass("active-tab-btn")){
            active_tab = "tab-2";
        }else{
            active_tab = "tab-3";
        }
        setTimeout(updateCurrentTab, 500);
    }
    updateCurrentTab();
    $("#tab-1-btn").click(function () { 
        $("#"+active_tab).css("display", "none");
        $("#group-"+active_tab).removeClass("active-tab-btn")
        $("#group-tab-1").addClass("active-tab-btn")
        $("#tab-1").css("display", "flex");
    });
    $("#tab-2-btn").click(function () { 
        $("#"+active_tab).css("display", "none");
        $("#group-"+active_tab).removeClass("active-tab-btn");
        $("#group-tab-2").addClass("active-tab-btn")
        $("#tab-2").css("display", "flex");
    });
    $("#tab-3-btn").click(function () { 
        $("#"+active_tab).css("display", "none");
        $("#group-"+active_tab).removeClass("active-tab-btn");
        $("#group-tab-3").addClass("active-tab-btn")
        $("#tab-3").css("display", "flex");
    });
});

function showPassword(password_input) {
    const ipnElement = document.querySelector(password_input)
    const currentType = ipnElement.getAttribute('type')
    if($(event.target).hasClass("ri-lock-password-fill")){
        $(event.target).removeClass("ri-lock-password-fill");
        $(event.target).addClass("ri-lock-unlock-fill");
    }else{
        $(event.target).addClass("ri-lock-password-fill");
        $(event.target).removeClass("ri-lock-unlock-fill");
    }
    ipnElement.setAttribute(
        'type',
        currentType === 'password' ? 'text' : 'password'
    )
}
