<?php  
if(isset($_POST['action'])){
	$function = $_POST['action'];
	$function();
}

function show_member(){
	
	include "dbconnection.php";

	$val = $_POST['val'];
	$where = '';
	$print = '';
	if( $val == 'old' ){
		$where = "Where dat < '2019-11-21'";
	} else {	
		$where = "Where dat >= '2019-12-1' ORDER BY dat DESC";
	}

	$sql="SELECT * FROM member " .  $where  ; 	
	// echo $sql;

	$result = mysqli_query($conn,$sql); 
	while($row = mysqli_fetch_array($result)) {  
	     
	  $print .=' <tr>  
	  	<td> '. $row['regen'].' </td> 	
	  	<td> '. $row['uid'].' </td>  
	  	<td> '. $row['uname'].' </td> 
	  	<td> '. $row['upass'].' </td> 
	  	<td> '. $row['fn'].' '.$row['mn'].' '.$row['ln'].' </td> 
	  	<td> '. $row['sid'].' </td> 
	  	<td> '. $row['ad'].' </td> 
	  	<td> '. $row['status_new'].' </td> 
	  	<td> '. $row['dat'].' </td> 
	  	<td> '. $row['pick_up'].' </td>
	  	<td class="text-center"><button type="button" class="btn btn-primary btn_edit" value="'.  $row['uid'] .'"> <span class="glyphicon glyphicon-edit" ></span> Edit</button></td> 
        </tr> ' ;
        echo $print;  
 	}
	  
}

function show_noMaintenance(){
	
	include "dbconnection.php";

	$from = $_POST['dateFrom'];
	$to = $_POST['dateTo'];
	$print = ''; 
	$sql="SELECT *, SUM(amount) as amt FROM rebates where notify_payout =  'notify'   and dat BETWEEN '$from' and '$to' GROUP by id  "  ; 	
 
	$result = mysqli_query($conn,$sql); 
	while($row = mysqli_fetch_array($result)) {    
		$query1 = 'SELECT fn,mn,ln  FROM member Where uid =  '.$row['id'] .' ';    
		$result1 = mysqli_query ($conn, $query1); 
		while ( $row1 = mysqli_fetch_assoc( $result1 ) ) { 
			$fullname =  $row1['fn'] . ' ' . $row1['mn'] . ' ' . $row1['ln']  ;
		}
		if( $row['amt'] <= 1999 and $row['status_new'] == 700 ){
		$print  =' <tr id="'.$row['id'].'" class="getId">  
			<td > '. $row['id'].' </td> 	
			<td> '. $fullname .' </td>  
			<td> '. $row['status_new'] .' </td>  
			<td> '. $row['amt'].' </td>  
			<td> '. $from . ' - ' . $to .' </td>   
			</tr> ';
			echo $print;  
		}
		if( $row['amt'] <= 4999 and $row['status_new'] == 3500 ){
			$print  =' <tr id="'.$row['id'].'" class="getId">  
				<td > '. $row['id'].' </td> 	
				<td> '. $fullname .' </td>  
				<td> '. $row['status_new'] .' </td>  
				<td> '. $row['amt'].' </td>  
				<td> '. $from . ' - ' . $to .' </td>   
				</tr> ';
				echo $print;  
			}
 	}
	  
}


function check_sponsor(){
	include "dbconnection.php"; 
	$uid = $_POST['val']; 
	$data = '0';
	$sql="SELECT * FROM member where uid='$uid'";
  	$result = mysqli_query($conn,$sql); 
   	while($row = mysqli_fetch_array($result)) {
   		$data = $row['fn'] . ' ' . $row['mn'] . ' ' . $row['ln'] ;          
    }
   echo $data; 
}  

function show_data(){
	include "dbconnection.php"; 
	
	$dateFrom = date("Y-m-d", strtotime($_POST['dateFrom'] )) ;
	$dateTo = date("Y-m-d", strtotime($_POST['dateTo'] )) ;
	$print = '';
	$fullname = '';
  	$amt = 0;
    $sql="SELECT *, SUM(amount) as amt  FROM rebates WHERE notify_payout != 'payout' and dat between '$dateFrom' and '$dateTo' GROUP by id ";
     
    $result = mysqli_query($conn,$sql); 
 	while($row = mysqli_fetch_assoc($result)) { 
    	 $sql1="SELECT * FROM member Where uid = ".$row['id']." ";
            $result1 = mysqli_query($conn,$sql1); 
             while( $row1 = mysqli_fetch_assoc($result1)) {
                $fullname =  $row1['fn'] . ' ' . $row1['mn'] . ' ' .$row1['ln']  ;
             }     
    	$print  = ' <tr>
          <td>'. $row['id'] .' </td>
          <td>'. $fullname .' </td> 
          <td>'. $row['dat'] .'  </td>
          <td><b style="color: green">' . $row['status_new'] . '</b></td>
          <td>' . $row['amt'] . '</td>
          <td>   <input type="button" name="payoutlist"  data-id="'.  $row['id'] .'" data-package ="'. $row['status_new'] .'" data-amount ="'. $row['amt'] .'" class="payoutlist md-trigger btn btn-primary mrg-b-lg" value="Payout">  </td> 
        </tr> ' ;

    	echo $print; 	
	} 
	
}

function check_code(){
	include "dbconnection.php"; 
	$code = $_POST['val']; 
	$kit = $_POST['kit']; 
	$data = 'Not Available';
	$sql="SELECT * FROM tbpin where id='$code' and status ='$kit' ";
  	$result = mysqli_query($conn,$sql); 
   	while($row = mysqli_fetch_array($result)) {
   		if( $row['stat'] != 'used' ){
   			$data = 'Available';  
   		} else {
   			$data = 'Not Available'; 
   		}     
    }
   echo $data; 
}  

function product_register(){ 
	include "dbconnection.php"; 
 	$pn = $_POST['pn']; 
    $dis = $_POST['dis'];
    $srp = $_POST['srp'];

    $sql = "INSERT IGNORE INTO product (pn,dis,srp)
    VALUES ('$pn','$dis','$srp')";
    if ($conn->query($sql) === TRUE) {  
	        $sql2="SELECT max(reg) as max FROM product";
	        $result2 = mysqli_query($conn,$sql2);
	        while($row2 = mysqli_fetch_array($result2)) {
	            $max = $row2['max'];
	        } 
      	echo "Added!"; 
    }
}

function register_user(){
	include ('dbconnection.php');  
	$acc = $_POST['acc'];
	$kit = $_POST['kit'];
	$sid = $_POST['sid'];
	$fname = $_POST['fname'];
	$mname = $_POST['mname'];
	$lname = $_POST['lname'];
	$ad = $_POST['ad'];
	$phone = $_POST['phone'];
	$user_id = $_POST['user_id'];
	$pick_up = $_POST['pick_up'];
	$date =  date( "Y-m-d", strtotime($_POST['date']) ) ; 

	$sql="SELECT * FROM tbpin where id='$user_id' and status ='$kit' and stat = 'used' ";
  	$result = mysqli_query($conn,$sql); 

	if( $result->num_rows == 0 ){  

		$insert =   $conn->query("INSERT INTO member (sid, uid, fn,mn,ln,ad, phone, dat,status_new,pick_up) VALUES ('$sid', '$user_id', '$fname','$mname','$lname','$ad', '$phone', '$date','$kit','$pick_up')")  ;  

		if( $acc == 'upgrade' ){
			echo "Succesfully Upgraded";
		} else {
			$ids = array();
			$package = array();
		 

			$conn->query("UPDATE tbpin SET stat = 'used' WHERE id = '$user_id' ");


			$hid=$user_id;    
		  	$x = 1; 
			  
		  	while($x <= 6) { 
			    $query = "SELECT * FROM member where uid='$hid'";
			    $result = mysqli_query ($conn, $query);
			    while ($row = mysqli_fetch_assoc($result)) {  
			      	$hid=$row['sid'];
			      	$ids[] = $hid; 
			    	$package[] = $row['status_new'];
			    }  
					$x++;                    
			}    
			if( $ids[0] != '' ){
				if( $kit == '3500'  ){ 
					if( $package[1] == 3500 ){ 
						$sumra = 500;
					} else { 
						$sumra = 100;
					}
				} else { 
					if( $package[1] == 3500 ){
						$sumra =  ( $kit == '3500' )? 500 : 100; 
					} else { 
						$sumra = 100;
					}
				} 
		  		// $sumra =  ( $kit == '3500' )? 500 : 100; 
		      	$sql = $conn->query("INSERT IGNORE INTO indirect (package_downline,one,two,three,four,five,id,dat,status) VALUES ('$kit','$sumra','0','0','0','0',". $ids[0] .",'$date',". $package[1] .")");  
		    }
		    if( $ids[1] != '' ){
		    	if( $kit == '3500'  ){
					if( $package[2] == 3500 ){
						$sumra = 150;
					} else {
						$sumra = 50;
					}
				} else {
					if( $package[2] == 3500 ){
						$sumra =  ( $kit == '3500' )? 150 : 50; 
					} else {
						$sumra = 50;
					}
				}   
		      	// $sumra =  ( $kit == '3500' )? 150 : 50; 
		      	$sql = $conn->query("INSERT IGNORE INTO indirect (package_downline,one,two,three,four,five,id,dat,status) VALUES ('$kit','0','$sumra','0','0','0',". $ids[1] .",'$date',". $package[2] .")");   
		  	}
			if( $ids[2] != '' ){
				if( $kit == '3500'  ){
					if( $package[3] == 3500 ){
						$sumra = 75;
					} else {
						$sumra = 30;
					}
				} else {
					if( $package[3] == 3500 ){
						$sumra =  ( $kit == '3500' )? 75 : 30; 
					} else {
						$sumra = 30;
					}
				}  
		      	// $sumra =  ( $kit == '3500' )? 75 : 30; 
		      	$sql = $conn->query("INSERT IGNORE INTO indirect (package_downline,one,two,three,four,five,id,dat,status) VALUES ('$kit','0','0','$sumra','0','0',". $ids[2] .",'$date',". $package[3] .")"); 
				}	

			if( $ids[3] != '' ){
				if( $kit == '3500'  ){
					if( $package[4] == 3500 ){
						$sumra = 50;
					} else {
						$sumra = 10;
					}
				} else {
					if( $package[4] == 3500 ){
						$sumra =  ( $kit == '3500' )? 50 : 10; 
					} else {
						$sumra = 10;
					}
				}  
		      	// $sumra =  ( $kit == '3500' )? 50 : 10; 
		      	$sql = $conn->query("INSERT IGNORE INTO indirect (package_downline,one,two,three,four,five,id,dat,status) VALUES ('$kit','0','0','0','$sumra','0',". $ids[3] .",'$date',". $package[4] .")");   
		  	}	
			if( $ids[4] != '' ){  
				if( $kit == '3500'  ){
					if( $package[5] == 3500 ){
						$sumra = 25;
					} else {
						$sumra = 10;
					}
				} else {
					if( $package[5] == 3500 ){
						$sumra =  ( $kit == '3500' )? 25 : 10; 
					} else {
						$sumra = 10;
					}
				}
		      	// $sumra =  ( $kit == '3500' )? 25 : 10; 
		      	$sql = $conn->query("INSERT IGNORE INTO indirect (package_downline,one,two,three,four,five,id,dat,status) VALUES ('$kit','0','0','0','0','$sumra',". $ids[4] .",'$date',". $package[5] .")"); 

		      	echo "Succesfully Registered";
		  	}
			     
    	} 	
	} else {
		echo 'Your Userpin is Already Used. Try Again!';
	}
}

function select_package(){
	include "dbconnection.php"; 
	$val = $_POST['val']; 
	$sql="SELECT * FROM tbpin where stat='' and status='$val' Order by date DESC";
  	$result = mysqli_query($conn,$sql);
  	$num=0;
   	while($row = mysqli_fetch_array($result)) {
  		$num+=1;
  		$print =  
		"<tr>
  			<td>". $num ."</td>		 
  			<td>". $row['id'] ."</td>		 
  			<td>". $row['pin'] ."</td>	 
  			<td>". $row['date'] ."</td>		
  		</tr>";  
      	echo $print;            
   }

}

function savecode(){
	include ('dbconnection.php'); 
	$amt = trim($_POST['amt']);
	$stat = $_POST['stat']; 
	if($stat == '3500'){
	  $status_new = '3500';
	}else{
	  $status_new =  '700';
	}   

	$y=1; 
	while($y <= $amt ){ 
	    $res = mt_rand(100000, 900000); 
	    if ($result = $conn->query("SELECT * FROM tbpin where id='$res'")) { 
	      if($result->num_rows ==0){   
	        $res2 = substr(str_shuffle(str_repeat("0123456789abcdefghijklmnopqrstuvwxyz", 7)), 0, 7);
	        $res2 = 'NEW'.$stat.'-'.$res2; 
	        $sql =$conn->query( "INSERT IGNORE INTO tbpin (id,pin,status) VALUES ('$res','$res2', '$status_new')" );  
	      } 
	    $result->close();     
	  }  
	  $y++; 
	}
	 
	  echo'code successfully created!';
}

function get_name(){ 
	include ('dbconnection.php'); 
	$uid = $_POST['userid'];
	$data = 0;

	$sql="SELECT * FROM member WHERE uid = '".$uid."'";
	$result = mysqli_query($conn,$sql);  
	while($row = mysqli_fetch_array($result)) {  	 
		$data = $row['fn'] .' '. $row['mn'] .' '.$row['ln'];    
	}
	 
	echo  $data ; 

}


function rebates_payout(){
	include ('dbconnection.php'); 

	$uid = $_POST['userid'];
	$from = date("Y-m-d", strtotime($_POST['date1'] )) ;
	$to = date("Y-m-d", strtotime($_POST['date2'] )) ; 

  	$reg = array();

 	$p3500total = 0; 
 	$lvl13500total = 0;
 	$lvl23500total = 0;
 	$lvl33500total = 0;
 	$lvl43500total = 0;
 	$lvl53500total = 0;
 	$lvl63500total = 0;
 	$lvl73500total = 0;
 	$lvl83500total = 0;
 	$lvl93500total = 0;
 	$cntp3500 = 0;
 	$lvl1cnt3500 = 0;
 	$lvl2cnt3500 = 0;
 	$lvl3cnt3500 = 0;
 	$lvl4cnt3500 = 0;
 	$lvl5cnt3500 = 0;
 	$lvl6cnt3500 = 0;
 	$lvl7cnt3500 = 0;
 	$lvl8cnt3500 = 0;
 	$lvl9cnt3500 = 0;


 	$p700total = 0; 
 	$lvl1700total = 0;
 	$lvl2700total = 0;
 	$lvl3700total = 0;
 	$lvl4700total = 0; 
 	$cntp700 = 0;
 	$lvl1cnt700 = 0;
 	$lvl2cnt700 = 0;
 	$lvl3cnt700 = 0;
 	$lvl4cnt700 = 0; 

	$totalpersonal = 0;
 	$totallvl1 = 0;	
 	$totallvl2 = 0;
 	$totallvl3 = 0;
 	$totallvl4 = 0;
 	$totallvl5 = 0;
 	$totallvl6 = 0;
 	$totallvl7 = 0;
 	$totallvl8 = 0;
 	$totallvl9 = 0;
 
 	$totalall = 0;


 	$amount = 0;	

	$query0 = "SELECT * FROM member where uid='$uid'  ";
    $result0 = mysqli_query ($conn, $query0);
    while ( $row0 = mysqli_fetch_assoc($result0) ) { 
    
    	$fullname = $row0['fn'] . ' ' . $row0['mn'] . ' ' . $row0['ln'];
      	$pick_up = $row0['pick_up'];   	
    }
	$personal_purchase_package = 0; 	 
    $query = "SELECT * FROM rebates where id =  '$uid' and notify_payout != 'payout' and dat between '$from' and '$to'  ";   
    $result = mysqli_query ($conn, $query); 
    while ( $row = mysqli_fetch_assoc( $result ) ) { 
    	$reg[] = $row['reg'];
		$personal_purchase_package = $row['personal_purchase_package'];
    	if( $row['personal'] != 0 ){
    		$amount += $row['amount'];
       		if( $row['status_new'] == '3500' ){  
       			$cntp3500++;
	       		$p3500total += $row['personal']; 
       		} else {  
       			$cntp700++;
	       		$p700total += $row['personal'];
       		}
       	} 
       	if( $row['one'] != 0 ){
       		if( $row['status_new'] == 3500 ){
       			if( $personal_purchase_package == 3500 ){
		       		$lvl1cnt3500++;
		       		$lvl13500total += $row['one']; 
	       		} else {
	       			$lvl1cnt700++;
		       		$lvl1700total += $row['one'];
	       		}
       		} else { 
       			$lvl1cnt700++;
	       		$lvl1700total += $row['one'];
       		} 
       	}
       	if( $row['two'] != 0 ){
       		if( $row['status_new'] == 3500 ){
       			if( $personal_purchase_package == 3500 ){
		       		$lvl2cnt3500++;
		       		$lvl23500total += $row['two']; 
	       		} else {
	       			$lvl2cnt700++;
		       		$lvl2700total += $row['two'];
	       		}
       		} else { 
       			$lvl2cnt700++;
	       		$lvl2700total += $row['two'];
       		} 
       	}
       	if( $row['three'] != 0 ){
       		if( $personal_purchase_package == 3500 ){
       			if( $row['status_new'] == 3500 ){
		       		$lvl3cnt3500++;
		       		$lvl33500total += $row['three']; 
	       		} else {
	       			$lvl3cnt700++;
		       		$lvl3700total += $row['three'];
	       		}
       		} else { 
       			$lvl3cnt700++;
	       		$lvl3700total += $row['three'];
       		}  
       	}
       	if( $row['four'] != 0 ){
       		if( $personal_purchase_package == 3500 ){
       			if( $row['status_new'] == 3500 ){
		       		$lvl4cnt3500++;
		       		$lvl43500total += $row['four']; 
	       		} else {
	       			$lvl4cnt700++;
		       		$lvl4700total += $row['four'];
	       		}
       		} else { 
       			$lvl4cnt700++;
	       		$lvl4700total += $row['four'];
       		} 
       	}
       	if( $row['five'] != 0 ){
       		if( $personal_purchase_package == 3500 ){
       			if( $row['status_new'] == 3500 ){
		       		$lvl5cnt3500++;
		       		$lvl53500total += $row['five']; 
	       		} else {
	       			$lvl5cnt700++;
		       		$lvl5700total += $row['five'];
	       		}
       		} else { 
       			$lvl5cnt700++;
	       		$lvl5700total += $row['five'];
       		} 
       	}
       	if( $row['six'] != 0 ){
       		if( $personal_purchase_package == 3500 ){
       			if( $row['status_new'] == 3500 ){
		       		$lvl6cnt3500++;
		       		$lvl63500total += $row['six']; 
	       		} else {
	       			$lvl6cnt700++;
		       		$lvl6700total += $row['six'];
	       		}
       		} else { 
       			$lvl6cnt700++;
	       		$lvl6700total += $row['six'];
       		} 
       	}
       	if( $row['seven'] != 0 ){
       		if( $personal_purchase_package == 3500 ){
       			if( $row['status_new'] == 3500 ){
		       		$lvl7cnt3500++;
		       		$lvl73500total += $row['seven']; 
	       		} else {
	       			$lvl7cnt700++;
		       		$lvl7700total += $row['seven'];
	       		}
       		} else { 
       			$lvl7cnt700++;
	       		$lvl7700total += $row['seven'];
       		} 
       	}
       	if( $row['eight'] != 0 ){
       		if( $personal_purchase_package == 3500 ){
       			if( $row['status_new'] == 3500 ){
		       		$lvl8cnt3500++;
		       		$lvl83500total += $row['eight']; 
	       		} else {
	       			$lvl8cnt700++;
		       		$lvl8700total += $row['eight'];
	       		}
       		} else { 
       			$lvl8cnt700++;
	       		$lvl8700total += $row['eight'];
       		} 
       	}
       	if( $row['nine'] != 0 ){
       		if( $personal_purchase_package == 3500 ){
       			if( $row['status_new'] == 3500 ){
		       		$lvl9cnt3500++;
		       		$lvl93500total += $row['nine']; 
	       		} else {
	       			$lvl9cnt700++;
		       		$lvl9700total += $row['nine'];
	       		}
       		} else { 
       			$lvl9cnt700++;
	       		$lvl9700total += $row['nine'];
       		} 
       	}
    }
 

	$totalpersonal = $p3500total + $p700total;
	$totallvl1 = $lvl13500total + $lvl1700total;
	$totallvl2 = $lvl23500total + $lvl2700total;
	$totallvl3 = $lvl33500total + $lvl3700total;
	$totallvl4 = $lvl43500total + $lvl4700total;
	$totallvl5 = $lvl53500total ;
	$totallvl6 = $lvl63500total ;
	$totallvl7 = $lvl73500total ;
	$totallvl8 = $lvl83500total ;
	$totallvl9 = $lvl93500total ;

	$totalall =$totalpersonal + $totallvl1 + $totallvl2 + $totallvl3 + $totallvl4 + $totallvl5 + $totallvl6 + $totallvl7 + $totallvl8 + $totallvl9;
	 
	$reg = implode (", ", $reg);
			// echo "<pre>";
	  //  		print_r($reg);
	  //  		echo "</pre>";
	$print = '<div id="unilevel">
	            <div class="col-lg-12 text-left">
                <input type="hidden" name="idMember"  id="idMember" data-id="'.$uid.'">
                <span>
                    <strong>Natural Herbs</strong> 
                    Tagum City<br>
                </span> 
                 <span><strong>Invoice Date:</strong> '."{$from}".' - '."{$to}".'
                    </span><br >
                 <span><strong> ID NO. : '."{$uid}".' </strong></span> <br > 
                 <span><strong> Name: '."{$fullname}".' </strong></span> <br >  
                 <span><strong> Pick Up: '."{$pick_up }".' </strong></span>   
            </div>
            <div class = "col-md-12">
             	<table class="payout_table text-center"> 
                 	<thead> 
                        <tr> 
                             <th>Sales</th>   
                             <th>3500</th> 
                             <th>700</th> 
                             <th>Total</th>
                         </tr> 
                 	</thead> 
                 	<tbody> 
                 		<tr> 
                            <td><strong>Personal</strong></td> 
                            <td> 5%   = '. $p3500total .' </td> 
                            <td> 3%   = '. $p700total .'  </td> 
                            <td> '. $totalpersonal .'  </td> 
                             
                     	</tr> 
                     	<tr> 
                            <td><strong>1st Level </strong></td> 
                            <td> 2% = '. $lvl13500total .' </td> 
                            <td> 2% = '. $lvl1700total .'  </td> 
                            <td> '. $totallvl1 .'  </td> 
                             
                     	</tr> 
                        <tr> 
                            <td><strong>2nd Level </strong></td>  
                            <td> 3% = '. $lvl23500total .' </td> 
                            <td> 1% = '. $lvl2700total .'  </td>  
                            <td> '. $totallvl2 .'  </td> 
                           
                     	</tr> 
                     	<tr> 
                            <td><strong>3rd Level </strong></td> 
                            <td> 4% = '. $lvl33500total .' </td> 
                            <td> 2% = '. $lvl3700total .' </td>  
                            <td> '. $totallvl3 .'  </td> 
                              
                     	</tr> 
                     	<tr> 
                            <td><strong>4th Level </strong></td> 
                            <td> 2% = '. $lvl43500total .' </td> 
                            <td> 2% = '. $lvl4700total .' </td> 
                            <td> '. $totallvl4 .'  </td> 
                            
                     	</tr> 
                     	<tr> 
	                        <td><strong>5th Level</strong></td> 
	                        <td> 1% = '. $lvl53500total .' </td> 
	                        <td> </td>
	                        <td> '. $totallvl5 .'  </td> 
	                          
                     	</tr> 
                     	<tr> 
	                        <td><strong>6th Level</strong></td> 
	                        <td> 1% = '. $lvl63500total .' </td> 
	                        <td> </td>
	                        <td> '. $totallvl6 .'  </td> 
	                          
                     	</tr> 
                     	<tr> 
	                        <td><strong>7th Level</strong></td> 
	                        <td> 1% = '. $lvl73500total .' </td> 
	                        <td> </td>
	                        <td> '. $totallvl7 .'  </td> 
	                          
                     	</tr> 
                     	<tr> 
	                        <td><strong>8th Level</strong></td> 
	                        <td> 1% = '. $lvl83500total .' </td> 
	                        <td> </td>
	                        <td> '. $totallvl8 .'  </td> 
	                          
                     	</tr> 
                     	<tr> 
	                        <td><strong>9th Level</strong></td> 
	                        <td> 2% = '. $lvl93500total .' </td> 
	                        <td> </td>
	                        <td> '. $totallvl9 .'  </td> 
	                          
                     	</tr>   
                    </tbody> 
             	</table>
 				<div class="col-md-12  " style="border-bottom: 2px solid #000 !important; ">
                 <h4> <strong> TOTAL: </strong>'.number_format($totalall ,2).' </h4>
                 
                </div>  
                
                <div id="unilevel" style="margin-top: 15px;">
		            <div class="col-lg-12 text-left"> 
		                <input type="hidden" name="idMember"  id="idMember" data-id="'.$uid.'">
		                <span>
		                    <strong>Natural Herbs</strong> 
		                    Tagum City<br>
		                </span> 
		                 <span><strong>Invoice Date:</strong> '."{$from}".' - '."{$to}".'
		                    </span><br >
		                 <span><strong> ID NO. : '."{$uid}".' </strong></span> <br > 
		                 <span><strong> Name: '."{$fullname}".' </strong></span> <br >  
		                 <span><strong> Pick Up: '."{$pick_up }".' </strong></span>  
		            </div>
		            <div class = "col-md-12">
		                   <h4> <strong> TOTAL: </strong>'.number_format($totalall ,2).' </h4>
		                 </div>

		            
		                <div class="col-md-12 text-center">
		                    <input type="text"  class="fix_input"   style="border-bottom: 2px solid #000 !important; border: 0; margin-bottom: 10px;">
		                    <p class="text-center">Signature Over Printed Name </p>

		                    <input type="text" class="fix_input"  style="border-bottom: 2px solid #000 !important; border: 0;   ">
		                    <p class="text-center">Date Signature </p>
		                </div>  
		            </div> 	
                <input type="hidden" name="id" id="reg" value="'. $reg .'">  
                <input type="hidden" name="datefrom" id="from" value="'. $from .'">  
                <input type="hidden" name="dateto" id="to" value="'. $to .'"> 
                <input type="hidden" name="amount" id="amount" value="'. $amount .'">  '

                ;


	echo $print;

}

function update_payout_rebates(){ 
	include ('dbconnection.php');  
	$vals = explode( ',', str_replace('"','',str_replace(' ','',($_POST['reg'])) ));

	foreach ( $vals as $val ){
			
		$sql =  $conn->query("UPDATE rebates  SET notify_payout = 'payout' WHERE reg = '$val' "); 
	}
	echo "success";
}

function update_non_maintain(){ 
	include ('dbconnection.php');  
	$id =  "'" . implode ( "', '", $_POST['uid'] ) . "'";
	$dateFrom = $_POST['dateFrom']; 
	$dateTo = $_POST['dateTo'];   
	$sql =  $conn->query(" UPDATE rebates SET notify_payout = 'payout' WHERE notify_payout = 'notify' and id IN ( $id ) and dat between '$dateFrom' and '$dateTo'   "); 
	if($sql) // will return true if succefull else it will return false
	{
		echo "success";
	} else {
		echo 'error';
	}
}













function referral_payout(){
	include ('dbconnection.php'); 

	$uid = $_POST['userid'];
	$from = date("Y-m-d", strtotime($_POST['date1'] )) ;
	$to = date("Y-m-d", strtotime($_POST['date2'] )) ;
 	
  	$reg = array();

 	$lvl13500total = 0;
 	$lvl23500total = 0;
 	$lvl33500total = 0;
 	$lvl43500total = 0;
 	$lvl53500total = 0;
 	$lvl1cnt3500 = 0;
 	$lvl2cnt3500 = 0;
 	$lvl3cnt3500 = 0;
 	$lvl4cnt3500 = 0;
 	$lvl5cnt3500 = 0;


 	$lvl1700total = 0;
 	$lvl2700total = 0;
 	$lvl3700total = 0;
 	$lvl4700total = 0;
 	$lvl5700total = 0;
 	$lvl1cnt700 = 0;
 	$lvl2cnt700 = 0;
 	$lvl3cnt700 = 0;
 	$lvl4cnt700 = 0;
 	$lvl5cnt700 = 0;


 	$totallvl1 = 0;
 	$totallvl2 = 0;
 	$totallvl3 = 0;
 	$totallvl4 = 0;
 	$totallvl5 = 0;
 	


 	$totalall = 0;


	$query0 = "SELECT * FROM member where uid='$uid'  ";
    $result0 = mysqli_query ($conn, $query0);
    while ( $row0 = mysqli_fetch_assoc($result0) ) { 
    
    	$fullname = $row0['fn'] . ' ' . $row0['mn'] . ' ' . $row0['ln'];
      	$pick_up = $row0['pick_up'];   	
    }
	 	 
    $query = "SELECT * FROM indirect where id =  '$uid' and notify_payout != 'payout' and dat between '$from' and '$to'  ";   
    $result = mysqli_query ($conn, $query); 
    while ( $row = mysqli_fetch_assoc( $result ) ) { 	

    	$reg[] = $row['reg'];
       	if( $row['one'] != 0 ){
       		if( $row['package_downline'] == 3500 ){
       			if( $row['status'] == 700 ){
       				$lvl1cnt700++;
	       			$lvl1700total += $row['one'];
       			}else{ 
		       		$lvl1cnt3500++;
		       		$lvl13500total += $row['one']; 
       			}
       		} else {
       			$lvl1cnt700++;
	       		$lvl1700total += $row['one'];
       		}
       	}
       	if( $row['two'] != 0 ){
       		if( $row['package_downline'] == 3500 ){
	       		if( $row['status'] == 700 ){
       				$lvl2cnt700++;
	       			$lvl2700total += $row['two'];
       			}else{ 
		       		$lvl2cnt3500++;
		       		$lvl23500total += $row['two']; 
       			}
       		} else {
	       		$lvl2cnt700++;
	       		$lvl2700total += $row['two']; 
       		}
       	}
       	if( $row['three'] != 0 ){
       		if( $row['package_downline'] == 3500 ){
       			if( $row['status'] == 700 ){
       				$lvl3cnt700++;
	       			$lvl3700total += $row['three'];
       			}else{ 
		       		$lvl3cnt3500++;
		       		$lvl33500total += $row['three']; 
       			}
       		} else {
       			$lvl3cnt700++;
       			$lvl3700total += $row['three']; 
       		}
       		
       	}
       	if( $row['four'] != 0 ){
       		if( $row['package_downline'] == 3500 ){ 
	       		if( $row['status'] == 700 ){
       				$lvl4cnt700++;
	       			$lvl4700total += $row['four'];
       			}else{ 
		       		$lvl4cnt3500++;
		       		$lvl43500total += $row['four']; 
       			}
       		} else {
	       		$lvl4cnt700++;
	       		$lvl4700total += $row['four']; 
       		}
       	}
       	if( $row['five'] != 0 ){
       		if( $row['package_downline'] == 3500 ){ 
	       		if( $row['status'] == 700 ){
       				$lvl5cnt700++;
	       			$lvl5700total += $row['five'];
       			}else{ 
		       		$lvl5cnt3500++;
		       		$lvl53500total += $row['five']; 
       			}
       		} else {
	       		$lvl5cnt700++;
	       		$lvl5700total += $row['five']; 
       		}
       	}
    }
 

	$totallvl1 = $lvl13500total + $lvl1700total;
	$totallvl2 = $lvl23500total + $lvl2700total;
	$totallvl3 = $lvl33500total + $lvl3700total;
	$totallvl4 = $lvl43500total + $lvl4700total;
	$totallvl5 = $lvl53500total + $lvl5700total;

	$totalall = $totallvl1 + $totallvl2 + $totallvl3 + $totallvl4 + $totallvl5;

	$reg = implode (", ", $reg);
			// echo "<pre>";
	  //  		print_r($reg);
	  //  		echo "</pre>";
	$print = '<div id="unilevel">
	            <div class="col-lg-12 text-left">
                <input type="hidden" name="idMember"  id="idMember" data-id="'.$uid.'">
                <span>
                    <strong>Natural Herbs</strong> 
                    Tagum City<br>
                </span> 
                 <span><strong>Invoice Date:</strong> '."{$from}".' - '."{$to}".'
                    </span><br >
                 <span><strong> ID NO. : '."{$uid}".' </strong></span> <br > 
                 <span><strong> Name: '."{$fullname}".' </strong></span> <br >  
                 <span><strong> Pick Up: '."{$pick_up }".' </strong></span>   
            </div>
            <div class = "col-md-12">
             	<table class="payout_table text-center"> 
                 	<thead> 
                        <tr> 
                             <th>Indirect Referrals</th>  
                             <th>3500</th> 
                             <th>700</th> 
                             <th>Total</th>
                         </tr> 
                 	</thead> 
                 	<tbody> 
                     	<tr> 
                            <td><strong>1st Level </strong></td> 
                            <td> 500 x '. $lvl1cnt3500 .' = '. $lvl13500total .' </td> 
                            <td> 100 x '. $lvl1cnt700 .' = '. $lvl1700total .'  </td> 
                            <td> '. $totallvl1 .'  </td> 
                             
                     	</tr> 
                        <tr> 
                            <td><strong>2nd Level </strong></td>  
                            <td> 150 x '. $lvl2cnt3500 .' = '. $lvl23500total .' </td> 
                            <td> 50 x '. $lvl2cnt700 .' = '. $lvl2700total .'  </td>  
                            <td> '. $totallvl2 .'  </td> 
                           
                     	</tr> 
                     	<tr> 
                            <td><strong>3rd Level </strong></td> 
                            <td> 75 x '. $lvl3cnt3500 .' = '. $lvl33500total .' </td> 
                            <td> 30 x '. $lvl3cnt700 .' = '. $lvl3700total .' </td>  
                            <td> '. $totallvl3 .'  </td> 
                              
                     	</tr> 
                     	<tr> 
                            <td><strong>4th Level </strong></td> 
                            <td> 50 x '. $lvl4cnt3500 .' = '. $lvl43500total .' </td> 
                            <td> 10 x '. $lvl4cnt700 .' = '. $lvl4700total .' </td> 
                            <td> '. $totallvl4 .'  </td> 
                            
                     	</tr> 
                     	<tr> 
	                        <td><strong>5th Level </strong></td> 
	                        <td> 25 x '. $lvl5cnt3500 .' = '. $lvl53500total .' </td> 
	                        <td> 10 x '. $lvl5cnt700 .' = '. $lvl5700total .' </td>
	                        <td> '. $totallvl5 .'  </td> 
	                          
                     	</tr>   
                    </tbody> 
             	</table>
 				<div class="col-md-12  " style="border-bottom: 2px solid #000 !important; ">
                 <h4> <strong> TOTAL: </strong>'.number_format($totalall ,2).' </h4>
                 
                </div>  
                
                <div id="unilevel" style="margin-top: 15px;">
		            <div class="col-lg-12 text-left"> 
		                <input type="hidden" name="idMember"  id="idMember" data-id="'.$uid.'">
		                <span>
		                    <strong>Natural Herbs</strong> 
		                    Tagum City<br>
		                </span> 
		                 <span><strong>Invoice Date:</strong> '."{$from}".' - '."{$to}".'
		                    </span><br >
		                 <span><strong> ID NO. : '."{$uid}".' </strong></span> <br > 
		                 <span><strong> Name: '."{$fullname}".' </strong></span> <br >  
		                 <span><strong> Pick Up: '."{$pick_up }".' </strong></span>  
		            </div>
		            <div class = "col-md-12">
		                   <h4> <strong> TOTAL: </strong>'.number_format($totalall ,2).' </h4>
		                 </div>

		            
		                <div class="col-md-12 text-center">
		                    <input type="text"  class="fix_input" id="printed_name" style="border-bottom: 2px solid #000 !important; border: 0; margin-bottom: 10px; ">
		                    <p class="text-center">Signature Over Printed Name </p>

		                    <input type="text" class="fix_input" id="printed_name" style="border-bottom: 2px solid #000 !important; border: 0;   ">
		                    <p class="text-center">Date Signature </p>
		                </div>  
		            </div> 	
                <input type="hidden" name="date" id="reg" value="'. $reg .'">  '

                ;


	echo $print;

}
 

function update_payout_referral(){ 
	include ('dbconnection.php'); 
	$vals = explode( ',', str_replace('"','',str_replace(' ','',($_POST['reg'])) ));

	foreach ( $vals as $val ){
			
		$sql =  $conn->query("UPDATE indirect  SET notify_payout = 'payout' WHERE reg = $val ");
	 	
	}
	echo "success";
}

