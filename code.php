 

 <?php include "header.php"  ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <section class="content">
        <div class="row">
          <div class="col-12"> 
            <!-- /.card -->
            <div class="card" style="margin-top: 2rem;    padding: 0 1vw;">
              <div class="card-header">
                <h2>
                  List of Members 
                </h2>
              </div>
              <!-- /.card-header -->
              <div class="card-body">  
                  <form method="post"  >    
                      <div class="row">
                        <div class="col-lg-12 col-xs-12">       
                          <button type="button col-md-6 btn-codemodal" class="btn btn-success"
                              data-toggle="modal" data-target="#myModal10" >
                              Add Entry Codes
                          </button>
                          <select class="col-md-6 form-control" style="margin : 10px 0; border: 1px solid black" id="select-package">
                            <option>Select Package</option>
                            <option value="3500">3500</option>
                            <option value="700">700</option>
                          </select>
                        </div>   
                        <div class="col-lg-12 col-xs-12">
                          <div class="box">
                            <div class="box-header">
                              <div class="box-body">         
                                <div class="panel-body"> 
                                            
                                  <table id="append_data" class="table table-bordered table-striped">
                                    <thead>
                                    <tr>
                                        <th>NUMBER</th>
                                        <th>USER ID</th>
                                        <th>USER PIN</th>
                                        <th>DATE</th> 
                                    </tr>
                                  </thead> 
                                          <tbody > 
                                           </tbody>    
                                  </table>

                                </div>       
                              </div>
                            </div> 
                          </div>
                        </div>

                     
                      </div> 
                      <div class="modal fade hmodal-danger" id="myModal10" tabindex="-1" role="dialog"  aria-hidden="true">
                                
                        <div class="modal-dialog">
                          <div class="modal-content">
                              <div class="color-line"></div>
                              <div class="modal-header">
                                  <h4 class="modal-title">Natural Herbs Security code</h4> 
                              </div>  
                              <div class="modal-body"> 
                                <select class="form-control" name="select-code" id="select-code">
                                  <option value=""> Select type of code to generate</option>
                                  <option value="3500">3500</option> 
                                  <option value="700">700</option>
                                </select>   
                                <label>How many codes to generate?</label>
                                  <input type="text" placeholder="Enter Amount" required="" value="" name="amt" id="amt" class="form-control amt">
                                </div>   
                              <div class="modal-footer">
                                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                  <button type="button" class="btn btn-primary save" name="save" id="save" value="" >Create</button>
                              </div>
                          </div>
                        </div>
                      </div> 
 
                  </form>
                </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
        <!-- /.col -->
        </div>   
    </section>
  </div>  
 <?php 
include('script.php');
 ?>  


<script>

  jQuery(document).ready(function($){ 
 
    $('#select-package').on('change', function(){
      var val = $(this).val();
      $('#append_data tbody').empty();
      $.ajax({
        url: "function.php",
        type: "POST",
        data:{
          action: "select_package",
          val:val
        },
        success:function(data){
          $('#append_data tbody').append(data); 
        }
      });
    });

    $('#select-code').on("change",function(){
      var val = $(this).val();
      $('#save').val(val);
    });
    $('#save').click( function(){
      if($('#select-code').val()!==""){ 
        var stat = $('#save').val();
        var amt = $('#amt').val();
        if(amt==''){
            alert('Enter amount');
        }else{  
          $.ajax({
            url: "function.php",
            type: "POST",
            data: { 
              action: "savecode",
              amt: amt,
              stat : stat 
            },
            success: function(data) {  
              location.reload(); 
            }
          });
        }  
      }else{
        alert('Select types of Codes ');
      } 
    });
          
   });
  
</script> 
 <?php 
include('footer.php');
 ?> 
 