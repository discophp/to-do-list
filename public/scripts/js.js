
$(function(){
    $(window).bind('resize',flex);
    flex();
});


//This handles SEO pages
function flex(){
    if($('body.disco-seo').length)
        $('#body').css('margin-top',$('#header').height());
}//flex

var user = {};
var todo = {};
todo.user = {};

todo.listen = function(){
    $('body').on('click','.entry-action',function(){
        $('.entry-action').removeClass('hide');
        $('.entry-action').next().addClass('hide');
        $(this).addClass('hide');
        $(this).next().toggleClass('hide');
    });
}()//listen

todo.user.totalCountBump = function(i){
    var t = parseInt($('#total').text());
    t = t + i;
    $('#total').text(t);
}//

todo.user.toDoCountBump = function(i){
    var t = parseInt($('#count').text());
    t = t + i;
    t = (t>0) ? t : 0;
    $('#count').text(t);
}//


todo.user.createToDo = function(){
    var $ta = $('textarea[name="create-to-do"]');
    $('body').on('click','.add-to-do',function(){
        var data = {'create-to-do':$ta.val()};
        $.ajax({
            url:'/create',
            type:'POST',
            data:data,
            success:function(d){
               if(d){
                   todo.user.totalCountBump(1);
                   todo.user.toDoCountBump(1);
                   $('.to-do-list-container').prepend(d); 
                   $ta.val('');
               }//if
            }//success
        });
    });
}

todo.user.finishedToDo = function(){
    $('body').on('click','.button.finished',function(){
        var data = {'finished-to-do':$(this).parent().parent().attr('data-id')},
            that = this;
        $.ajax({
            url:'/finished',
            data:data,
            type:'PUT',
            success:function(d){
                todo.user.toDoCountBump(-1);

                $(that).parent().parent().find('.time').append("<p>finished: just now</p>");
                $(that).parent().parent().find('.do').eq(0).removeClass('red').addClass('green');
                $(that).remove();
            }//success
        });
    });
}//finishToDo

todo.user.deleteToDo = function(){
    $('body').on('click','.button.delete',function(){
        var data = {'delete-to-do':$(this).parent().parent().attr('data-id')},
            that = this;
        $.ajax({
            url:'/delete/'+data['delete-to-do'],
            type:'DELETE',
            success:function(d){
                todo.user.totalCountBump(-1);
                if($(that).prev().hasClass('finished')){
                    todo.user.toDoCountBump(-1);
                }//if

                $(that).parent().parent().remove();    
            }//success
        });
    });
}//deleteToDo

user.signup = function(){


    $('body').on('click','.button.signup',function(){
        $('.data-alert').remove();
        var that = this;
        $.ajax({
            url:'/signup',
            data:$(this).parent().serialize(),
            type:'POST',
            success:function(data){
                if(data==-1){
                    $(that).after('<div data-alert class="alert-box alert">That email is already in use<a class="close">&times;</a></div>');
                }//elif
                else if(data==0){
                    shake(that);
                }//elif
                else if(data){
                    window.location.href = window.location.href;
                }//if
            }//success
        });
    });
}//signup

user.signin = function(){

    $('input').on('keypress',function(event){
        if(event.keyCode == 13){
            $(this).parent().parent().find('.button').eq(0).click();
        }//if
    });

    $('body').on('click','.button.signin',function(){
        var that = this;
        $.ajax({
            url:'/signin',
            data:$(this).parent().serialize(),
            type:'POST',
            success:function(data){
                if(data==1){
                    window.location.href = window.location.href;
                }//if
                else {
                    shake(that);
                }//el
            }//success
        });
    });
}//signup





//**************************************************
//**************************************************
//      Disco PHP Framework default js functions
//**************************************************
//**************************************************
function shake(div){
    var interval = 100;
    var distance = 10;
    var times = 4;

    $(div).css('position','relative');

    for(var iter=0;iter<(times+1);iter++){
        $(div).animate({ left: ((iter%2==0 ? distance : distance*-1))},interval);
    }//for

    $(div).animate({ left: 0},interval);

}//shake 



// Print a string with a format like PHP
// use like:
//
//      var string = '{0} string {1}';
//      string = string.format('this','is cool');
//
// First, checks if it isn't implemented yet.
if (!String.prototype.format) {
    String.prototype.format = function() {
        var args = arguments;
        return this.replace(/{(\d+)}/g, function(match, number) { 
            return typeof args[number] != 'undefined' ? args[number] : match ;
        });
    };
}

//Replace all occurances of substring in string
String.prototype.replaceAll = function(find,replace){
    var str = this;
    return str.split(find).join(replace);
};


// Array Remove - By John Resig (MIT Licensed)
 Array.prototype.remove = function(from, to) {
   var rest = this.slice((to || from) + 1 || this.length);
    this.length = from < 0 ? this.length + from : from;
    return this.push.apply(this, rest);
};

//set the title of the page
function setTitle(title){
    $('title').text(title);
}

//shake an element
function shake(div){
    var interval = 100;
    var distance = 10;
    var times = 4;
    $(div).css('position','relative');
    for(var iter=0;iter<(times+1);iter++){
        $(div).animate({ left: ((iter%2==0 ? distance : distance*-1))},interval);
    }//for
    $(div).animate({ left: 0},interval);
}//shake 

//get a cookie by name
function getCookie(name){
    var regexp = new RegExp("(?:^" + name + "|;\\s*"+ name + ")=(.*?)(?:;|$)", "g");
    var result = regexp.exec(document.cookie);
    return (result === null) ? null : decodeURIComponent(result[1]);
}//getCookie

//delete a cookie
function deleteCookie(name,path,domain) {
    if(getCookie(name)){
        createCookie(name,"",-1,path,domain);
    }//if
}//deleteCookie

//create a cookie
function createCookie(name, value, expires, path, domain) {
    var cookie = name + "=" + escape(value) + ";";
    if (expires) {
        if(expires instanceof Date) {
            if (isNaN(expires.getTime())){
                expires = new Date();
            }//if
        }//if
        else{
            expires = new Date(new Date().getTime() + parseInt(expires) * 1000 * 60 * 60 * 24);
        }//el

        cookie += "expires=" + expires.toGMTString() + ";";
    }//if

    if (path)
        cookie += "path=" + path + ";";
    if (domain)
        cookie += "domain=" + domain + ";";
    document.cookie = cookie;
}//createCookie

