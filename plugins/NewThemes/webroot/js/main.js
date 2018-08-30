/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$(document).ready(function(){
    $('ul.navbar-nav li.dropdown').hover(function () {        
        $(this).find('.dropdown-menu').stop(true, true).show('medium');        
        $(this).addClass('open');
    }, function () {        
        $(this).find('.dropdown-menu').stop(true, true).hide('medium');        
        $(this).removeClass('open');   
    });
    
//    $('ul.navbar-nav li.dropdown').mouseover(function(){
//        $(this).find('.dropdown-menu').stop(true, true).slideDown();
//         $(this).addClass('open');        
//    }).mouseout(function(){
//        $(this).find('.dropdown-menu').stop(true, true).slideUp();
//        $(this).removeClass('open');
//    })
       
 });