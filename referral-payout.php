

<?php
 include('header.php'); 
 ?>  
    <div class="content-wrapper">
      <section class="content">
        <div class="row">
          <div class="col-12"> 
            <!-- /.card -->
            <div class="card" style="margin-top: 2rem;    padding: 0 1vw;">
              <div class="card-header">
                <div class="col-md-3">
                  <label>Invoice Date From : </label> 
                  <input type='text' class="form-control datetimepicker1" id="datetimepicker1" autocomplete="off" />
                  <input type="hidden" name="date1" id="newdate1">
                </div>
                <div class="col-md-3">
                  <label> To :</label>     
                  <input type='text' class="form-control datetimepicker1" id="datetimepicker2" autocomplete="off" />  
                  <input type="hidden" name="date2" id="newdate2">
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body"> 
                <form method="post">  
                  <table id="table-append" class="table table-bordered table-striped referral-table ">
                    <thead>
                      <tr>
                        <th>User ID</th>
                        <th>Fullname</th>  
                        <th>Date</th>  
                        <th>Package</th>
                        <th>Payout</th> 
                      </tr>
                    </thead>

                    <tbody>


                   <?php
                   
                    $sql="SELECT * FROM indirect WHERE notify_payout != 'payout' GROUP by id ";
                    $result = mysqli_query($conn,$sql); 
                     while($row = mysqli_fetch_assoc($result)) { 
                      
                        ?>
                        <tr>
                          <td>
                            <?php echo $row['id'] ?>
                          </td>
                          <td>
                            <?php 
                            $sql="SELECT * FROM member Where uid = ".$row['id']." ";
                            $result1 = mysqli_query($conn,$sql); 
                             while($row1 = mysqli_fetch_assoc($result1)) {
                                echo $row1['fn'] . ' ' . $row1['mn'] . ' ' .$row1['ln'] ;
                             }
                             ?>
                          </td>
                          <td>
                            <?php echo $row['dat']?>
                          </td>
                          <td><b style="color: green">
                            <?php echo $row['status']?></b>
                          </td>
                          <td>
                            <input type="hidden" value="<?php echo $row['id']; ?>" name="payoutid" id="payoutid" >
                            <input type="button" name="payoutlist"  data-id="<?php echo $row['id']; ?>" class="payoutlist md-trigger btn btn-primary mrg-b-lg" value="Payout"> 

                          </td> 
                        </tr>
                       <?php     }   ?> 
                    </tbody>   
                    <tfoot>
                      <tr>
                        <th>User ID</th>
                        <th>Fullname</th>  
                        <th>Date</th>
                        <th>Package</th>
                        <th>Payout</th> 
                      </tr>
                    </tfoot>   
                  </table> 
                </form>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
        <!-- /.col -->
        </div>   
      </section>
 
      <div class="modal fade hmodal-danger" id="printsection" tabindex="-1" role="dialog"  aria-hidden="true">         
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="color-line"></div>
            <div class="modal-header"> </div>  
              <div class="modal-body"  id="PrintModal" >  
              </div>
              <div class="modal-footer"> 
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" name="payout_admin" id="payout_admin" onclick="printDiv()">Payout</button>   
              </div> 
          </div>
        </div> 
      </div>

      <div class="modal fade hmodal-danger" id="printAdminSection" tabindex="-1" role="dialog"  aria-hidden="true">       
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="color-line"></div>
            <div class="modal-header"> 
            </div> 
              <div class="modal-body"  id="printAdminSectionModal" >  </div>
            <div class="modal-footer"> 
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary" name="payout_admin_2" id="payout_admin_2">Payout</button>   
            </div>
           <!--  </form> -->
          </div>
        </div> 
      </div>
    </div>

<?php 
include('script.php');
 ?>  
  <script> 
  function printDiv() {
    window.print();
  }
  window.onafterprint = function() {
    var reg = JSON.stringify($('#reg').val());  
  
    $.ajax({
      type : 'POST',
      url: 'function.php',
      datatype:'JSON',
      data:{
        action: 'update_payout_referral',
        reg : reg 
      },
      
      success: function(data){
         console.log(data);
        $('#printAdminSectionModal').html(data);
        //location.reload();
      alert(data);
        $('#printsection').modal('toggle');
      }
    });

  };
  $('#loading-indicator').show();   
jQuery(document).ready(function(){  
  $('.datetimepicker1').datepicker();
  $('#PrintModal').html();
  $('#datetimepicker1').change(function(){
    var date1 = $('#datetimepicker1').val(); 
    $('#newdate1').val(date1); 
  })  
  $('#datetimepicker2').change(function(){
    var date2 = $('#datetimepicker2').val(); 
    $('#newdate2').val(date2);
  });  
   
  
  $('#table-append').on('click','.payoutlist',function(){ 
    // $('#PrintModal').append(); 

    var date1 = $('#newdate1').val();
    var date2 = $('#newdate2').val();

    if( date1 == '' || date2 =='' ){
      alert('PLEASE PUT THE INVOICE DATE');
      $('#printSection').modal({ show: false});
    } else {
      $('#printsection').modal('show'); 
      $('#loading-indicator').show();  
    }

    var userid = $(this).attr('data-id');
      
    $.ajax({
      type : 'POST',
      datatype: 'JSON',
      url: 'function.php',
      data:{
        action: 'referral_payout',
        userid : userid,
        date1 : date1,
        date2 : date2,
      },
      datatype:'text',
      success: function(data){
        $('#loading-indicator').hide();
        $('#PrintModal').html(data); 
   
      }
    });    
  });

}); 
</script>
<?php 
include('footer.php');
 ?> 
 