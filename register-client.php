

<?php
 include('header.php'); 
 ?>  
    <div class="content-wrapper">
      <section class="content">
        <div class="row">
          <div class="col-12"> 
            <!-- /.card -->
            <div class="card" style="margin-top: 2rem; text-align: center; padding:5vh 0 ;">
              <div class="card-header">
                <h1>Register User</h1>
              </div>
              <!-- /.card-header -->
              <div class="card-body col-md-4 offset-md-4"> 
                <form method="post" id="register_form">
                  <div class="form-group  has-feedback">
                    <select class="upgrade-or-add-user form-control" required="" name="upgrade-or-add-user">
                      <option value="">SELECT UPGRADE or ADD NEW USER</option>
                      <option value="upgrade">Upgrade Account</option>
                      <option value="add">Add NEW USER</option>
                    </select>
                  </div> 
                  <div id="show" style="display: none">
                  <div class="form-group has-feedback">
                    <input type="text" placeholder="Sponsor ID" required="" value="" name="ref_id" id="ref_id" class="form-control">
                  </div>
                  <div class="form-group has-feedback">
                    <input type="text" placeholder="" value="" name="sname" id="checksid" class="form-control" readonly>
                  </div>
                  <div class="form-group  has-feedback">
                    <select class="select_kit_variant form-control" required="" name="select_kit_variant">
                      <option value="">SELECT KIT</option>
                      <option value="3500">KIT - 3500</option>
                      <option value="700">KIT - 700</option>
                    </select>
                  </div> 
                  <div class="form-group has-feedback" id="uid_field" style="display: none;">
                    <input type="text" value="" id="user_id" class="form-control" name="user_id" required="" Placeholder="UserID">
                  </div>
                  
                  <div class="form-group has-feedback">
                    <input type="text" placeholder="" value="" name="sname" id="checkcode" class="form-control" readonly>
                  </div>


                  <div class="form-group has-feedback">
                    <input type="text" placeholder="Firstname" value="" id="first_name" class="form-control" name="first_name" required="">
                  </div>
                  <div class="form-group has-feedback">
                    <input type="text" placeholder="Middlename" value="" id="mid_name" class="form-control" name="mid_name" required="">
                  </div>
                  <div class="form-group has-feedback">
                    <input type="text" value="" placeholder="Lastname" id="last_name" class="form-control" name="last_name" required="">
                  </div>
                  <div class="form-group has-feedback">
                    <input type="text" placeholder="Address" value="" id="address1" class="form-control" name="address1" required="">
                  </div>

                    
                 <div class="form-group has-feedback">
                  <input type="number" value="" id="phone" class="form-control" name="phone" required="" placeholder="Phonenumber">
                </div>  

                


                                        
                <div class="form-group has-feedback">
                  <select id="pick_up" name="pick_up" class="form-control" style="width: 100%" required >                       
                   <option value="Single">Pick Up Place</option>
                   <option value="Tagum City">Tagum City</option>
                   <option value="Davao City">Davao City</option>
                   <option value="Panabo City">Panabo City</option>
                   <option value="Mati City">Mati City</option>
                   <option value="Butuan City">Butuan City</option>
                   <option value="Kapalong">Kapalong</option> 
                   <option value="Surigao City">Surigao City</option>
                   <option value="Nabunturan">Nabunturan</option>
                   <option value="Manila">Manila</option>
                   <option value="Caloocan">Caloocan</option>  
                   <option value="Baculod">Baculod</option>
                   <option value="Sto.tomas">Sto.tomas</option>
                   <option value="Digos City">Digos City</option>                                             
                 </select>
                </div>

                <div   class="form-group has-feedback"  id="date-to"  > 
                  <input type='text' class="form-control datetimepicker1" id="date" required  placeholder="2019-12-1"   autocomplete="off"/>  
                  <input type="hidden" name="date2" id="newdate2">
                </div>
                 
                <button type="submit" name="register" class="btn btn-danger btn-block btn-flat " id="register" disabled="">Register</button>
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
  $(document).ready(function(){
    $('#date').datepicker({
      autoclose: true,
      // format: "dd/mm/yyyy",
    });
    $('#ref_id').on('keyup' ,function(){ 
      var val = $(this).val();

      $.ajax({
        type : 'POST',
        datatype: 'JSON',
        url: 'function.php',
        data:{
          action: 'check_sponsor',
          val : val, 
        }, 
        success: function(data){ 
          $('#checksid').val(data);
        }
      }); 

    });

    $('.upgrade-or-add-user').on('change',function(){  
      var val = $(this).val(); 
      if( val == '' ){
        $('#show').css('display','none');
      } else {
        $('#show').css('display','block');
      }
    });
    $('.select_kit_variant').on('change',function(){  
      var val = $(this).val(); 
      if( val == '' ){
        $('#uid_field').css('display','none');
      } else {
        $('#uid_field').css('display','block');
      }
    });
    $('#user_id').on('keyup' ,function(){ 
      var val = $(this).val();
      var kit = $('.select_kit_variant').val();
      $.ajax({
        type : 'POST',
        datatype: 'JSON',
        url: 'function.php',
        data:{
          action: 'check_code',
          val : val, 
          kit : kit, 
        }, 
        success: function(data){ 
          $('#checkcode').val(data);
          if( $('#checksid').val() != 0 && data == 'Available' ){ 
            $('button#register').addClass('btn-primary');
            $('button#register').removeClass('btn-danger');
            $('button#register').prop("disabled", false);
          } else { 
            $('button#register').prop("disabled", true);
            $('button#register').addClass('btn-danger');
            $('button#register').removeClass('btn-primary');
          }
        }
      }); 

    }); 
 
    $('#register_form').on('submit',function(e){
      e.preventDefault();
      var acc = $('.upgrade-or-add-user ').val();
      var kit = $('.select_kit_variant ').val();
      var sid = $('#ref_id').val();
      var fname = $('#first_name').val();
      var mname = $('#mid_name').val();
      var lname = $('#last_name').val();
      var ad = $('#address1').val();
      var phone = $('#phone').val();
      var user_id = $('#user_id').val();
      var pick_up = $('#pick_up').val();
      var date = $('#date').val();
 
      $.ajax({
        type : 'POST',
        datatype: 'JSON',
        url: 'function.php',
        data:{
          action: 'register_user',
          acc : acc,
          kit : kit,
          sid : sid,
          fname : fname,
          mname : mname,
          lname : lname,
          ad : ad,
          phone : phone,
          user_id : user_id,
          pick_up : pick_up,
          date : date  
        }, 
        success: function(data){
          alert(data); 
          location.reload();
        } 
      }); 

    });

  }); 
</script>
<?php 
include('footer.php');
 ?> 
 