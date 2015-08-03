<?php
 require 'db.php';
 
 function parser( $text , $id ) {
	//$text = file_get_contents("test.txt");
	$pattern = "#<td align=center><font color='green'>(.*?)</font></td>#";
    preg_match_all($pattern, $text, $matches);
  
  $size = count( $matches[1] );
  $code = array(); $mode = array(); $venue = array();
  $prof = array(); $title = array(); $slot = array();
 
  $count = 0;
  for( $i = 2; $i < $size; $i += 6 ) 
	$code[$count++] = $matches[1][$i];
  
  $count = 0;
  for( $i = 3; $i < $size; $i += 6 )
	$mode[$count++] = $matches[1][$i];
  
  $count = 0;
  for( $i = 5; $i < $size; $i += 6 )
	$venue[$count++] = $matches[1][$i];
  
  $pattern = "#<td><font color='green'>(.*?)</font></td>#";
  preg_match_all($pattern, $text, $matches);
  
  //Uncomment to veiw parsed data for debugging
  //var_dump($matches);

  $size = count( $matches[1] );
  
  $count = 0;
  for( $i = 0; $i < $size; $i += 6 )
	$title[$count++] = $matches[1][$i];
  $count = 0;
  for( $i = 2; $i < $size; $i += 6 )
	$slot[$count++] = $matches[1][$i];
  $count = 0;
  for( $i = 3; $i < $size; $i += 6 )
	$prof[$count++] = $matches[1][$i];
  
  if( $count == 0 )
	return false;
  
  for( $i = 0; $i < $count; $i++ ) {
    //The parsed data is available as { $code[], $title[], $mode[], $slot[], $venue[], $prof[] }
	
   /*
	mysql_query("INSERT INTO time_table( user_id, code, title, mode, slot, venue, prof ) VALUES ( '$id', '$code[$i]', '$title[$i]', '$mode[$i]', '$slot[$i]', '$venue[$i]', '$prof[$i]' )");
   */
   
  }
	
  return true;
    
}

?>