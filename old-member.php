 
<?php
 include 'header.php'; 
 ?>


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
              <!-- <select class="col-md-6 form-control" style="margin : 10px 0; border: 1px solid black" id="select-package">
                <option>Select Members</option>
                <option value="old">Old Member</option>
                <option value="new">New Member</option>
              </select> -->
                <form method="post">  
                  <table id="append_data" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th>Number</th>
                        <th>User ID</th>
                       <!--  <th>Username</th>
                        <th>Password</th> -->
                        <th>Fullname</th>
                        <th>Sponsor</th>
                        <th>Address</th>
                        <th>Package</th>
                        <th>Date</th>
                        <th>Pick up</th>
                        <th>Edit</th>
                      </tr>
                    </thead> 
                    <tbody id="view-member"> 
                    <?php  
                    $sql="SELECT * FROM member ORDER BY dat DESC";   
                    $result = mysqli_query($conn,$sql); 
                    while($row = mysqli_fetch_array($result)) {   ?>
                       <tr>  
                        <td><?php echo $row['regen'] ?> </td>   
                        <td><?php echo $row['uid'] ?> </td>  
                        <!-- <td><?php echo $row['uname'] ?> </td> 
                        <td><?php echo $row['upass'] ?> </td>  -->
                        <td><?php echo $row['fn'].' '.$row['mn'].' '.$row['ln'] ?></td> 
                        <td><?php echo $row['sid'] ?> </td> 
                        <td><?php echo $row['ad'] ?> </td> 
                        <td><?php echo $row['status_new'] ?> </td> 
                        <td><?php echo $row['dat'] ?> </td> 
                        <td><?php echo $row['pick_up'] ?> </td>
                        <td class="text-center"><button type="button" class="btn btn-primary btn_edit" value="<?php echo  $row['uid'] ?>"> <span class="glyphicon glyphicon-edit" ></span> Edit</button></td> 
                      </tr>
                      <?php 
                         }
                      ?>
                    </tbody>   
                   
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
  </div>  
 <?php 
include('script.php');
 ?>  
<script> 
$(document).ready(function(){ 
  $(document).on("click",".btn_edit",function(){
    var id = $(this).val();
    window.location.href = 'admin-useredit.php?id='+id; 
  });  

  $('#select-package').on('change',function(){  
    var val = $(this).val(); 
    if( val == '' ){
      $('#show').css('display','none');
    } else {
      $('#show').css('display','block');
    }
  });

  // $('#select-package').on('change', function(){
  //   var val = $(this).val();
  //   $('#append_data tbody').empty();
  //   $.ajax({
  //     url: "function.php",
  //     type: "POST",
  //     data:{
  //       action: "show_member",
  //       val:val
  //     },
  //     success:function(data){
  //       $('#append_data tbody').append(data); 
  //       console.log(data);
  //     }
  //   });
  // });
 }); 
</script>

<?php 
include('footer.php');
 ?> 
 
