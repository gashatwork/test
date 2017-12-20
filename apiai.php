<?php
header('Access-Control-Allow-Origin: *');


//2907;"What ";"Prepaid";"Reload";"charges"

//access post data
$json = json_decode(file_get_contents("php://input"));


$id = $json->id;
$sessionId = $json->sessionId;
$intent = $json->result->metadata->intentName;
$entity = $json->result->parameters->testparam;
$entity1 = $json->result->parameters->testparam1;
$entity2 = $json->result->parameters->testparam2;
//$query = str_replace("'", "''",$json->result->resolvedQuery);


$orderUrl = 'https://bot.dialogflow.com/digiprodtest';
//$jsonData = array(
   
  //  'command' =>"'get_test_webhook_answer'",
    //'hook_id' => "'$id'"
//);

//Encode the array into JSON.
//$postData = json_encode($jsonData, true);


$conn_string = "'hostaddr=35.200.224.70 host=digiprod-bff61:asia-south1:pginstance port=5432  dbname=postgres user=postgres password=postgres123'";


$conn = pg_connect($conn_string);  

if ($conn === false)
{
	echo "Error in db conn";
	
}

//if ($conn){
	else{
	/* Execute the query. */    
	
	$vintent = "test";
	$ventity = "testparam";
	$ventity1 = "testparam1";
	$ventity2 = "testparam2";
	//$tsql = "'select get_test_webhook_answer ('" . $vintent ."','". $ventity."','". $ventity1."','".  $ventity2."')";
	//$tsql = "SELECT * FROM test_webhook_answer_";	
	//$stmt = pg_query( $conn, $tsql);
	$stmt = pg_query( $conn, "SELECT * FROM test_webhook_answer_";);
	
	
	
	if( $stmt === false )  
	{  
		 echo "Error in statement preparation/execution.";  
		 die( print_r(pg_result_errors(), true));  
	}  

	while ($response = pg_fetch_array($stmt))
	{
		//$data = array(
            //'channel'     => $channel,
            //'username'    => $bot_name,
            //'text'        => $message,
            //'icon_emoji'  => $icon,
          //  'attachments' => $attachments
        //);
        //$data_string = json_encode($data);
		//echo $response;
		//$result = json_decode($response);
		
			//$ch = curl_init('https://'.$domain.'.slack.com/services/hooks/incoming-webhook?token='.$token);
			$ch = curl_init('https://bot.dialogflow.com/digiprodtest');
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($ch, CURLOPT_POSTFIELDS, $response);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($response))
            );
        //Execute CURL
        $result = curl_exec($ch);
        return $result;        
		
						
	}
	
	//free result memory
	pg_free_result($stmt);    
	}
	pg_close($conn);


?>
