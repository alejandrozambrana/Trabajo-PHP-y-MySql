/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$(document).ready(function () {

  
  //al clickar en añadir, llamo a añadir artista
  $('#añadir').on('click', anadir);
  
  function anadir(){
    //crea un cuadro de dialogo
    $("#cuadroAñadir").dialog({width: 500,
                                height:500,
                           }).css({"background": "#e6e6e6"});	
  }
      
});
