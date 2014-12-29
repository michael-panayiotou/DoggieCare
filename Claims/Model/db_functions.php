<?php 
//connecting to db function
function users_db_connect(){

$db = new PDO('mysql:host=localhost;dbname=puppymaker;charset=utf8', 'root', 'root');
return $db;
}
function fetchUserData($loginKey){
	$db=users_db_connect();
		
	foreach($db->query("SELECT * FROM registration WHERE login_key='$loginKey'") as $row) 
	{
			$dataArray[0]=$row['fullname'];
			$dataArray[1]=$row['username'];
			$dataArray[2]=$row['email'];
			$dataArray[3]=$row['phone'];
			$dataArray[4]=$row['address'];
			$dataArray[5]=$row['fb_url'];
			$dataArray[6]=$row['city'];
			$dataArray[7]=$row['message'];
			$dataArray[8]=$row['gender'];
			$dateArray[9]=$row['age'];
			$dataArray[10]=$row['userid'];
    		
	}
	return $dataArray;
}
function fetchOfferData($userid){
	
	$db=users_db_connect();
	$count=0;
		
	foreach($db->query("SELECT * FROM offers WHERE userid_fgn='$userid'") as $row) 
	{
			$offerArray[$count][0]=$row['offerid'];
			$offerArray[$count][1]=$row['offername'];
			$offerArray[$count][2]=$row['userid_fgn'];
			$offerArray[$count][3]=$row['date'];
			$offerArray[$count][4]=$row['start_time'];
			$offerArray[$count][5]=$row['finish_time'];
			$offerArray[$count][6]=$row['location'];
			$offerArray[$count][7]=$row['reward'];
			$offerArray[$count][8]=$row['usertype'];
			$offerArray[$count][9]=$row['description'];
			$count++;
    		
	}
	
	return $offerArray;
}
function fetchRequestedOffers($username,$userid){
	
	$db=users_db_connect();
	$count=0;	
	foreach($db->query("SELECT * FROM registration,offers,requests WHERE userid_fgn='$userid' and userid='$userid' and to_user='$username' and offerid=offer_id_fgn and accepted='0'") as $row) 
	{
			$offerArray[$count][0]=$row['offerid'];
			$offerArray[$count][1]=$row['offername'];
			$offerArray[$count][2]=$row['userid_fgn'];
			$offerArray[$count][3]=$row['date'];
			$offerArray[$count][4]=$row['start_time'];
			$offerArray[$count][5]=$row['finish_time'];
			$offerArray[$count][6]=$row['location'];
			$offerArray[$count][7]=$row['reward'];
			$offerArray[$count][8]=$row['usertype'];
			$offerArray[$count][9]=$row['description'];
			$offerArray[$count][10]=$row['username'];
			$offerArray[$count][11]=$row['from_user'];
			$offerArray[$count][12]=$row['request_id'];
			$count++;
    		
	}
	
	return $offerArray;
}
function fetchAcceptedOffers($username,$userid){
	
	$db=users_db_connect();
	$count=0;	
	foreach($db->query("SELECT * FROM registration,offers,requests WHERE userid_fgn='$userid' and userid='$userid' and to_user='$username' and offerid=offer_id_fgn and accepted=1") as $row) 
	{
			$offerArray[$count][0]=$row['offerid'];
			$offerArray[$count][1]=$row['offername'];
			$offerArray[$count][2]=$row['userid_fgn'];
			$offerArray[$count][3]=$row['date'];
			$offerArray[$count][4]=$row['start_time'];
			$offerArray[$count][5]=$row['finish_time'];
			$offerArray[$count][6]=$row['location'];
			$offerArray[$count][7]=$row['reward'];
			$offerArray[$count][8]=$row['usertype'];
			$offerArray[$count][9]=$row['description'];
			$offerArray[$count][10]=$row['username'];
			$offerArray[$count][11]=$row['from_user'];
			$offerArray[$count][12]=$row['request_id'];
			$offerArray[$count][13]=$row['rating'];
			$count++;
    		
	}
	
	return $offerArray;
}
function getemail($value){
	//$_SESSION['username'];
	$entry=getuserdate($value);
	

	 
	

}

function updateRequestedtoAccepted($offer_id){
		
	$zero=1;
	$db=users_db_connect();
	//
		//
		//UPDATE `registration` SET `fullname`='riginos samaras',`phone`='99115166',`address`='Hrakleous 5 agia zoni',`FB_url`='psylis.facebook.com',`city`='Limmasol',`dateofbirth_day`='13',`dateofbirth_month`='5',`dateofbirth_year`='1992',`note`='nothing to do',`gender`='0' WHERE `username`='samaras'

	$sql = "UPDATE requests SET accepted=:zero where request_id=:id" ;
	$q = $db->prepare($sql);
	$q->execute(array(':zero'=>$zero,
						':id'=>$offer_id					
	));
	if(!$q){
		die('error'.$e->getMessage());
	}
}

function validateoffer($offername){
	if($offername!="walking"&&$offername!="sitting"&&$offername!="cleaning"){
		return 0;
	}
	else{
		return 1;
	}
	
}
function validatebiscuits($biscuits){
	$goodbiscuits= ereg('^([1-9])([0-9]{0,2})$',$biscuits);
	if($goodbiscuits=="")
	{$goodbiscuits=0;}
	return $goodbiscuits;	
}
function  validateusertype($theoffer){
	$goodoffer=0;
	if(($theoffer=="consumer")||($theoffer=="provider")){
		$goodoffer=1;
	}
	return $goodoffer;
}

function validatedatepicker($datepicker){
	$gooddatepicker= ereg('(01|02|03|04|05|06|07|08|09|10|11|12)/(01|02|03|04|05|06|07|08|09|10|11|12|13|14|15|16|17|18|19|20|21|22|23|24|25|26|27|28|29|30|31)/2014',$datepicker);
	if($gooddatepicker=="")
		{$gooddatepicker=0;}
	return $gooddatepicker;	
}

function validatelocation($location){
	$goodlocation= ereg('^([a-zA-Z]{3,16} ?){1,5}$',$location);
	if($goodlocation=="")
		{$goodlocation=0;}
	return $goodlocation;	
}
function validatedescription($description){
	$gooddescription= ereg('^.{1,200}.{0,200}.{0,197}$',$description);
	if($gooddescription=="")
		{$gooddescription=0;}
	return $gooddescription;	
}
function changetimes($starttime,$finishtime){
	$startPM=ereg('.*PM$',$starttime);
	$finishPM=ereg('.*PM$',$finishtime);
	$startarray=preg_split( "/(:| )/", $starttime );
	$finisharray=preg_split( "/(:| )/", $finishtime );
	if($startPM){
		$plustwelve1=$startarray[0]+12;
		$donestarttime="$plustwelve1:$startarray[1]:00";
	}
	else {
		$donestarttime="$startarray[0]:$startarray[1]:00";
	}
	if($finishPM){
		$plustwelve2=$finisharray[0]+12;
		$donefinishtime="$plustwelve2:$finisharray[1]:00";
	}
	else {
		$donefinishtime="$finisharray[0]:$finisharray[1]:00";
	}
	$timearray[0]=$donestarttime;
	$timearray[1]=$donefinishtime;
	return $timearray;
}

function changedate($datepicker){
	//$beforedate=explode('$foo',$str);
	$month="$datepicker[0]$datepicker[1]";
	$day="$datepicker[3]$datepicker[4]";
	$year="$datepicker[6]$datepicker[7]$datepicker[8]$datepicker[9]";
	$afterdate="$year-$month-$day";
	echo "%$afterdate $year$month$day";
	return $afterdate;
}

function biggerStartTime($starttime,$finishtime){
	$startarray=preg_split( "/(:| )/", $starttime );
	$finisharray=preg_split( "/(:| )/", $finishtime );
	$valstart="$startarray[0]$startarray[1]$startarray[2]";
	$valfinish="$finisharray[0]$finisharray[1]$finisharray[2]";
	if($valstart>$valfinish){
		return "1";
	}
	else {
		return "0";
	}
}
function insert_data_into_users($fullname,$username,$password,$email,$vcode){
	
							try{
								$con=users_db_connect();
		
						  
						  	
								  //MySql Insert data to table registration
								  
								 $sql="INSERT INTO registration (fullname, username, email, password, verified, verification_code)
										  VALUES (:fullname, :username, :email, :password, '0', :vcode)";
									$q = $con->prepare($sql);
								
									$q->execute(array(	':fullname'=>$fullname,
								
								                  		':username'=>$username,
								
								                  		':email'=>$email,
								
								                  		':password'=>$password,
								
								                  		':vcode'=>$vcode));
													 
									if(!$q)
								
										{
									
										  die("Execute query error, because: ". $con->errorInfo());
										
										}
									else{
								
									
									SentVerificationEmail($vcode, $email);
									}
									mysqli_close($con);
								  
								}
							catch(PDOException $pe)
							
							{
							
							  die('Connection error, because: ' .$pe->getMessage());
							
							}
						  
								}


function updateEmailVerified($db){
		
	echo "Account Verified";
	$sql = "UPDATE registration SET verified=1";
	$q = $db->prepare($sql);
	$q->execute();
}

//checks if the vcode from the email matches the one in db
function vcodeValidation($db,$vcode){
			
		
		$found = 0;
		foreach($db->query('SELECT * FROM registration') as $row) {
    
			$check_vcode = $row['verification_code'];
	
	
			if($check_vcode == $vcode){
					$found = 1;
			}
	
		}
	return $found;
}

function check4dublicate($username,$email){
	
			$db=users_db_connect();
			foreach($db->query('SELECT * FROM registration') as $row) {
    
				$checkMail = $row['email'];
				$checkusename = $row['username'];
				
				if($checkusename == $username){
						$found = 1;
						break;
				}
				else if($checkMail == $email){
						$found = 2;
						break;
				}
				else{
					$found = 0;
					
				}
	
			}
	return $found;
}
	
	function DeleteOffer($offerid){
			
		$db=users_db_connect();
		$sql = "DELETE FROM offers WHERE offerid =  :id";
		$stmt = $db->prepare($sql);
		$stmt->bindParam(':id', $offerid, PDO::PARAM_INT);   
		$stmt->execute();
		
	}
	function deleteRequstedOffer($offerid){
			
		$db=users_db_connect();
		$sql = "DELETE FROM requests WHERE request_id =  :id";
		$stmt = $db->prepare($sql);
		$stmt->bindParam(':id', $offerid, PDO::PARAM_INT);   
		$stmt->execute();
		
	}

function insert_data_into_offers($userid_fgn,$offername,$usertype,$location,$reward,$description,$start_time,$finish_time,$date){
					echo "id:$userid_fgn,offer:$offername,type:$usertype,loc:$location,rew:$reward,des:$description,start:$start_time,finish:$finish_time,date:$date";
							try{
								$con=users_db_connect();
		
						  
						  	
								  //MySql Insert data to table registration
								  
								 $sql="INSERT INTO offers (date, start_time, finish_time, offername, userid_fgn, location,reward,usertype,description)
										  VALUES (:date, :start_time, :finish_time, :offername, :userid_fgn, :location, :reward, :usertype ,:description)";
									$q = $con->prepare($sql);
								
									$q->execute(array(	':date'=>$date,
								
								                  		':start_time'=>$start_time,
								
								                  		':finish_time'=>$finish_time,
								
														':offername'=>$offername,
														
								                  		':userid_fgn'=>$userid_fgn,
								
								                  		':location'=>$location,
								                  		
								                  		':reward'=>$reward,
														
								                  		':usertype'=>$usertype,
								                  		
								                  		':description'=>$description));
									
								  
								}
							catch(PDOException $pe)	
							{
							
							  die('Connection error, because: ' .$pe->getMessage());
							
							}
						  
	}
	function updateRating($score,$id){
		
	try{
	$db=users_db_connect();
	$sql = "UPDATE requests SET rated=1, rating=:score WHERE offer_id_fgn=:id";
	$q = $db->prepare($sql);
	$q->execute(array(':id'=>$id,':score'=>$score));
	return 1;
	}
	catch(PDOException $pe)	{
		return 0;
		
		
	}
}
?>