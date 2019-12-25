 

<?php
 include 'header.php'; 
 ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <section class="content">
        <div class="row">
          <div class="col-12"> 
            <!-- /.card -->
            <div class="card" style="margin-top: 2rem; padding: 0 1vw; display: flex;  align-items: center; justify-content: center; flex-direction: column; padding: 5vh 0;">
              <div class="card-header">
                <h1>
                  Edit User 
                </h1>
              </div>
              <!-- /.card-header -->
              <div class="card-body" style=""> 
                  
                <div class="register-box">
                  <div class="register-logo">
                    <h1>Natural Herbs Pharm</h1>
                  </div>

                  <div class="register-box-body">
                    <p class="login-box-msg">Register a new membership</p>
                     <!-- <small>ID # : <?php echo $id; ?></small> <br><br> -->
                    <form action="" method="post" class="form-edit">
                      <?php 
                      $getid = $_GET['id']; 
                      $sql = "SELECT * FROM member where uid='$getid'";
                      $result = mysqli_query ($conn, $sql);
                      while ( $row = mysqli_fetch_assoc( $result ) ) {   
                      ?>  

                      <div class="form-group has-feedback">
                        <label>First name</label>
                        <input type="text"placeholder="Firstname" value="<?php echo $row['fn'] ?>" id="first_name" class="form-control" name="first_name" ">
                        <span class="glyphicon glyphicon-user form-control-feedback"></span>
                      </div>
                      <div class="form-group has-feedback">
                        <label>Middle name</label>
                        <input type="text"placeholder="Middlename" value="<?php echo $row['mn'] ?>" id="mid_name" class="form-control" name="mid_name" ">
                        <span class="glyphicon glyphicon-user form-control-feedback"></span>
                      </div>
                      <div class="form-group has-feedback">
                        <label>Last name</label>
                        <input type="text" value="<?php echo $row['ln'] ?>" placeholder="Lastname" id="last_name" class="form-control" name="last_name" ">
                        <span class="glyphicon glyphicon-user form-control-feedback"></span>
                      </div>
                      <div class="form-group has-feedback">
                        <label>Address</label>
                        <input type="text"placeholder="Address" value="<?php echo $row['ad'] ?>" id="address1" class="form-control" name="address1" ">
                        <span class="glyphicon glyphicon-user form-control-feedback"></span>
                      </div>

                      <div class="form-group has-feedback">
                        <label>Status</label>
                        <select name="stat" id="stat" class="form-control" style="width: 100%"   >                       
                          <option <?php if( $row['stat']=='Single' ) echo 'selected' ?> value="Single">Single</option>
                          <option <?php if( $row['stat']=='Married' ) echo 'selected' ?> value="Married">Married</option>
                          <option <?php if( $row['stat']=='Others' ) echo 'selected' ?> value="Others">Others</option> 
                        </select>
                      </div>
                      <div class="form-group has-feedback">
                        <label>Phone</label>
                        <input type="text" value="<?php echo $row['phone'] ?>" id="phone" class="form-control" name="phone" " placeholder="Phonenumber">
                        <span class="glyphicon glyphicon-user form-control-feedback"></span>
                      </div> 

                      <div class="form-group has-feedback">
                        <label>Birthday</label>
                        <input type="" value="<?php echo $row['dat'] ?>" id="" class="form-control" name="" " placeholder="Birthday">
                        <span class="glyphicon glyphicon-user form-control-feedback"></span>
                      </div> 
                
                      <div class="form-group has-feedback">
                        <label>Password</label>
                        <input type="text" value="<?php echo $row['upass'] ?>" id="user_pass" class="form-control" name="user_pass" " placeholder="Password">
                        <span class="glyphicon glyphicon-user form-control-feedback"></span>
                      </div>
                      <label>Pick up</label>
                      <div class="form-group has-feedback">
                        <select id="pick_up" name="pick_up" class="form-control" style="width: 100%" required >                       
                          <option value="">Pick Up Place</option>
                          <option  <?php if( $row['pick_up']=='Tagum City' ) echo 'selected' ?> value="Tagum City">Tagum City</option>
                          <option  <?php if( $row['pick_up']=='Davao City' ) echo 'selected' ?> value="Davao City">Davao City</option>
                          <option  <?php if( $row['pick_up']=='Panabo City' ) echo 'selected' ?> value="Panabo City">Panabo City</option>
                          <option  <?php if( $row['pick_up']=='Mati City' ) echo 'selected' ?> value="Mati City">Mati City</option>
                          <option  <?php if( $row['pick_up']=='Butuan City' ) echo 'selected' ?> value="Butuan City">Butuan City</option>
                          <option <?php if( $row['pick_up']=='Kapalong' ) echo 'selected' ?>  value="Kapalong">Kapalong</option> 
                          <option  <?php if( $row['pick_up']=='Surigao City' ) echo 'selected' ?> value="Surigao City">Surigao City</option>
                          <option <?php if( $row['pick_up']=='Nabunturan' ) echo 'selected' ?>  value="Nabunturan">Nabunturan</option>
                          <option  <?php if( $row['pick_up']=='Manila' ) echo 'selected' ?> value="Manila">Manila</option>
                          <option  <?php if( $row['pick_up']=='Caloocan' ) echo 'selected' ?> value="Caloocan">Caloocan</option>  
                          <option  <?php if( $row['pick_up']=='Baculod' ) echo 'selected' ?> value="Baculod">Baculod</option>
                          <option  <?php if( $row['pick_up']=='Sto.tomas' ) echo 'selected' ?> value="Sto.tomas">Sto.tomas</option>
                          <option  <?php if( $row['pick_up']=='Digos City' ) echo 'selected' ?> value="Digos City">Digos City</option>                                                  
                        </select>
                      </div>

                      <div class="col-xs-4">
                        <button type="submit"name="update" class="update btn btn-primary btn-block btn-flat">Update</button>
                      </div>
                      <?php  } 

                        if(isset($_POST['update'])){ 
                          $fn = $_POST['first_name'];
                          $mn = $_POST['mid_name'];
                          $ln = $_POST['last_name'];
                          $ad = $_POST['address1'];
                          $stat = $_POST['stat'];
                          $phone = $_POST['phone'];
                          // $uname = $_POST['user_name'];
                          $upass = $_POST['user_pass'];
                          $pick_up = $_POST['pick_up'];

                          $results = $conn->query("UPDATE member SET fn='$fn',mn='$mn',ln='$ln',ad='$ad',stat='$stat',phone='$phone' ,upass='$upass' ,pick_up='$pick_up' where uid =  '$getid'  "); 
                            echo "<script> window.location.href = 'member.php'; </script>"; 
                        } 
                      ?>
                    </form>
                 </div> 
                </div>
     
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
 <?php 
include('footer.php');
 ?> 
 
