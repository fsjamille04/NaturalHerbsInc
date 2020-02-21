

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
                <div class="col-md-3"  id="date-from" >
                  <label>Invoice Date From : </label> 
                  <input type='text' class="form-control datetimepicker1" id="datetimepicker1" autocomplete="off" />
                  <input type="hidden" name="date1" id="newdate1">
                </div>
                <div class="col-md-3" id="date-to" style="display: none">
                  <label> To :</label>     
                  <input type='text' class="form-control datetimepicker1" id="datetimepicker2" autocomplete="off" />  
                  <input type="hidden" name="date2" id="newdate2">
                </div>
                <div class="col-md-3 ml-md-auto text-right" style="display: none" id="update-all-M"  ><button type="button" id="btnNoMaintenance" class="btn btn-danger"  data-toggle="modal" data-target="#modalNoMaintenance" >Update All NO MAINTENANCE</button></div>
              </div>
              <!-- /.card-header -->
              <div class="card-body"> 
                <!-- <form method="post">   -->
                  <table id="append_data" class="table table-bordered table-striped referral-table ">
                    <thead>
                      <tr>
                        <th>User ID</th>
                        <th>Fullname</th>   
                        <th>Date</th>
                        <th>Package</th>
                        <th>Personal Purchase Total</th>
                        <th>Payout</th> 
                      </tr>
                    </thead>

                    <tbody id="">


                    </tbody>   
                    <tfoot>
                      <tr>
                        <th>User ID</th>
                        <th>Fullname</th>   
                        <th>Date</th>
                        <th>Package</th>
                        <th>Personal Purchase Total</th>
                        <th>Payout</th> 
                      </tr>
                    </tfoot>   
                  </table> 
                <!-- </form> -->
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
                <button type="submit" class="btn btn-primary" name="payout-admin" id="payout-admin" onclick="printDiv()">Payout</button>   
                <button type="button" class="btn btn-danger" id="update-payout"   style="display: none" >Didn`t reach Maintenance Qouta - Update</button>
              </div> 
          </div>
        </div> 
      </div>

      <div class="modal fade hmodal-danger" id="modalNoMaintenance" tabindex="-1" role="dialog"  aria-hidden="true">       
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="color-line"></div>
            <div class="modal-header"> 
            </div> 
              <div class="modal-body"  id="bodyNoMaintenance" >  
              <table id="noMaintenance" class="table table-bordered table-striped referral-table .table-custom">
                    <thead>
                      <tr>
                        <th>User ID</th>
                        <th>Fullname</th>   
                        <th>Package</th>   
                        <th>Total Purchase</th>    
                        <th>Date</th>    
                      </tr>
                    </thead>

                    <tbody id="">
       
                    </tbody>   
                    <tfoot>
                      <tr>
                        <th>User ID</th>
                        <th>Fullname</th>  
                        <th>Package</th>  
                        <th>Total Purchase</th>     
                        <th>Date</th>    
                      </tr>
                    </tfoot>   
                  </table> 
              </div>
            <div class="modal-footer"> 
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-danger" name="AllnonMaintain" id="AllnonMaintain">Update ALL</button>   
            </div> 
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
        action: 'update_payout_rebates',
        reg : reg 
      },
      
      success: function(data){ 
      alert(data);
        $('#printsection').modal('toggle');
      }
    });

  };
  $('#loading-indicator').show();   
jQuery(document).ready(function(){  

  $('#btnNoMaintenance').on('click',function(){

    $('#noMaintenance tbody').empty();
    var dateFrom= $('#datetimepicker1').val();
    var dateTo= $('#datetimepicker2').val();
     
    $.ajax({
      type : 'POST', 
      url: 'function.php',
      data:{
        action: 'show_noMaintenance', 
        dateFrom : dateFrom,
        dateTo : dateTo,
      },
      success: function(data){   
        $('#noMaintenance tbody').append(data);
      },
error: function(error) {
    alert(error);
}
    });  

  });

  $('#AllnonMaintain').on('click',function(){ 
    var uid = []; 
    $("#noMaintenance .getId").each(function() {
      uid.push(this.id);
    });
    var dateFrom = $('#newdate1').val();
    var dateTo = $('#newdate2').val();
    $.ajax({
      type : 'POST', 
      url: 'function.php',
      data:{
        action: 'update_non_maintain', 
        uid : uid, 
        dateFrom : dateFrom, 
        dateTo : dateTo, 
      },
      success: function(data){   
        if( data =='success' ){
          location.reload(true); 
        }
      },
error: function(error) {
    alert(error);
}
    });  
  });

  $('.datetimepicker1').datepicker({
    autoclose: true,
    format: "yyyy-mm-dd", 
  });
  $('#PrintModal').html();
  $('#datetimepicker1').change(function(){
    var date1 = $('#datetimepicker1').val(); 
    $('#newdate1').val(date1); 
  })  
  $('#datetimepicker2').change(function(){
    var date2 = $('#datetimepicker2').val(); 
    $('#newdate2').val(date2);
  });  
    
 
  $('#append_data').on('click','.payoutlist',function(){ 
    // $('#PrintModal').append(); 
    var date1 = $('#newdate1').val();
    var date2 = $('#newdate2').val();
    var package = $(this).attr("data-package");
    var amount = $(this).attr("data-amount");
    console.log(package + amount);
    if( date1 == '' || date2 =='' ){
      alert('PLEASE PUT THE INVOICE DATE');
      $('#printSection').modal({ show: false});
    } else {
      $('#printsection').modal('show'); 
      $('#loading-indicator').show(); 

      if( package == 3500 ){
        if( amount >= 5000 ){
          $('#update-payout').css('display', 'none');
          $('#payout-admin').css('display', 'block'); 
        } else { 
          $('#update-payout').css('display', 'block');
          $('#payout-admin').css('display', 'none'); 
        }
      }
      if( package == 700 ){
        if( amount >= 2000 ){
          $('#update-payout').css('display', 'none');
          $('#payout-admin').css('display', 'block'); 
        } else { 
          $('#update-payout').css('display', 'block');
          $('#payout-admin').css('display', 'none'); 
        }
      }
    }
    var userid = $(this).attr('data-id');
      
    $.ajax({
      type : 'POST',
      datatype: 'JSON',
      url: 'function.php',
      data:{
        action: 'rebates_payout',
        userid : userid,
        date1 : date1,
        date2 : date2,
      },
      datatype:'text',
      success: function(data){
        $('#loading-indicator').hide();
        $('#PrintModal').html(data);  
      },
      complete: function (data) { 
        $('#update-payout').attr('data-reg', $('#reg').val());
      }
    });    
  });
  $('#update-payout').on('click',function(){
    var reg = JSON.stringify($(this).attr('data-reg'));  
    $.ajax({
      type : 'POST',
      datatype: 'JSON',
      url: 'function.php',
      destroy : true,
      data:{
        action: 'update_payout_rebates',
        reg : reg 
      },
      datatype:'text',
      success: function(data){
        alert(data); 
        $('#printsection').modal('toggle');
      }
    }); 
  });

  $('#datetimepicker1').on('change',function(){  
      if( $(this).val() == ''  ){
          $('#date-to').css('display', 'none');
      } else {
          $('#date-to').css('display', 'block'); 
      }
  });  
  $('#datetimepicker2').on('change',function(){  
      if( $(this).val() == ''  ){
          $('#update-all-M').css('display', 'none');
      } else {
          $('#update-all-M').css('display', 'block'); 
      }
  });  
  $('#datetimepicker2').on('change',function(){
    var dateFrom = $('#datetimepicker1').val();
    var dateTo = $(this).val(); 
    $('#append_data tbody').empty(); 
    $.ajax({
      type : 'POST',
      datatype: 'JSON',
      url: 'function.php',
      destroy : true,
      data:{
        action: 'show_data',
        dateFrom : dateFrom,
        dateTo : dateTo 
      },
      datatype:'text',
      success: function(data){ 
        $('#append_data tbody').append(data);
        /*DataTables instantiation.*/ 
      }
    }); 
  });
}); 
</script>
<?php 
include('footer.php');
 ?> 
 