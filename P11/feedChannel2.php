<?php 
	
$mysql_host = 'localhost'; //host
$mysql_username = 'root'; //username
$mysql_password = ''; //password
$mysql_database = 'test'; //db

header('Content-Type: text/xml; charset=utf-8', true); //set document header content type to be XML
$xml = new DOMDocument("1.0", "UTF-8"); // Create new DOM document.

//create "RSS" element
$rss = $xml->createElement("rss"); 
$rss_node = $xml->appendChild($rss); //add RSS element to XML node
$rss_node->setAttribute("version","2.0"); //set RSS version

//set attributes
$rss_node->setAttribute("xmlns:dc","http://purl.org/dc/elements/1.1/"); //xmlns:dc (info http://j.mp/1mHIl8e )
$rss_node->setAttribute("xmlns:content","http://purl.org/rss/1.0/modules/content/"); //xmlns:content (info http://j.mp/1og3n2W)
$rss_node->setAttribute("xmlns:atom","http://www.w3.org/2005/Atom");//xmlns:atom (http://j.mp/1tErCYX )

//Create RFC822 Date format to comply with RFC822
$date_f = date("D, d M Y H:i:s T", time());
$build_date = gmdate(DATE_RFC2822, strtotime($date_f));

//create "channel" element under "RSS" element
$channel = $xml->createElement("channel");  
$channel_node = $rss_node->appendChild($channel);
 
//a feed should contain an atom:link element (info http://j.mp/1nuzqeC)
$channel_atom_link = $xml->createElement("atom:link");  
$channel_atom_link->setAttribute("href","http://localhost"); //url of the feed
$channel_atom_link->setAttribute("rel","self");
$channel_atom_link->setAttribute("type","application/rss+xml");
$channel_node->appendChild($channel_atom_link); 

//add general elements under "channel" node
$channel_node->appendChild($xml->createElement("title", "Sanwebe")); //title
$channel_node->appendChild($xml->createElement("description", "description line goes here"));  //description
$channel_node->appendChild($xml->createElement("link", "http://www.sanwebe.com")); //website link 
$channel_node->appendChild($xml->createElement("language", "en-us"));  //language
$channel_node->appendChild($xml->createElement("lastBuildDate", $build_date));  //last build date
$channel_node->appendChild($xml->createElement("generator", "PHP DOMDocument")); //generator

//Fetch records from the database
//connect to MySQL - mysqli($mysql_host, $mysql_username, $mysql_password, $mysql_database);
$mysqli = new mysqli('localhost','root','','test');

//Output any connection error
if ($mysqli->connect_error) {
    die('Error : ('. $mysqli->connect_errno .') '. $mysqli->connect_error);
}

//MySQL query, we pull records from site_contents table
$results = $mysqli->query("SELECT id, title, content, published FROM site_contents");

if($results){ //we have records 
    while($row = $results->fetch_object()) //loop through each row
    {
      $item_node = $channel_node->appendChild($xml->createElement("item")); //create a new node called "item"
      $title_node = $item_node->appendChild($xml->createElement("title", $row->title)); //Add Title under "item"
      $link_node = $item_node->appendChild($xml->createElement("link", "http://www.your-site.com/link/goes/here/")); //add link node under "item"
      
      //Unique identifier for the item (GUID)
      $guid_link = $xml->createElement("guid", "http://www.your-site.com/link/goes/here/". $row->id);  
      $guid_link->setAttribute("isPermaLink","false");
      $guid_node = $item_node->appendChild($guid_link); 
     
      //create "description" node under "item"
      $description_node = $item_node->appendChild($xml->createElement("description"));  
      
      //fill description node with CDATA content
      $description_contents = $xml->createCDATASection(htmlentities($row->content));  
      $description_node->appendChild($description_contents); 
    
      //Published date
      $date_rfc = gmdate(DATE_RFC2822, strtotime($row->published));
      $pub_date = $xml->createElement("pubDate", $date_rfc);  
      $pub_date_node = $item_node->appendChild($pub_date); 

    }
}
echo $xml->saveXML();


?>