<?php  
if(isset($_POST['action'])){
	$function = $_POST['action'];
	$function();
}
//sponsor  | checkuser
function check_sponsor(){ 
	include "dbconnection.php"; 
	$id = (isset($_POST['sponsid'])) ?$_POST['sponsid'] : $_POST['id'] ; 
	$sql =  "SELECT fullname,id FROM member_newpackage WHERE userid =  ".$id." " ; 
	$r = mysqli_query( $conn,$sql  ); 
	$user_info = mysqli_fetch_assoc( $r );  
	if($user_info !== null){
		echo json_encode($user_info);
	}else{
		echo "fail";
	} 
}
function add_purchase(){
	include "dbconnection.php"; 
	$id = $_POST['id']; 
	$prod = $_POST['prod']; 
	$qty = $_POST['qty']; 
	$amt = $_POST['amt']; 
	$date = $_POST['date']; 
	$prodprice = $_POST['prodprice']; 

	$newDate = date("Y-m-d", strtotime($date));
	$next_payoutdate= new DateTime( $newDate); 

 	if( $next_payoutdate->format('Y-m-d') >= $next_payoutdate->format('Y-m-'.'11') && $next_payoutdate->format('Y-m-d') <= $next_payoutdate->format('Y-m-'.'25')  ){
      	//30 date
     	$next_payoutdate->modify('+1 month');
    	$next_payoutdate = $next_payoutdate->format('Y-m-'.'30');
    }else{
      	//15 date
      	$next_payoutdate->modify('+1 month'); 
    	$next_payoutdate = $next_payoutdate->format('Y-m-'.'15');
    	$next_payoutdate= new DateTime( $next_payoutdate); 
    	$next_payoutdate->modify('+1 month');
    	$next_payoutdate = $next_payoutdate->format('Y-m-'.'15'); 
    }
   
	// $sqldate =  "SELECT date_nextpayout,date_created  FROM capital WHERE userid =  ".$id." AND stat != 'done' " ;  
	// $sqldate = mysqli_query( $conn,$sqldate  ); 
	// $row = mysqli_fetch_assoc( $sqldate );  
	// $date_created = $row['date_created'];
	// $date_nextpayout = $row['date_nextpayout'];
 
	// if (($newDate >= $date_created) && ($newDate <= $date_nextpayout)){
	//     $next_payoutdate = $date_nextpayout;
	// }else{
	//     $next_payoutdate = $date_nextpayout
	// }
	// exit;
	
	$sql = "INSERT INTO new_purchase ( pid,id,price,dat,next_datepayout,qty,amt,status_new,notify_payout ) VALUES ('$prod','$id','$prodprice','$newDate', '$next_payoutdate','$qty','$amt','2500','notify' )"; 
	if ($conn->query($sql) === TRUE) {   
		echo "Success purchase added";   
	} else {
		echo "Error. User not created";
	}
}

function check_userid_tbpin(){
	include "dbconnection.php"; 
	$id = $_POST['userid'];
	$sql =  "SELECT *  FROM tbpin WHERE id =  ".$id." AND status = '2500'    " ;  
	$r = mysqli_query( $conn,$sql  ); 
	$user_info = mysqli_fetch_assoc( $r );  
	if($user_info !== null){
		echo json_encode($user_info);
	}else{
		echo "fail";
	} 
}

function create_user(){
	include("dbconnection.php");
	$sponsid = $_POST['sponsid'] ;
    $fullname = $_POST['fullname'] ;  
    $address = $_POST['address'] ;  
    $phone = $_POST['phone'] ;  
    $check_userid = $_POST['check_userid'] ;  
    $pick_up = $_POST['pick_up'] ;  
    $date_data = $_POST['date'] ; 
    $newDate = date("Y-m-d", strtotime($date_data));
	$next_payoutdate= new DateTime( $newDate); 

	if( $next_payoutdate->format('Y-m-d') >= $next_payoutdate->format('Y-m-'.'11') && $next_payoutdate->format('Y-m-d') <= $next_payoutdate->format('Y-m-'.'25')  ){
		//30 date
		$next_payoutdate->modify('+1 month');
	$next_payoutdate = $next_payoutdate->format('Y-m-'.'30');
	}else{
		//15 date
		$next_payoutdate->modify('+1 month'); 
	$next_payoutdate = $next_payoutdate->format('Y-m-'.'15');
	$next_payoutdate= new DateTime( $next_payoutdate); 
	$next_payoutdate->modify('+1 month');
	$next_payoutdate = $next_payoutdate->format('Y-m-'.'15'); 
	}

    $sql = "INSERT INTO member_newpackage (sponsor_id,fullname,address,phone,userid,pick_up_place,status,date_created, next_datepayout  ) VALUES ('$sponsid','$fullname','$address','$phone','$check_userid','$pick_up', '2500','$newDate','$next_payoutdate')";
    
	if ($conn->query($sql) === TRUE) { 
		$conn->query("UPDATE tbpin SET stat = 'used' WHERE id = '$check_userid' ;");
		echo "Success create user";   
	} else {
		echo "Error. User not created";
	}

}
 

function edit_user(){ 
	include("dbconnection.php"); 
	$id = $_POST['id']; 
	$sql =  "SELECT * FROM member_newpackage WHERE userid =  ".$id." " ; 
	$r = mysqli_query( $conn,$sql  ); 
	$user_info = mysqli_fetch_assoc( $r ); 
 	echo  json_encode($user_info);
}

function save_user_edit(){ 
	include("dbconnection.php"); 
	$userid = $_POST['userid'];
	$fullname = $_POST['fullname'];
	$phone = $_POST['phone'];
	$pickplace = $_POST['pickplace']; 
	$adress = $_POST['adress']; 
 	$date = $_POST['date'];  
 	 
 	$res = $conn->query("UPDATE member_newpackage SET fullname ='".$fullname."' ,phone ='".$phone."', pick_up_place ='".$pickplace."', address ='".$adress."', date_created ='".$date."'   WHERE userid ='".$userid."'");
 	if($res){
 		echo "success";
 	}
}
function add_capital(){
	include("dbconnection.php"); 
	$userid = $_POST['userid']; 
	$capital = $_POST['capital']; 
	$date = $_POST['date'];  
	$newDate = date("Y-m-d", strtotime($date));
 
	$count = 0;

    //first
    $next_first_months= new DateTime( $newDate);   
    
 	if( $next_first_months->format('Y-m-d') >= $next_first_months->format('Y-m-'.'11') && $next_first_months->format('Y-m-d') <= $next_first_months->format('Y-m-'.'25')  ){
      	//30 date
     	$next_first_months->modify('+1 month');
    	$next_first_months = $next_first_months->format('Y-m-'.'30');
    	$sql = $conn->query("INSERT INTO capital (userid,capital,date_created, date_nextpayout,counting) VALUES ('$userid','$capital','$newDate' , '$next_first_months', '1')");
    	$count++;
    }else{
      	//15 date
      	// $next_first_months->modify('+1 month'); 
    	$next_first_months = $next_first_months->format('Y-m-'.'15');
     
      	// if( date('d', strtotime($newDate) )  >= 26 && date('d', strtotime($newDate) <= 31) ){
	      	$next_first_months= new DateTime( $next_first_months); 
	    	$next_first_months->modify('+1 month');
	    	$next_first_months = $next_first_months->format('Y-m-'.'15');
	    	$sql = $conn->query("INSERT INTO capital (userid,capital,date_created, date_nextpayout,counting) VALUES ('$userid','$capital','$newDate' , '$next_first_months', '1')");
	    	$count++;
      	// } 
    } 

    //second
    $next_second_months= new DateTime( $newDate);  
 	if( $next_second_months->format('Y-m-d') >= $next_second_months->format('Y-m-'.'11') && $next_second_months->format('Y-m-d') <= $next_second_months->format('Y-m-'.'25')  ){
      	//30 date
     	$next_second_months->modify('+2 month');
    	$next_second_months = $next_second_months->format('Y-m-'.'30');

    	$sql = $conn->query("INSERT INTO capital (userid,capital,date_created, date_nextpayout,counting) VALUES ('$userid','$capital','$newDate' , '$next_second_months', '2')");
    	$count++;
    }else{
      	//15 date
     //  	$next_second_months->modify('+2 month'); 
    	// $next_second_months = $next_second_months->format('Y-m-'.'15');
     //  	if( date('d', strtotime($newDate) )  >= 26 && date('d', strtotime($newDate) <= 31) ){
	      	$next_second_months= new DateTime( $newDate); 
	    	$next_second_months->modify('+2 month');
	    	$next_second_months = $next_second_months->format('Y-m-'.'15');
	    	$sql = $conn->query("INSERT INTO capital (userid,capital,date_created, date_nextpayout,counting) VALUES ('$userid','$capital','$newDate' , '$next_second_months', '2')");
	    	$count++;
      	// } 
    } 

    //third
    $next_third_months= new DateTime( $newDate);  
 	if( $next_third_months->format('Y-m-d') >= $next_third_months->format('Y-m-'.'11') && $next_third_months->format('Y-m-d') <= $next_third_months->format('Y-m-'.'25')  ){
      	//30 date
     	$next_third_months->modify('+3 month');
    	$next_third_months = $next_third_months->format('Y-m-'.'30');
    	$sql = $conn->query("INSERT INTO capital (userid,capital,date_created, date_nextpayout,counting) VALUES ('$userid','$capital','$newDate' , '$next_third_months', '3')");
    	$count++;
    }else{
      	//15 date
     //  	$next_third_months->modify('+3 month'); 
    	// $next_third_months = $next_third_months->format('Y-m-'.'15');
     //  	if( date('d', strtotime($newDate) )  >= 26 && date('d', strtotime($newDate) <= 31) ){
	      	$next_third_months= new DateTime( $newDate); 
	    	$next_third_months->modify('+3 month');
	    	$next_third_months = $next_third_months->format('Y-m-'.'15');
	    	$sql = $conn->query("INSERT INTO capital (userid,capital,date_created, date_nextpayout,counting) VALUES ('$userid','$capital','$newDate' , '$next_third_months', '3')");
	    	$count++;
      	// } 
    } 

    //forth
    $next_forth_months= new DateTime( $newDate);  
 	if( $next_forth_months->format('Y-m-d') >= $next_forth_months->format('Y-m-'.'11') && $next_forth_months->format('Y-m-d') <= $next_forth_months->format('Y-m-'.'25')  ){
      	//30 date
     	$next_forth_months->modify('+4 month');
    	$next_forth_months = $next_forth_months->format('Y-m-'.'30');
    	$sql = $conn->query("INSERT INTO capital (userid,capital,date_created, date_nextpayout,counting) VALUES ('$userid','$capital','$newDate' , '$next_forth_months', '4')");
    	$count++;
    }else{
      	//15 date
     //  	$next_forth_months->modify('+4 month'); 
    	// $next_forth_months = $next_forth_months->format('Y-m-'.'15');
     //  	if( date('d', strtotime($newDate) )  >= 26 && date('d', strtotime($newDate) <= 31) ){
	      	$next_forth_months= new DateTime( $newDate); 
	    	$next_forth_months->modify('+4 month');
	    	$next_forth_months = $next_forth_months->format('Y-m-'.'15');
	    	$sql = $conn->query("INSERT INTO capital (userid,capital,date_created, date_nextpayout,counting) VALUES ('$userid','$capital','$newDate' , '$next_forth_months', '4')");
	    	$count++;
      	// } 
    } 

    //fifth
    $next_fifth_months= new DateTime( $newDate);  
 	if( $next_fifth_months->format('Y-m-d') >= $next_fifth_months->format('Y-m-'.'11') && $next_fifth_months->format('Y-m-d') <= $next_fifth_months->format('Y-m-'.'25')  ){
      	//30 date
     	$next_fifth_months->modify('+5 month');
    	$next_fifth_months = $next_fifth_months->format('Y-m-'.'30');
    	$sql = $conn->query("INSERT INTO capital (userid,capital,date_created, date_nextpayout,counting) VALUES ('$userid','$capital','$newDate' , '$next_fifth_months', '5')");
    	$count++; 
    }else{
      	//15 date
     //  	$next_fifth_months->modify('+5 month'); 
    	// $next_fifth_months = $next_fifth_months->format('Y-m-'.'15');
     //  	if( date('d', strtotime($newDate) )  >= 26 && date('d', strtotime($newDate) <= 31) ){
	      	$next_fifth_months= new DateTime( $newDate); 
	    	$next_fifth_months->modify('+5 month');
	    	$next_fifth_months = $next_fifth_months->format('Y-m-'.'15');
	    	$sql = $conn->query("INSERT INTO capital (userid,capital,date_created, date_nextpayout,counting) VALUES ('$userid','$capital','$newDate' , '$next_fifth_months', '5')");
	    	$count++;
      	// } 
    }  

	
print_r($count);
	exit;
	if ( $count  === 5) {  
		echo "Success added capital";   
	} else {
		echo "Failed";
	}

}

function show_payout(){
	include("dbconnection.php"); 
	$id = $_POST['userid']; 

	$cap_id = (isset($_POST['id']))? $_POST['id'] : ''; 
	// $date1 = $_POST['date1']; 
	// $date2 = $_POST['date2']; 
	$date_payout = (isset($_POST['date_payout']))? $_POST['date_payout'] : ''; 
	   $idr=0; 
                        
                         
                        $mainsumpurchase2500 = 0;
                         

                        $lvl0PS2500 = 0;
                        $lvl1PS2500 = 0;
                         
                        
                        $lvl1indi2500 = 0;
                        $lvl2indi2500 = 0; 

                        $main_2500 = 0;
                        $value_main_purchase_2500 = 0;
                        $sumindirect_2500 = 0;
                        $lvl1_2500 = 0; 

                        $indirect_1_2500 = 0;
                        $indirect_2_2500 = 0; 

                        $count1new = 0;
                        $count2new = 0;
                        $count3new = 0;
                        $count4new = 0;
                        $count5new = 0; 
                        $count12500 = 0;
                        $count22500 = 0;
                        
                        $value_750bonus_2500 = 0;
                        $value_capital_2500 = 0;
                        $capi_2500 = 0;
						$bonus_2500 = 0;
                      	$capital_inve = 0; 

                        $first = mysqli_fetch_assoc(mysqli_query ($conn,"SELECT status_new  FROM member where uid='$id' ")); 
                        $first_stat = $first['status_new'];
                           
                        
                        $personal0 = mysqli_query ($conn,"SELECT  amt , status_new  FROM new_purchase where id='$id' and status_new = '2500' "); 
                        while( $personal0row = mysqli_fetch_assoc($personal0)){ 
                        	$lvl0PS2500 += $personal0row['amt'];   
                        }
                       
                        $indirect1 = mysqli_query ($conn,"SELECT userid  , status FROM member_newpackage WHERE sponsor_id = '$id' and status = '2500' "); 
                        while( $indirect1row = mysqli_fetch_assoc($indirect1)){  
                            $count12500++;   
                        }
                     	
                        $sql="SELECT * FROM member_newpackage where sponsor_id='$id'  ";
                        $result = mysqli_query($conn,$sql);
                        while($row = mysqli_fetch_array($result)) {
              
	                        $hid1=$row['userid']; 

	                        $personal1 = mysqli_query ($conn,"SELECT  amt , status_new  FROM new_purchase where id='$hid1' and status_new = '2500' "); 
	                        while( $personal1row = mysqli_fetch_assoc($personal1)){ 
	                            $lvl1PS2500 += $personal1row['amt'];    
	                        } 
	                        $indirect2 = mysqli_query ($conn,"SELECT userid   FROM member_newpackage WHERE sponsor_id = '$hid1' and status = '2500' "); 
	                        while( $indirect2row = mysqli_fetch_assoc($indirect2)){
	                            
	                            $count22500++;  
	                                
	                        } 
                        } 
                                 
						$sql = "SELECT * FROM member_newpackage WHERE userid = '$id' ";
						  $result=$conn->query($sql);

						  	while($row=$result->fetch_assoc()) { 
						      	$fullname= $row['fullname'] ;
						      	$pick_up = $row['pick_up_place'];
						      	$address = $row['address']; 
						   	} 
						$query = "SELECT  uid,main_purchase as main,level_1 as lvl1, indirect_1 as indirect1,indirect_2 as indirect2,  status_new , invest_capital as cap , 750_bonus as bonus  FROM admin_withdraw where uid =  '".$id."' and status_new = '2500' "; 
						$result2 = mysqli_query ($conn, $query); 
						    while ($getrow = mysqli_fetch_assoc($result2)) {  
					            $uid_2500  = $getrow['uid'];
					            $main_2500 += $getrow['main'];
					            $lvl1_2500 += $getrow['lvl1'];
				             	$indirect_1_2500 += $getrow['indirect1'];
					            $indirect_2_2500 += $getrow['indirect2'];
					            // $capi_2500 += $getrow['cap'];
					            // $bonus_2500 += $getrow['bonus'];
						    }

						//700    
					    $_750bonus = mysqli_query($conn,"SELECT SUM(qty) as sum_qty FROM new_purchase WHERE id = $id and payout_stat != 'done'");  
					  	$cnt_750bonus = mysqli_fetch_assoc($_750bonus); 
					  	$cnt_750bonus = ( isset($cnt_750bonus['sum_qty']) )? $cnt_750bonus['sum_qty'] : 0;
					    //capital 
					    // $date_from= date("Y-m-d", strtotime($date1)); 
					    // $date_to= date("Y-m-d", strtotime($date2)); 
					    
					    $capital_inve = mysqli_query($conn,"SELECT *  FROM capital WHERE userid = '$id' and id='$cap_id' and stat !='done' ");
					    // $capitalid = array(); 
					    
					    $cap_total =0;
					    $capital_id = 0;
					    if( !isset($$cap_id) ){
					    	while ($capital_inves = mysqli_fetch_array($capital_inve)) {   
						  		$cap_total  += $capital_inves['capital'];
						  			 
						  		$capital_id= $capital_inves['id'];

						  	}
					    }
					  	
					 
					  // print_r($cap_total);
					    
					    
					    //end capital

						// $ec_d = $_POST['date1']  ; 
						// $ec_d = date("M jS, Y", strtotime($ec_d));
						// $ec_d2= $_POST['date2'];
						// $ec_d2 = date("M jS, Y", strtotime($ec_d2));  
						
						// 2500 
						$mainsumpurchase2500 = ($lvl0PS2500-$main_2500) ;
						$lvl1PS2500 = (floor($lvl1PS2500)-floor($lvl1_2500))  ; 
						 
						$sumindirect_2500 = $count12500-$indirect_1_2500  ;
						$lvl2indi2500 = $count22500-$indirect_2_2500  ; 

						// $value_capital_2500 = $cap_total-$capi_2500  ; 
						// $value_750bonus_2500 = $cnt_750bonus-$bonus_2500  ;

						$value_main_purchase_2500 = $mainsumpurchase2500*0.05;
						$value_unli_sum1_2500 = $lvl1PS2500*0.02; 

						$value_indi_1st_2500 = $sumindirect_2500 * 500;
						$value_indi_2nd_2500 = $lvl2indi2500 * 200;  

                        $capital_inve_total = $cap_total * 0.15;
                       	
                       	if( $cap_total == 0 ){
                       		$cnt_750bonus = 0;
                       		$_750bonus =  0;
                       	}else{
                       		if( $cnt_750bonus >= 10 ){
	                        	$_750bonus =   0;
	                        }else {
	                        	$_750bonus =   -750;
	                        } 
                       	}
                        
						// End 2500

						 
						// total 
						 
						$total_value =  $value_main_purchase_2500 + $value_unli_sum1_2500 + $value_indi_1st_2500  + $value_indi_2nd_2500 + $_750bonus + $capital_inve_total; 
                          

				$print = '<div id="unilevel">
                            <div class="col-lg-12 text-left">
                                <input type="hidden" name="idMember"  id="idMember" data-id="'.$id.'">
                                <span>
                                    <strong>Natural Herbs</strong> 
                                    Tagum City<br>
                                </span> 
                                 <span><strong>Payout Date:</strong> '. $date_payout . '
                                    </span><br >
                                 <span><strong> ID NO. : '."{$id}".' </strong></span> <br > 
                                 <span><strong> Name: '."{$fullname}".' </strong></span> <br >  
                                 <span><strong> Pick Up: '."{$pick_up }".' </strong></span>   
                            </div>
                            <div class = "col-md-12">
                                 <table class="payout_table  table"> 
                                     <thead> 
                                        <tr> 
                                             <th>Indirect Referrals</th>   
                                             <th>2500</th> 
                                             <th>Total</th>
                                         </tr> 
                                     </thead> 
                                     <tbody> 
                                         <tr> 
                                            <td>1st Level <strong></strong></td>  
                                            <td> 500 x '. $sumindirect_2500 .'   </td> 
                                            <td> '. $value_indi_1st_2500 .'  </td> 
                                             
                                         </tr> 
                                         <tr> 
                                            <td>2nd Level <strong></strong></td>   
                                            <td> 200 x '. $lvl2indi2500 .'   </td>  
                                            <td> '. $value_indi_2nd_2500 .'  </td> 
                                           
                                         </tr>  
                                    </tbody> 
                                 </table>
                                 <table class="payout_table   table" id="unilvl_bonus2"> 
                                     <thead> 
                                        <tr> 
                                             <th>Personal Sales</th>   
                                             <th>2500</th> 
                                             <th>Total</th> 
                                         </tr> 
                                     </thead> 
                                     <tbody>
                                         <tr> 
                                             <td>Personal </td>  
                                             <td><strong>5%</strong> x '.$mainsumpurchase2500.'</td>  
                                             <td>'.number_format($value_main_purchase_2500,2).'</td>   
                                         </tr>
                                         <tr> 
                                             <td>1st Level </td>  
                                             <td><strong>2%</strong> x '.$lvl1PS2500.'</td>  
                                             <td>'.number_format($value_unli_sum1_2500,2).'</td>   
                                         </tr>  
                                    </tbody> 
                                 </table>
                                 <table class="payout_table   table" id="maintenance"> 
                                     <thead> 
                                        <tr> 
                                             <th>Maintenance</th>   
                                             <th>Quantity</th> 
                                             <th>Bonus</th> 
                                         </tr> 
                                     </thead> 
                                     <tbody>
                                         <tr> 
                                             <td>Maintain </td>  
                                             <td>  '.$cnt_750bonus.'</td>  
                                             <td>'.$_750bonus .'</td>   
                                         </tr> 
                                    </tbody> 
                                 </table>
                                 <table class="payout_table   table" id="capital_inveasd"> 
                                     <thead> 
                                        <tr> 
                                             <th>Capital</th>   
                                             <th>Capital Invest</th> 
                                             <th>Total</th> 
                                         </tr> 
                                     </thead> 
                                     <tbody>
                                         <tr> 
                                             <td>Invest </td>  
                                             <td> 15% x '.$cap_total .' </td>  
                                             <td>'.$capital_inve_total .'</td>   
                                         </tr> 
                                    </tbody> 
                                 </table>
                                 </div> 
                                <div class="col-md-12  " style="border-bottom: 2px solid #000 !important; ">
                                 <h4> <strong> TOTAL: </strong>'.number_format($total_value ,2).' </h4>
                                 
                                </div>  
                                 
                            </div>
                            
                            <div id="unilevel" style="margin-top: 30px;">
                            <div class="col-lg-12 text-left"> 
                                <input type="hidden" name="idMember"  id="idMember" data-id="'.$id.'">
                                <span>
                                    <strong>Natural Herbs</strong> 
                                    Tagum City<br>
                                </span> 
                                 <span><strong>Invoice Date:</strong> '.$date_payout.'
                                    </span><br >
                                 <span><strong> ID NO. : '."{$id}".' </strong></span> <br > 
                                 <span><strong> Name: '."{$fullname}".' </strong></span> <br >  
                                 <span><strong> Pick Up: '."{$address }".' </strong></span>  
                            </div>
                            <div class = "col-md-12">
                                   <h4> <strong> TOTAL: </strong>'.number_format($total_value ,2).' </h4>
                                 </div>

                            <div class = "row">
                            	<div class="col-md-4  ">
                            	</div>
                            	<div class="col-md-4  ">
                                    <input type="text"  class="form-control " id="printed_name" style="border-bottom: 2px solid #000 !important; border: 0; margin-bottom: 10px; ">
                                    <p class="text-center">Signature Over Printed Name </p>

                                    <input type="text" class="form-control " id="printed_name" style="border-bottom: 2px solid #000 !important; border: 0;   ">
                                    <p class="text-center">Date Signature </p>
                                </div> 
                                <div class="col-md-4  ">
                            	</div> 
                            </div>
                                
                            </div>
                            
                            <input type="hidden" name="first_stat" id="first_stat" value="'. $first_stat.'">  
                            <input type="hidden" name="lvl1_in2500" id="lvl1_in2500" value="'.$sumindirect_2500.' "> 
                            <input type="hidden" name="lvl2_in2500" id="lvl2_in2500" value="'.$lvl2indi2500.' ">  
                            <input type="hidden" name="cap_id" id="cap_id" value="'.$cap_id .' ">  
                            <input type="hidden" name="mainpur2500" id="mainpur2500" value="'.$mainsumpurchase2500.'"> 
                            <input type="hidden" name="lvl12500" id="lvl12500" value="'.$lvl1PS2500.'"> 
                             <input type="hidden" name="capital_id" id="capital_id" value="'.$capital_id.'"> 
                         	<input type="hidden" name="cnt_750bonus" id="cnt_750bonus" value="'.$cnt_750bonus.'"> 
                            <input type="hidden" name="capital_inve" id="capital_inve" value="'.$cap_total.'">  
                            <input type="hidden" name="total" id="total" value="'.$total_value .'">  ';

        echo $print;                    

}


function finish_submit_payout(){
include("dbconnection.php");  
 	$uid = $_POST['userid']; 

 	$main_purchase2500 = $_POST['mainpur2500'];
 	$level_12500 = $_POST['lvl12500'];
  
 	$indirect_12500 = $_POST['lvl1_in2500'];
 	$indirect_22500 = $_POST['lvl2_in2500'];
 
	$cnt_750bonus = ( isset($_POST['cnt_750bonus'])  )? $_POST['cnt_750bonus'] : 0;
 	$cap_inves = $_POST['capital_inve'];
 	$total_value = $_POST['total'];  
 	$today = date("Y-m-d");
 	
 	$cap_id = $_POST['cap_id'];
 
		$results3 = $conn->query("UPDATE capital SET stat='done', payout_stat='done'  where id =  ".$cap_id."  "); 
	 
	 
    $insert2 = $conn->query("INSERT INTO admin_withdraw (uid,main_purchase,level_1 ,indirect_1,indirect_2     ,status_new) VALUES('$uid','$main_purchase2500','$level_12500' ,'$indirect_12500','$indirect_22500'  ,'2500' )"); 

 	$results2 = $conn->query("UPDATE new_purchase SET notify_payout='', payout_stat='done' where id =  '$uid'  ");
 	// $results3 = $conn->query("UPDATE capital SET 	stat='done' where userid =  '$uid'  ");


  if( $insert2 || $results2   ){
  	echo "Success"; 
  }  else {
  	echo "Failed";
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


function admin_payout_function(){
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
       		if( $row['status'] == 3500 ){
	       		$lvl1cnt3500++;
	       		$lvl13500total += $row['one']; 
       		} else {
       			$lvl1cnt700++;
	       		$lvl1700total += $row['one'];
       		}
       	}
       	if( $row['two'] != 0 ){
       		if( $row['status'] == 3500 ){
	       		$lvl2cnt3500++;
	       		$lvl23500total += $row['two']; 
       		} else {
	       		$lvl2cnt700++;
	       		$lvl2700total += $row['two']; 
       		}
       	}
       	if( $row['three'] != 0 ){
       		if( $row['status'] == 3500 ){
       			$lvl3cnt3500++;
       			$lvl33500total += $row['three'];
       		} else {
       			$lvl3cnt700++;
       			$lvl3700total += $row['three']; 
       		}
       		
       	}
       	if( $row['four'] != 0 ){
       		if( $row['status'] == 3500 ){ 
	       		$lvl4cnt3500++;
	       		$lvl43500total += $row['four'];
       		} else {
	       		$lvl4cnt700++;
	       		$lvl4700total += $row['four']; 
       		}
       	}
       	if( $row['five'] != 0 ){
       		if( $row['status'] == 3500 ){ 
	       		$lvl5cnt3500++;
	       		$lvl53500total += $row['five'];
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
                            <td>1st Level <strong></strong></td> 
                            <td> 500 x '. $lvl1cnt3500 .' = '. $lvl13500total .' </td> 
                            <td> 100 x '. $lvl1cnt700 .' = '. $lvl1700total .'  </td> 
                            <td> '. $totallvl1 .'  </td> 
                             
                     	</tr> 
                        <tr> 
                            <td>2nd Level <strong></strong></td>  
                            <td> 150 x '. $lvl2cnt3500 .' = '. $lvl23500total .' </td> 
                            <td> 50 x '. $lvl2cnt700 .' = '. $lvl2700total .'  </td>  
                            <td> '. $totallvl2 .'  </td> 
                           
                     	</tr> 
                     	<tr> 
                            <td>3rd Level <strong></strong></td> 
                            <td> 75 x '. $lvl3cnt3500 .' = '. $lvl33500total .' </td> 
                            <td> 30 x '. $lvl3cnt700 .' = '. $lvl3700total .' </td>  
                            <td> '. $totallvl3 .'  </td> 
                              
                     	</tr> 
                     	<tr> 
                            <td>4th Level <strong></strong></td> 
                            <td> 50 x '. $lvl4cnt3500 .' = '. $lvl43500total .' </td> 
                            <td> 10 x '. $lvl4cnt700 .' = '. $lvl4700total .' </td> 
                            <td> '. $totallvl4 .'  </td> 
                            
                     	</tr> 
                     	<tr> 
	                        <td>5th Level <strong></strong></td> 
	                        <td> 25 x '. $lvl5cnt3500 .' = '. $lvl53500total .' </td> 
	                        <td> 10 x '. $lvl5cnt700 .' = '. $lvl5700total .' </td>
	                        <td> '. $totallvl5 .'  </td> 
	                          
                     	</tr>   
                    </tbody> 
             	</table>
 				<div class="col-md-12  " style="border-bottom: 2px solid #000 !important; ">
                 <h4> <strong> TOTAL: </strong>'.number_format($totalall ,2).' </h4>
                 
                </div>  
                
                <div id="unilevel" style="margin-top: 80px;">
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

		            
		                <div class="col-md-12 text-left">
		                    <input type="text"  class="fix_input" id="printed_name" style="border-bottom: 2px solid #000 !important; border: 0; margin-bottom: 10px;margin-left: 350px;">
		                    <p class="text-center">Signature Over Printed Name </p>

		                    <input type="text" class="fix_input" id="printed_name" style="border-bottom: 2px solid #000 !important; border: 0;  margin-left: 350px;">
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

function get_username(){ 
	include ('dbconnection.php'); 
	$uname = $_POST['uname'];
	$data = array();

	$sql="SELECT * FROM member WHERE uname = '".$uname."'";
	$result = mysqli_query($conn,$sql);
	$row_cnt = mysqli_num_rows($result);
	
		while($row = mysqli_fetch_array($result)) { 
			if( $row_cnt >= 0 ){
				$data['fn'] = $row['fn'] .' '. $row['mn'] .' '.$row['ln'];  
				$data['id'] = $row['uid'];
			} else { 
				$data['fn']="0";
			}
			
		}
	 
	echo json_encode( $data ); 

}

function register(){
	include ('dbconnection.php'); 
	print_r($_POST);
	$kit = $_POST['kit'];
	$sid = $_POST['sid'];
	$fname = $_POST['fname'];
	$mname = $_POST['mname'];
	$lname = $_POST['lname'];
	$ad = $_POST['ad'];
	$phone = $_POST['phone'];
	$user_id = $_POST['user_id'];
	$pick_up = $_POST['pick_up'];

	
}