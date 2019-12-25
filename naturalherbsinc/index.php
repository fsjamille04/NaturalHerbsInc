<?php 
include('header.php'); 
?> 
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1>Natural Herbs Pharm</h1>
            </div> 
          </div>
        </div><!-- /.container-fluid -->
      </section>
      <!-- Main content -->
      <section class="content">
        <!-- Small boxes (Stat box) -->
        <div class="row">
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <h3><?php
                  $sql = "SELECT count(uid) as tot FROM member";
                  $result=$conn->query($sql); 
                  while($row=$result->fetch_assoc()) {
                    $totmem = $row['tot'];
                    echo $totmem;  
                  }
                  ?></h3> 
                  <p>Total Members</p>
              </div>
              <div class="icon">
                <i class="ion ion-bag"></i>
              </div>
              <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                <h3><?php   
                  $sql = "SELECT count(id) as tot FROM withdraw where stat=''";
                  $result=$conn->query($sql); 
                  while($row=$result->fetch_assoc()) {
                    $totpay = $row['tot'];
                    echo $totpay;
                  } 
                ?></h3>

                <p>Payable Withdrawal</p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
              <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
              <div class="inner">
                <h3><?php   
                $sql = "SELECT count(id) as tot FROM withdraw where stat='done'";
                $result=$conn->query($sql); 
                while($row=$result->fetch_assoc()) {
                  $paydone = $row['tot'];
                  echo $paydone;  
                }
                ?></h3> 
                <p>Paid Withdrawal</p>
              </div>
              <div class="icon">
                <i class="ion ion-person-add"></i>
              </div>
              <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
              <div class="inner">
                <h3><?php 
                  $di = $totmem * 1000;  
                  echo '₱' . number_format($di,2,'.',','); ?></h3> 
                <p>Total Income</p>
              </div>
              <div class="icon">
                <i class="ion ion-pie-graph"></i>
              </div>
              <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
        </div>
        </section>


      <section class="content">   
        <div class="row">
          <div class="col-12"> 
            <!-- /.card -->
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">List Members</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body"> 
                <strong><h2 class='no-margins font-extra-bold text-info text-center'>Total of Widraws ₱ <?php 
                  $di = $totmem * 1000;   
                  $sql = "SELECT sum(withdraw) as tot FROM withdraw where stat='done'";
                  $result=$conn->query($sql); 
                  while($row=$result->fetch_assoc()) {
                    $pout = $row['tot']; 
                  }   
                  echo number_format($pout,2,'.',',') ?>  </h2></strong>
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                    <tr>
                      <th>Number</th>
                      <th>Username</th>
                      <th>Amount</th>
                      <th>Date</th>
                      <th>Pick-up Check</th> 
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $sql="SELECT withdraw.withdraw,member.fn,member.mn,member.ln,withdraw.dat,withdraw.reg,member.ad FROM withdraw join member on withdraw.id=member.uid where withdraw.stat='done'";
                    $result = mysqli_query($conn,$sql);
                    $num=0;
                    while($row = mysqli_fetch_array($result)) {
                        $num++; ?>
                    <tr>
                        <td><?php echo $num  ?></td> 
                        <td><?php echo $row['fn'].' '.$row['mn'].' '.$row['ln']  ?></td> 
                        <td><?php echo $row['0']  ?></td> 
                        <td><?php echo   $row['dat']  ?></td> 
                        <td><?php echo $row['ad']  ?></td>
                    </tr>            
                    <?php } ?>  
                  </tbody>
                  <tfoot>
                    <tr>
                      <th>Number</th>
                      <th>Username</th>
                      <th>Amount</th>
                      <th>Date</th>
                      <th>Pick-up Check</th> 
                    </tr>
                  </tfoot>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </section>
      <!-- /.content -->
    </div>
<?php 
include('script.php');
 ?>  
    
<?php 

include('footer.php');

?>
