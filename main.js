
function setCookie(){

    var cname = document.getElementsByClassName("username")[0].value; 
    document.cookie = "name=" +cname; 

}


function check_Cookie(){
    var temp = document.cookie.split(";");
    document.getElementsByClassName("username")[0].value = temp;
    var arr = temp[0].split("="); 
    var temp1; 
    if(arr[0]=="name"){
        temp1 = arr[1]; 
    }else{
        temp1 = ""; 
    }
    document.getElementsByClassName("username")[0].value = temp1;
}



(function(){
    setInterval(function(){
        
        do_ajax_stuff("");

    },10000)
})();




function process_form(){
    {

        
        var query_string=""; 
        var temp = "";
        
        var x = document.getElementsByName("event");
        var length = x.length; 
        for(var i = 0; i<length;i++){
            if(x[i].checked){
                temp=x[i].value; 
            }
        }
        query_string+=temp;
        query_string+=";"; 

        
        
        var y = document.getElementsByName("date");
        length = y.length; 
        for(var i = 0; i<length;i++){
            if(y[i].checked){
                temp=y[i].value; 
            }
        }

        if(temp=="specific"){
            temp = document.getElementById("dateS").value;
        }

        query_string+=temp;
        query_string+=";"; 

        
        var z = document.getElementById("location").value; 
        query_string+=z; 
        query_string+=";";

        var a = document.getElementById("event_title").value;
        query_string+=a; 

        //document.getElementsByClassName("test")[0].innerHTML = query_string;

        do_ajax_stuff(query_string);
    }
}

function do_ajax_stuff(query_string) 
{

    //query_string = query_string.split("=")[1];

    var xhr = new XMLHttpRequest();

    xhr.onreadystatechange = function () 
    {

        if (xhr.readyState == 4 && xhr.status == 200) 
            {
                var result = xhr.responseText;
                display_result(result); 
                
                    
                    
            }
        }   

        xhr.open("POST", "http://www.pic.ucla.edu/~kuohujun/invitation/count.php?event=" + query_string, true);  // you will need to edit this line for your pic account
        xhr.send(null);
}



function display_result(result){
            
            //document.getElementsByClassName("test")[0].innerHTML = result;

            var temp = result.split("hash%%!");

            var cate = document.getElementsByClassName("display"); 




            var message = document.getElementsByClassName("info"); 
            message[0].innerHTML = "Sent by: <br/>" + temp[0]; 
            message[1].innerHTML = "Type: <br/>" + temp[1]; 
            message[2].innerHTML = "Effective until: <br/>" + temp[2];  
            message[3].innerHTML = "Location: <br/>" + temp[3]; 
            message[4].innerHTML = "Event detail: <br/>" +temp[4]; 

            document.getElementById("update_success").innerHTML=temp[5]; 
}









