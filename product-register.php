 
<?php
      include 'header.php'; 
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
     
                <form method="post" id="prod-register">
                  <div class="form-group has-feedback">
                     <input type="text" placeholder="Productname" required="" value="" name="pn" id="pn" class="form-control">
                   
                  </div>  
                  <div class="form-group has-feedback">
                    <input type="number" placeholder="SRP" required="" value="" name="srp" id="srp" class="form-control">
                  
                  </div>
                  <div class="form-group has-feedback">
                   <input type="number" placeholder="Distributor" required="" value="" name="dis" id="dis" class="form-control">
                    
                  </div>
               
                  <button type="submit" name="submits" class="btn btn-primary btn-block btn-flat">Register</button>
                 
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
    
    $('#prod-register').on('submit',function(){
      var pn = $('#pn').val();
      var srp = $('#srp').val();
      var dis = $('#dis').val();

      $.ajax({
        type : 'POST',
        datatype: 'JSON',
        url: 'function.php',
        data:{
          action: 'product_register',
          pn : pn, 
          srp : srp, 
          dis : dis, 
        }, 
        success: function(data){ 
          alert(data);
        }
      }); 

    });
  });
</script>
<?php 
include('footer.php');
 ?> 
 