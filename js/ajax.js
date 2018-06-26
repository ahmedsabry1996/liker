$(function(){

$("a.action").click(function(){
   
    let post = $(this).attr("post");
    let action = $(this).attr("action");
    
    let numOfFans =$(this).children("code").text();
    
    console.log(numOfFans,action);
    let url = `http://localhost/oop_apps/liker/code/Liker.php?action=${action}&post=${post}`;

    $.ajax({
        url:url,
        type:"Get",
        success:function(data){
        console.log(data);

        }, 
        fail:function(err){
            console.log(err)
        }
        
        
    })
    
});
});