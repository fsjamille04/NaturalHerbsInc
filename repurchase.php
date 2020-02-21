 

<?php  include "header.php" ?> 

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <section class="content">
        <div class="row">
          <div class="col-12"> 
            <!-- /.card -->
            <div class="card" style="margin-top: 2rem; padding: 0 1vw; display: flex;  align-items: center; justify-content: center; flex-direction: column; padding: 5vh 0;">
              <div class="card-header">
                <h1>
                  Purchase Product
                </h1>
              </div>
              <!-- /.card-header -->
              <div class="card-body" style="">  
                 
                <form method="post">
                  <div class="form-group has-feedback">
                     <input type="text" required="" value="" name="userid" id="userid" class="form-control" placeholder="User ID">
                      <input type="hidden" required="" value="" name="mid" id="mid" class="form-control">
                   
                  </div> 
                  <div class="form-group has-feedback">
                     <input type="text" required="" value="" name="fn" id="fn" placeholder="Customer's name" class="form-control" readonly>
                   
                  </div> 
                  <div class="form-group has-feedback">
                    <select class="form-control select2 select2-hidden-accessible" id="product" data-select2-id="1" tabindex="-1" aria-hidden="true">
                      <option selected="selected" data-select2-id="3">Select Product</option> 
                      <?php 
                      $sql="SELECT * FROM product";
                      $result = mysqli_query($conn,$sql); 
                      while($row = mysqli_fetch_array($result)) { ?>
                        <option value="<?php echo $row['dis'] ?>" data-id="<?php echo $row['reg'] ?>" ><?php echo $row['pn']  ?></option>
                      <?php } ?> 
                    </select>
                    <input type="hidden"   value="" name="pids" id="pids" class="form-control">

                  </div>  
                  <div class="form-group has-feedback">
                    <input type="text" required="" value="" name="qty" id="qty" class="form-control" placeholder="Quantity">
                  
                  </div>
                  <div class="form-group has-feedback">
                    <input type="text" placeholder="SRP" required="" value="" name="srp" id="srp" class="form-control" readonly>
                    
                  </div>
                  <div class="form-group has-feedback">
                    <input type="text" placeholder="Amount" required="" value="" name="rb" id="rb" class="form-control" readonly> 
                  </div>
                  <div   class="form-group has-feedback"  id="date-to"  > 
                    <input type='text' class="form-control datetimepicker1" id="date"  name="date2" required  placeholder="2019-12-1"   autocomplete="off"/>   
                </div>
                   
                  <button type="submit" name="submits" class="btn btn-primary btn-block btn-flat submit" disabled>Purchase</button>
                   
                  <?php 

                  if( isset($_POST['submits']) ) {
                  
                    $get = mysqli_query ($conn, "SELECT * FROM member where uid='".$_POST['userid']."'");
                    while( $get_data = mysqli_fetch_assoc($get) ){
                      $res_get_data = $get_data;
                    }
                    $srp = $_POST['srp'];
                    $pids = $_POST['pids'];
                    $userid = $_POST['userid'];
                    $qty = $_POST['qty'];
                    $rb = $_POST['rb']; 

                    $x = 1; 
                    $gs = 0;  
                    $hid= $userid; 

                    $hdat = $_POST['date2']; 
                    $package = array(); 
  
                        $status = ($res_get_data['status_new'] =='3500')? '3500'  : '700' ;  

                    
                        $sql = $conn->query("INSERT INTO purchase (pid,id,price,dat,qty,amt,status_new,notify_payout)
                        VALUES ('$pids','$userid','$srp','$hdat','$qty','$rb','$status','notify')") ; 

                        $ids = array(); 
                        while($x <= 10) {
                          $query = "SELECT * FROM member where uid='$hid'";
                          $result = mysqli_query ($conn, $query);
                          while ($row = mysqli_fetch_assoc($result)) {
                            $ids[] =$row['uid'];
                            $package[] = $row['status_new'] ;  
                            $hid = $row['sid'];
                               
                          }  
                          $x++;                    
                        }  
                        if( $ids[0] != '' ){ 

                          $gs = ($package[0] =='3500')? ($srp * 0.05) * $qty  : ($srp * 0.03) * $qty; 
                          $sql = $conn->query("INSERT INTO rebates (amount,personal_purchase_package,personal,one,two,three,four,five,six,seven,eight,nine,id,dat,status_new,notify_payout) VALUES ('$rb','$status','$gs',0,0,0,0,0,0,0,0,0,". $ids[0] .",'$hdat','$status','notify')");   
                        }
                      
                        if( $ids[1] != '' ){ 
                          if( $package[1] =='3500' ){
                            if( $package[0] =='3500' ){ 
                              $gs = ($srp * 0.02) * $qty;
                            }else{ 
                              $gs = ($srp * 0.02) * $qty; 
                            }
                          } else {
                            $gs = ($srp * 0.02) * $qty; 
                          }
                          // $gs = ($package[1] =='3500')? ($srp * 0.02) * $qty  : ($srp * 0.02) * $qty;  
                          $sql = $conn->query("INSERT INTO rebates (personal_purchase_package,one,two,three,four,five,six,seven,eight,nine,id,dat,status_new,notify_payout)  VALUES ('$status','$gs','0','0','0','0','0','0','0','0',". $ids[1] .",'$hdat',". $package[1] .",'notify')"); 

                        } 
                        if( $ids[2] != '' ){ 
                          if( $package[2] =='3500' ){
                            if( $package[0] =='3500' ){ 
                              $gs = ($srp * 0.03) * $qty;
                            }else{ 
                              $gs = ($srp * 0.01) * $qty; 
                            }
                          } else {
                            $gs = ($srp * 0.01) * $qty; 
                          }
                          // $gs = ($package[2] =='3500')? ($srp * 0.03) * $qty  : ($srp * 0.01) * $qty;   
                          $sql = $conn->query("INSERT INTO rebates (personal_purchase_package,one,two,three,four,five,six,seven,eight,nine,id,dat,status_new,notify_payout)  VALUES ('$status','0','$gs','0','0','0','0','0','0','0',". $ids[2] .",'$hdat',". $package[2] .",'notify')"); 
                             
                        }
                        if( $ids[3] != '' ){
                          if( $package[3] =='3500' ){
                            if( $package[0] =='3500' ){ 
                              $gs = ($srp * 0.04) * $qty;
                            }else{ 
                              $gs = ($srp * 0.02) * $qty; 
                            }
                          } else {
                            $gs = ($srp * 0.02) * $qty; 
                          }
                          // $gs = ($package[3] =='3500')? ($srp * 0.04) * $qty  : ($srp * 0.02) * $qty; 
                          $sql =  $conn->query("INSERT INTO rebates (personal_purchase_package,one,two,three,four,five,six,seven,eight,nine,id,dat,status_new,notify_payout)  VALUES ('$status','0','0','$gs','0','0','0','0','0','0',". $ids[3] .",'$hdat',". $package[3] .",'notify')");  
                        } 
                        if( $ids[4] != '' ){
                          if( $package[4] =='3500' ){
                            if( $package[0] =='3500' ){ 
                              $gs = ($srp * 0.02) * $qty;
                            }else{ 
                              $gs = ($srp * 0.02) * $qty; 
                            }
                          } else {
                            $gs = ($srp * 0.02) * $qty; 
                          }
                          $gs = ($package[4] =='3500')? ($srp * 0.02) * $qty  : ($srp * 0.02) * $qty; 
                          $sql = $conn->query("INSERT INTO rebates (personal_purchase_package,one,two,three,four,five,six,seven,eight,nine,id,dat,status_new,notify_payout)
                              VALUES ('$status','0','0','0','$gs','0','0','0','0','0',". $ids[4] .",'$hdat',". $package[4] .",'notify')");   
                        } 
 
                        if( $package[0] == 3500 ){
                          if(  $ids[5] != ''  ){
                            $gs = ($package[5] =='3500')? ($srp * 0.01) * $qty  : 0; 
                            if( $gs != 0 ){ 
                              $sql =$conn->query( "INSERT INTO rebates (personal_purchase_package,one,two,three,four,five,six,seven,eight,nine,id,dat,status_new,notify_payout) VALUES ('$status','0','0','0','0','$gs','0','0','0','0',". $ids[5] .",'$hdat',". $package[5] .",'notify')" ); 
                            }
                          } 
                          if( $ids[6] != '' ){
                            $gs = ($package[6] =='3500')? ($srp * 0.01) * $qty  : 0;
                            if( $gs != 0 ){  
                              $sql = $conn->query("INSERT INTO rebates (personal_purchase_package,one,two,three,four,five,six,seven,eight,nine,id,dat,status_new,notify_payout) VALUES ('$status','0','0','0','0','0','$gs','0','0','0',". $ids[6] .",'$hdat',". $package[6] .",'notify')"); 
                            }
                          } 
                          if( $ids[7] != '' ){
                            $gs = ($package[7] =='3500')? ($srp * 0.01) * $qty  : 0;
                            if( $gs != 0 ){  
                              $sql = $conn->query("INSERT INTO rebates (personal_purchase_package,one,two,three,four,five,six,seven,eight,nine,id,dat,status_new,notify_payout) VALUES ('$status','0','0','0','0','0','0','$gs','0','0',". $ids[7] .",'$hdat',". $package[7] .",'notify')"); 
                            }
                          } 
                          if( $ids[8] != '' ){
                            $gs = ($package[8] =='3500')? ($srp * 0.01) * $qty  : 0;
                            if( $gs != 0 ){  
                              $sql = $conn->query("INSERT INTO rebates (personal_purchase_package,one,two,three,four,five,six,seven,eight,nine,id,dat,status_new,notify_payout) VALUES ('$status','0','0','0','0','0','0','0','$gs','0',". $ids[8] .",'$hdat',". $package[8] .",'notify')");  
                            }
                          } 
                          if( $ids[9] != '' ){
                            $gs = ($package[9] =='3500')? ($srp * 0.01) * $qty  : 0;
                            if( $gs != 0 ){  
                              $sql = $conn->query("INSERT INTO rebates (personal_purchase_package,one,two,three,four,five,six,seven,eight,nine,id,dat,status_new,notify_payout) VALUES ('$status','0','0','0','0','0','0','0','0','$gs',". $ids[9] .",'$hdat',". $package[9] .",'notify')");   
                            }
                          } 
                        } 
                    }    

                  ?>                       

                </form> 
        
            </div>
      <!-- /.card-body -->
          </div>
    <!-- /.card --> 
        </div> 
      </div>   
    </section> 
  </div>



 

 <!-- /.content-wrapper -->
 <?php 
include('script.php');
 ?>  

<script type="text/javascript">

$('#date').datepicker({
    autoclose: true,
    format: "yyyy-mm-dd", 
  });

  $('#date').on('change',function(){ 
    console.table(date);
    if( date == '' ) { 
      $('.submit').attr('disabled','disabled');
    } else {
      $('.submit').removeAttr('disabled');
    }
  });

  function isEmpty(obj) {
    for(var prop in obj) {
        if(obj.hasOwnProperty(prop))
            return false;
    }

    return true;
  }
  $(document).ready(function(){

    $('#qty').on('keyup',function(){
      var val = $(this).val();
      var srp = $('#srp').val(); 
      var total = val * srp;
      $('#rb').val(total);
    });

    $('select').on('change',function(){
      var val = $(this).val(); 
      $('#srp').val(val);
      $('#pids').val($('option:selected', this).attr('data-id'));
    
    });

    $('#userid').keyup(function(){
      var userid = $.trim($(this).val());
      $.ajax({
      type : 'POST',
      datatype: 'JSON',
      url: 'function.php',
      data:{
        action: 'get_name',
        userid : userid 
      }, 
      success: function(data){ 
        $('#fn').val(data );
        // var data = jQuery.parseJSON(data);
        //   $.each(data, function(index, value) { 
        //     $('#fn').val(data.fn);
        //     $('#mid').val(data.id);
        //   });
         
      }
    }); 
      console.log();
    });
  }); 
</script>
 <?php 
include('footer.php');
 ?> 
 
