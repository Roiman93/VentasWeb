async function seach(){$filter=obtain("filter_cat_proced");const t=new FormData;for(let a in $filter)t.append(a,$filter[a]);try{const a="http://ventasweb.local/api/sh_cat_proced",e=await fetch(a,{method:"POST",body:t});data=await e.json(),displayResult(data)}catch(t){}}async function updateRecord(t){const a=new FormData;a.append("id",t);try{const t="http://ventasweb.local/get_cat_proced",e=await fetch(t,{method:"POST",body:a});data=await e.json(),$("#modal_edit").modal("show"),obtain("modal_edit",data.resultado)}catch(t){}}async function update(){if(result=validateForm("modal_edit"),0!=result){const t=new FormData;for(let a in result)t.append(a,result[a]);try{const a="http://ventasweb.local/api/cat_proced_up",e=await fetch(a,{method:"POST",body:t});data=await e.json(),!0!==t.rsp?(swal("Registro Actualizado",{icon:"success"}),cleanForm("modal_edit"),$("#modal_edit").modal("hide"),displayResult(data)):(swal("Error",{icon:"warning"}),displayResult(data))}catch(t){}}}async function add(){if(result=validateForm("modal_add"),0!=result){const t=new FormData;for(let a in result)t.append(a,result[a]);try{const a="http://ventasweb.local/api/cat_proced_ad",e=await fetch(a,{method:"POST",body:t});data=await e.json(),!0!==t.rsp?(swal("Registro Almacenado",{icon:"success"}),cleanForm("modal_add"),$("#modal_add").modal("hide"),displayResult(data)):(swal("Error",{icon:"warning"}),displayResult(data))}catch(t){}}}async function deleteCustomer(t){const a=new FormData;a.append("id",t);try{const t="http://ventasweb.local/api/cat_proced_dl",e=await fetch(t,{method:"POST",body:a});data=await e.json(),displayResult(data)}catch(t){}}async function deleteRecord(t){swal({title:"¿Seguro que deseas eliminar el Registro?",text:"No podrás deshacer este paso...",icon:"warning",buttons:!0,dangerMode:!0}).then(a=>{a?deleteCustomer(t):swal("!No se Realizo Ningun Cambio!")})}function displayResult(t){t.error?swal({title:"Error",text:t.error+"",icon:"warning"}).then((function(){})):t.resultado?$("#registros").html(t.resultado):(console.log("no han resultados"),$("#registros").html("-"))}function displayResultfind(t){t.error?swal({title:"Error",text:t.error,icon:"warning"}).then((function(){})):t.resultado?($("#modal_edit").modal("show"),$("#registros").html(t.resultado)):(console.log("no han resultados"),$("#registros").html("-"))}window.addEventListener("load",(function(){seach()})),$("#search").click((function(t){seach()})),$("#add").click((function(t){$("#modal_add").modal("show")})),$("#add_record").click((function(t){add()})),$("#update").click((function(t){update()})),$("#recharge").click((function(t){location.reload(!0)}));var txt_name=document.getElementById("nombre");txt_name.onkeyup=function(t){13==t.keyCode&&seach()};var txt_last_name=document.getElementById("descripcion");txt_last_name.onkeyup=function(t){13==t.keyCode&&seach()};