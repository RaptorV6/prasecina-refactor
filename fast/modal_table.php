<div class="modal fade" id="edit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				
                <center>
                    <h4 class="modal-title" id="myModalLabel">Náhled tabulky</h4>
				                <span>Založil/a:</span>  <span id="target">loading</span>
							<span style="display:none"  id="target2">loading</span>
								
                </center>
				
				
            </div>
            
            <div class="modal-body">
                <div class="container-fluid">


                    <form id="editForm">
  
                        


                        <div class="col-sm-13 col-sm-offset-0">
                        <style>
    .rowdata{background-color: transparent;}
</style>

                            <table id="myTable" class="table table-bordered table-striped"
                            style="font-size: 20px;/* margin-top: 70px; *//* font-size: 20px; */text-align:center;margin-bottom: 51px;">
                                <thead>
                                    <th>Název</th>
                                    <th>MJ</th>
                                    <th>Množství</th>
                                    <th>Cena</th>
                                    <th>Celkem</th>
                                </thead>
                                <tbody id="tbody">

                                </tbody>


                                <tr style="position:absolute;bottom: 5px;left: 33%;background-color:transparent">
                                    <td><span><b>Suma:</b></span></td>
                                    <td style="color: white; background-color:#004b87;"><b><span
                                                class="total_price"></span></b></td>
                                    <td> <b>,-</b></td>
                                </tr>


                            </table>
							

                        </div>

                </div>
            </div>



            <script>
            $("#input2,#input1").keyup(function() {

                $('#output').val($('#input1').val() * $('#input2').val());

            });

            $("#input3,#input4").keyup(function() {

                $('#output2').val($('#input3').val() * $('#input4').val());

            });
			
			   function callback() {
            window.location.href='../print.php?id=' + document.getElementById("target2").innerText;
             }
			
            </script>
			


            <div class="modal-footer">
			
			                <a onclick="callback()" style="color: black;" type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-print"></span> Tisk</a>
			
                <button type="button" class="btn btn-default" data-dismiss="modal"><span
                        class="glyphicon glyphicon-remove"></span> Zavřít</button>
             

                    </form>
            </div>

        </div>
    </div>
</div>