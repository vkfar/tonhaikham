$(function() {
    
    $(".btn_logout").click(function() {
        $.post("ajax/ajax_logout.php", {}, function(data) {
            if (data.result == "yes") {
                window.location.href = "index.php";
            } else {
                alert(data.result);
            }
        }, 'json');
    });
    
});


