 
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
                <form method="post">  
                  <table id="example1" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th>Number</th>
                        <th>User ID</th>
                        <th>Username</th>
                        <th>Password</th>
                        <th>Fullname</th>
                        <th>Sponsor</th>
                        <th>Address</th>
                        <th>Package</th>
                        <th>Date</th>
                        <th>Pick up</th>
                        <th>Edit</th>
                      </tr>
                    </thead>

                    <tbody> 
                    <?php  
                      $sql="SELECT * FROM member";
                      $result = mysqli_query($conn,$sql);
                      $num=0;
                       while($row = mysqli_fetch_array($result)) { 
                        
                         
                        echo"<tr>";
                      
                        echo"<td>"; 
                             echo $row['regen'];
                        echo"</td>";
                        echo"<td>"; 
                            echo $row['uid'];
                        echo"</td>";

                        echo"<td>"; 
                            echo $row['uname'];
                        echo"</td>";

                        echo"<td>"; 
                            echo $row['upass'];
                        echo"</td>";

                        echo"<td>"; 
                            echo $row['fn'].' '.$row['mn'].' '.$row['ln'];
                        echo"</td>";

                        echo"<td>"; 
                            echo $row['sid'];
                        echo"</td>";

                         echo"<td>"; 
                            echo $row['ad'];
                        echo"</td>";
                         echo"<td>"; 
                            echo $row['status_new'];
                        echo"</td>";

                        echo"<td>"; 
                            echo $row['dat'];
                        echo"</td>";
                        echo"<td>"; 
                        echo $row['pick_up'];
                        echo"</td>";   ?> 
                        <td class="text-center"> <button type="button" class="btn btn-primary btn_edit" value="<?php echo $row['uid'] ?>"  > <span class="glyphicon glyphicon-edit" ></span> Edit </button>
                        <?php 
                    echo"</tr>";                   
                       } ?>
                    </tbody>   
                    <tfoot>
                      <tr>
                        <th>Number</th>
                        <th>User ID</th>
                        <th>Username</th>
                        <th>Password</th>
                        <th>Fullname</th>
                        <th>Sponsor</th>
                        <th>Address</th>
                        <th>Package</th>
                        <th>Date</th>
                        <th>Pick up</th>
                        <th>Edit</th>
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
 }); 
</script>

<?php 
include('footer.php');
 ?> 
 
