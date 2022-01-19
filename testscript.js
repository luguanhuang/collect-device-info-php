$(document).ready(function load(){
    $.ajax({
        type: "GET",
        url: "display.php",
        dataType: "html",
        success: function(data){
            $("#data").html(data);            
        }
    });

    $.ajax({
        type: "GET",
        url: "observer.php",
        dataType: "html",
        success: function (primary){
            console.log(primary);
            let check = setInterval(function (){
                $.ajax({
                    type: "GET",
                    url: "observer.php",
                    dataType: "html",
                    success: function(trigger){
                        console.log(trigger);
                        if(primary != trigger){
                            clearInterval(check);
                            load();
                        }
                    }
                });
            }, 5000);     
        }
    });
});