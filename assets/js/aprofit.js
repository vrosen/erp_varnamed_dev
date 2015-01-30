/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$(function(){
    $('input[name="settings"]:radio').change( function(){
            if($("#r1").is(':checked'))
            {
                $(".agevro").css('display', 'none');
                $(".agpercent").css('display', 'block');
                $(".agve").css('display', 'none');
            }
            else if($("#r2").is(':checked'))
            {
                $(".agevro").css('display', 'block');
                $(".agpercent").css('display', 'none');
                $(".agve").css('display', 'none');
            }
            else if($("#r3").is(':checked'))
            {
                $(".agevro").css('display', 'none');
                $(".agpercent").css('display', 'none');
                $(".agve").css('display', 'block');
            }
 });
});

