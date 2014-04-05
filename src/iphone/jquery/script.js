// JavaScript Document

            $(document).ready(function(){
                fn_dar_eliminar();
                $("#frm_usu").validate();
            });			
      
            function fn_agregar(){
            	
            	str=document.form.filtro.value;
            	
                cadena = "<tr>";
                cadena = cadena + "<td>" + str + "</td>";
                 cadena = cadena + "<td><a class='elimina'><img src='../images/delete.png' /></a></td></tr>";
                $("#grilla tbody").append(cadena);
                /*
                    aqui puedes enviar un conunto de tados ajax para agregar al usuairo
                    $.post("agregar.php", {ide_usu: $("#valor_ide").val(), nom_usu: $("#valor_uno").val()});
                */
               // fn_dar_eliminar();
					         
            };
            
            function fn_dar_eliminar(){
                $("a.elimina").click(function(){
                    id = $(this).parents("tr").find("td").eq(0).html();
                    respuesta = confirm("Desea eliminar el usuario: " + id);
                    if (respuesta){
                        $(this).parents("tr").fadeOut("normal", function(){
                            $(this).remove();                          
                            /*
                                aqui puedes enviar un conjunto de datos por ajax
                                $.post("eliminar.php", {ide_usu: id})
                            */
                        })
                    }
                });
            };
