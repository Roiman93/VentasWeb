function hide_o_show(){$(".ui.sidebar").sidebar("toggle")}function myFunction(e){e.matches?($("#menu_tablet").hide(),$("#menu_mobil").show(),$("#div_h").hide()):($("#menu_tablet").show(),$("#div_h").show(),$("#menu_mobil").hide())}function validateForm(e){var s=$("#"+e+" input, #"+e+" select, #"+e+" textarea");$("#"+e+" .field").removeClass("error"),$("#"+e+" .ui.visible.attached.message").remove();var a=!1,r=!0,i={};return s.each((function(){var e=$(this),s=(e.prev("label").text().replace(":",""),e.val());switch(e.data("type")){case"text":const d=/^[\p{L}\s]+$/u;s&&d.test(s)||!e.prop("required")||e.val()?!e.prop("required")||s&&d.test(s)?(e.closest(".field").removeClass("error"),i[e.attr("name")]=e.prop("required")&&!e.val()?null:e.val()):(e.closest(".field").addClass("error"),e.after('<div class="ui visible attached message"><i class="close icon"></i><div class="header">Solo se permite texto</div>'),r=!1):(e.closest(".field").addClass("error"),e.after('<div class="ui visible attached message"><i class="close icon"></i><div class="header">El campo es requerido y solo se permite texto</div>'),r=!1);break;case"textarea":const n=/^[a-zA-ZáéíóúÁÉÍÓÚñÑüÜ]+(\s[a-zA-ZáéíóúÁÉÍÓÚñÑüÜ]+)*$/,v=(e.find("textarea"),e.val().trim());s&&n.test(v)||!e.prop("required")||v?!e.prop("required")||v&&n.test(v)?(e.closest(".field").removeClass("error"),i[e.attr("name")]=e.prop("required")&&!v?null:v):(e.closest(".field").addClass("error"),e.after('<div class="ui visible attached message"><i class="close icon"></i><div class="header">Solo se  2 permite texto</div>'),r=!1):(e.closest(".field").addClass("error"),e.after('<div class="ui visible attached message"><i class="close icon"></i><div class="header">El campo es requerido  2y solo se permite texto</div>'),r=!1);break;case"address":const u=/^[a-zA-Z0-9\s.#-]+$/;s&&u.test(s)||!e.prop("required")||e.val()?s&&u.test(s)?e.prop("required")&&!e.val()?(e.closest(".field").addClass("error"),e.after('<div class="ui visible attached message"><i class="close icon"></i><div class="header">Este campo es requerido</div>'),r=!1):(e.closest(".field").removeClass("error"),i[e.attr("name")]=e.val()):(e.closest(".field").addClass("error"),e.after('<div class="ui visible attached message"><i class="close icon"></i><div class="header">Solo se permiten letras, números y los siguientes caracteres especiales: . #-</div>'),r=!1):(e.closest(".field").addClass("error"),e.after('<div class="ui visible attached message"><i class="close icon"></i><div class="header">El campo es requerido y solo se permiten letras, números y los siguientes caracteres especiales: . #-</div>'),r=!1);break;case"select":!e.prop("required")||e.val()||e.prop("disabled")?(e.closest(".field").removeClass("error"),i[e.attr("name")]=e.prop("required")&&!e.val()?null:e.val()):(e.closest(".field").addClass("error"),e.after('<div class="ui visible attached message"><i class="close icon"></i><div class="header">Este campo es obligatorio</div>'),r=!1);break;case"checkbox":var l=$("input[type='radio'][name='"+e.attr("name")+"']"),o=1===l.filter(":checked").length;if(e.prop("required")&&!o)e.closest(".field").addClass("error"),a||(e.last().parent().after('<div class="ui visible attached message"><i class="close icon"></i><div class="header">Este campo es obligatorio</div>'),a=!0),r=!1;else{e.closest(".field").removeClass("error");var t=l.filter(":checked").val();i[e.attr("name")]=e.prop("required")&&!t?null:t}break;case"range":e.prop("required")&&0==e.val()&&!e.prop("disabled")?(e.closest(".field").addClass("error"),e.after('<div class="ui visible attached message"><i class="close icon"></i><div class="header">Este campo es obligatorio </div>'),r=!1):(e.closest(".field").removeClass("error"),i[e.attr("name")]=e.prop("required")&&!e.val()?null:e.val());break;case"radio":const p=e.closest(".field").find('input[type="radio"]');!e.prop("required")||p.is(":checked")||e.prop("disabled")?(e.closest(".field").removeClass("error"),i[e.attr("name")]=e.prop("required")&&!e.val()?null:e.val()):(e.closest(".field").addClass("error"),e.after('<div class="ui visible attached message"><i class="close icon"></i><div class="header">Este campo es obligatorio</div>'),r=!1);break;case"email":if(e.prop("required")&&!e.val())e.closest(".field").addClass("error"),e.after('<div class="ui visible attached message"><i class="close icon"></i><div class="header">Este campo es obligatorio</div>'),r=!1;else{const a=/^[^\s@]+@[^\s@]+\.[^\s@]+$/;s&&a.test(s)?(e.closest(".field").removeClass("error"),i[e.attr("name")]=e.prop("required")&&!e.val()?null:e.val()):(e.closest(".field").addClass("error"),e.after('<div class="ui visible attached message"><i class="close icon"></i><div class="header">Por favor ingrese un correo electrónico válido</div>'),r=!1)}break;case"number":if(e.prop("required"))if(e.val()){/^\d+$/.test(s)?(e.closest(".field").removeClass("error"),i[e.attr("name")]=e.prop("required")&&!e.val()?null:e.val()):(e.closest(".field").addClass("error"),e.after('<div class="ui visible attached message"><i class="close icon"></i><div class="header">Por favor ingrese un número válido</div>'),r=!1)}else e.closest(".field").addClass("error"),e.after('<div class="ui visible attached message"><i class="close icon"></i><div class="header">Este campo es obligatorio</div>'),r=!1;else e.closest(".field").removeClass("error");break;case"tel":if(e.prop("required")&&!e.val())e.closest(".field").addClass("error"),e.after('<div class="ui visible attached message"><i class="close icon"></i><div class="header">Este campo es obligatorio</div>'),r=!1;else{const a=/^\d{10}$/;s&&a.test(s)?(e.closest(".field").removeClass("error"),i[e.attr("name")]=e.prop("required")&&!e.val()?null:e.val()):(e.closest(".field").addClass("error"),e.after('<div class="ui visible attached message"><i class="close icon"></i><div class="header">Por favor ingrese un número de teléfono válido</div>'),r=!1)}break;case"date":if(e.prop("required")&&!e.val())e.closest(".field").addClass("error"),e.after('<div class="ui visible attached message"><i class="close icon"></i><div class="header">Este campo es obligatorio</div>'),r=!1;else{const a=/^\d{4}-\d{2}-\d{2}$/;s&&a.test(s)?(e.closest(".field").removeClass("error"),i[e.attr("name")]=e.prop("required")&&!e.val()?null:e.val()):(e.closest(".field").addClass("error"),e.after('<div class="ui visible attached message"><i class="close icon"></i><div class="header">Por favor ingrese una fecha válida (formato: AAAA-MM-DD)</div>'),r=!1)}break;case"time":if($hora=/^([01]?[0-9]|2[0-3]):[0-5][0-9]$/.test(e.val()),!e.prop("required")||e.val()||e.prop("disabled")){var c=Date.parse("01/01/1970 "+e.val());isNaN(c)?(e.closest(".field").addClass("error"),e.after('<div class="ui visible attached message"><i class="close icon"></i><div class="header">La hora seleccionada no es válida</div>'),r=!1):(e.closest(".field").removeClass("error"),i[e.attr("name")]=e.prop("required")&&!e.val()?null:e.val())}else e.closest(".field").addClass("error"),e.after('<div class="ui visible attached message"><i class="close icon"></i><div class="header">Este campo es obligatorio </div>'),r=!1}})),$(".message .close").on("click",(function(){$(this).closest(".message").transition("fade")})),1==r?i:r}function obtain(e,s){var a=$("#"+e+" input, #"+e+" select, #"+e+" textarea");if(null==s){var r=[];return a.each((function(){var e=$(this);e.val();const s=e.attr("name").replace(/\[\]/g,"");switch(e.data("type")){case"text":case"address":case"range":case"radio":case"email":case"date":case"time":case"number":case"tel":case"select":r[s]=e.val()?e.val():null;break;case"checkbox":var a=$("input[type='checkbox'][name='"+e.attr("name")+"']"),i=a.is(":checked");if(e.prop("required")&&!i)e.closest(".field").addClass("error"),messageShown||(e.after('<div class="ui visible attached message"><i class="close icon"></i><div class="header">Este campo es obligatorio</div>'),messageShown=!0),isValid=!1;else{e.closest(".field").removeClass("error");var l=[];a.each((function(){this.checked&&l.push($(this).val())})),r[e.attr("name")]=l}}})),r}a.each((function(){var e=$(this);const a=e.attr("name").replace(/\[\]/g,"");if(s.hasOwnProperty(a)){const r=s[a];switch(e.data("type")){case"radio":case"email":case"number":case"tel":case"time":case"range":case"address":case"text":e.val(r);break;case"textarea":e.val(r).trim();break;case"select":console.log(r),e.find(`option[value="${r}"]`).prop("selected",!0);break;case"checkbox":const i=$("input[type='radio'][name='"+e.attr("name")+"']");Array.isArray(s[a])?s[a].forEach((function(e){i.filter("[value='"+e+"']").prop("checked",!0)})):i.filter("[value='"+s[a]+"']").prop("checked",!0)}}else console.log(`La clave ${a} no existe en el objeto`)}))}function cleanForm(e){var s=$("#"+e+" input, #"+e+" select"),a=!1;if(s.each((function(){var e=$(this);switch(e.data("type")){case"radio":case"email":case"number":case"tel":case"time":case"range":case"address":case"text":case"select":if(e.prop("readonly")||e.prop("disabled"))break;if("SELECT"==e.prop("tagName")){var s=e.children().first();""!=s.val()?(s.prop("selected",!0),a=!0):(e.val(""),a=!0)}else e.val(""),a=!0;break;case"checkbox":e.prop("checked")&&(e.prop("checked",!1),a=!0)}e.prop("required")&&e.closest(".field").hasClass("error")&&(e.closest(".field").removeClass("error"),e.siblings(".visible.message").remove())})),a)return!0}function validateTable(e){var s=document.getElementById(e);if(!s)return console.error("La tabla con el id "+e+" no existe."),!1;var a=s.rows;if(a.length<=1)return console.error("La tabla no tiene filas para validar."),!1;for(var r=a[0].cells.length,i=1;i<a.length;i++)if(a[i].cells.length!==r)return console.error("La fila "+(i+1)+" tiene una cantidad de celdas diferente a la primera fila."),!1;for(i=1;i<a.length;i++)for(var l=0;l<r;l++){var o=a[i].cells[l],t=o.querySelector("input, select, textarea");if(t&&""===t.value)return o.classList.add("error"),o.classList.remove("success"),console.error("La celda ("+(i+1)+", "+(l+1)+") está vacía o no tiene un valor válido."),!1;t&&(o.classList.add("success"),o.classList.remove("error"))}return!0}function valideKey(e){var s=e.which?e.which:e.keyCode;return 8==s||s>=48&&s<=57}function lettersOnly(e){var s=(e=e||event).charCode?e.charCode:e.keyCode?e.keyCode:e.which?e.which:0;return!(s>31&&(s<65||s>90)&&(s<97||s>122))}function letters_espace_Only(e){var s=(e=e||event).charCode?e.charCode:e.keyCode?e.keyCode:e.which?e.which:0;return 32==s||!(s<65||s>90)||!(s<97||s>122)}function isEmpty(e){return!e||0===e.length}function isKeyExists(e,s){return null!=e[s]}function clearProductInfo(e){e.forEach(e=>{let s=$("#"+e.id);"val"===e.tipo?void 0!==e.value&&s.val(e.value):void 0!==e.value&&s.html(e.value),void 0!==e.disabled&&s.prop("disabled",e.disabled),void 0!==e.action&&s[e.action](),void 0!==e.visibility&&s.css("visibility",e.visibility),void 0!==e.focus&&s.focus()})}function generarPDF(e,s){var a=parseInt(window.screen.width/2-500),r=parseInt(window.screen.height/2-400);$url="factura/generaFactura.php?cl="+e+"&f="+s,window.open($url,"factura","left"+a+",top="+r+",height=800,width=1000,scrolbar=si,location=no,resizable=si,menubar=no")}window.addEventListener("load",(function(){var e=window.matchMedia("(max-width: 768px)");myFunction(e),e.addListener(myFunction),$(".message .close").on("click",(function(){$(this).closest(".message").transition("fade")}))}));