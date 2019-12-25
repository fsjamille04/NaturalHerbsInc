 

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
                  List of Purchase 
                </h2>
              </div>
              <!-- /.card-header -->
              <div class="card-body"> 
                        <form action="" method="post">

                                <div class="col-lg-12">

             <div class="box">
            <div class="box-header">
          <div class="box-body">         
           <div class="panel-body">
            
                <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Number</th>
                  <th>User ID</th> 
                  <th>Fullname</th>
                  <th>Product</th>
                  <th>Qty</th>
                  <th>Total</th>
                  <th>Status</th>
                  <th>Date</th>
                </tr>
                </thead> 
                <tbody> 
                 <?php 
                  $sql="SELECT * FROM purchase ORDER BY dat DESC ";

                  $result = mysqli_query($conn,$sql);
                  $num=0;
                   while($row = mysqli_fetch_array($result)) {
                    
                    
                  $sql1="SELECT * FROM member WHERE uid = '".$row['id']."'";
                  $result1 = mysqli_query($conn,$sql1);
                    while($row1 = mysqli_fetch_array($result1)) {
                     
                    $fullname = $row1['fn']. ' ' . $row1['mn'].' '. $row1['ln']; 
                    $stat = $row1['status_new'];
                    }



                  $sql2="SELECT * FROM product WHERE reg = '".$row['pid']."'";
                  $result2 = mysqli_query($conn,$sql2);
                    while($row2 = mysqli_fetch_array($result2)) {
                    
                      $prdname = $row2['pn'];
                    }


                        $num++;
                     
                    echo"<tr>"; 
                      echo"<td>"; 
                           echo $num;
                      echo"</td>";
                      echo"<td>"; 
                          echo $row['id'];
                      echo"</td>"; 
                      echo"<td>"; 
                          echo $fullname;
                      echo"</td>";

                      echo"<td>"; 
                          echo $prdname;
                      echo"</td>";

                       echo"<td>"; 
                          echo $row['qty'];
                      echo"</td>";
                      echo"<td>"; 
                          echo $row['amt'];
                      echo"</td>";
                      echo"<td>"; 
                          echo $stat;
                      echo"</td>";

                      echo"<td>"; 
                          echo $row['dat'];
                      echo"</td>";


                  echo"</tr>";                   
                   } 
                ?> 
                </tbody>   
                <tfoot> 
                  <th>Number</th>
                  <th>User ID</th> 
                  <th>Fullname</th>
                  <th>Product</th>
                  <th>Qty</th>
                  <th>Total</th>
                  <th>Status</th>
                  <th>Date</th>
                </tfoot>  

                  
                    </table>
                    </div></div></div>

                </div>
        </div>


                        </form>
                        </div> 
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
 
