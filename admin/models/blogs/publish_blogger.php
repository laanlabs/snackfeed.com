<?

require_once 'Zend/Loader.php';


Zend_Loader::loadClass('Zend_Gdata');
Zend_Loader::loadClass('Zend_Gdata_Query');
Zend_Loader::loadClass('Zend_Gdata_ClientLogin');


$user = $_username;
$pass = $_password;
$blog_name = $_url_params_1;
//$draft = $_POST['b_publish'];
//$labels = $_POST['b_categories'];





$title= $wp_title;
$content= $wp_body;


$service = 'blogger';


try {
	$client = Zend_Gdata_ClientLogin::getHttpClient($user, $pass, $service);
} catch (Exception $e) {
    echo ' ',  $e->getMessage(), " Click <a href='javascript:showPost()'>here</a> to try again.\n";
	die();
}



$gdClient = new Zend_Gdata($client);
$query = new Zend_Gdata_Query('http://www.blogger.com/feeds/default/blogs');
$feed = $gdClient->getFeed($query);



  $i = 0;
  $vMsg= "";
  $blogAccounts = array();

  foreach($feed->entries as $entry) {
    //echo  $i ."  ". $entry->title->text . "\n";
	
	$blogAccounts[$i] = $entry->title->text;

	$idText = split('-', $feed->entries[$i]->id->text); 
	$blogID = $idText[2];

	if ($blog_name == $entry->title->text )
	{
		$blogID_match = $blogID;
	}


	//echo "BLOGID:" . $blogID;
    $i++;
  }


if ($i == 0) 
{
	echo " You have no blogger/blogspots accounts associated with this login - " . $user . "!";
}

if ($i > 1)
{
	if (empty($blogID_match))
	{
		
		echo "You have multiple blogger/blogspot accounts and we did not find a match with the information you provided. Please click <a href='javascript:showPost()'>here</a> to try again and enter one of these Blog Names: " . implode(", ", $blogAccounts);
		die();
	} else {
		$blogID = $blogID_match;
	}
}


//echo "BLOGID:" . $blogID;




$uri = 'http://www.blogger.com/feeds/' . $blogID . '/posts/default';
$entry = $gdClient->newEntry();
$entry->title = $gdClient->newTitle($title);
$entry->content = $gdClient->newContent($content);

if (!empty($labels))
{
	$label = $gdClient->newCategory($labels , 'http://www.blogger.com/atom/ns#');
	$entry->setCategory(array(0 => $label));
}


$entry->content->setType('text');

if ($draft == 1)
{
  $control = $gdClient->newControl();
  $draft = $gdClient->newDraft('yes');
  $control->setDraft($draft);
  $entry->control = $control;
	//echo "draft";
}

$createdPost = $gdClient->insertEntry($entry, $uri);



$_link =  $createdPost->link[0]->href ;
$idText = split('-', $createdPost->id->text);
$newPostID = $idText[2]; 

if ($draft == 1)
{
	echo "Post success as <em>draft</em>. <a href='{$_link}' target='_new'>{$_link}</a>";
	echo "Your new post id is: ".  $newPostID;
} else {	
echo "Post success. <a href='{$_link}' target='_new'>{$_link}</a>";
echo "Your new post id is: ".  $newPostID;
}



?>