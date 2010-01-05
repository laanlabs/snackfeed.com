<?



	define('KEYID','1CGQJWJNQSRAW91NNK82');
	define('AssocTag','YourAssociateTagHere');
	$keywords = urlencode($_REQUEST['search_key']);

	$SearchIndex = "Books";
	
	
	$ItemPage = 1;

   
	$parsed_xml = ItemSearch($SearchIndex, $keywords, $ItemPage);	
   
   	$numOfItems = $parsed_xml->Items->TotalResults;
	$totalPages = $parsed_xml->Items->TotalPages;
	$HMAC = urlencode($_GET['HMAC']);

?>


<table>

<?





	$i=0;

	if($numOfItems>0){
		foreach($parsed_xml->Items->Item as $current){
			if(isset($current->Offers->Offer->OfferListing->OfferListingId)){ //only show items for which there is an offer
		
		$asin = $current->ASIN;
		
		$_desc = "";
		if(isset($current->ItemAttributes->Director)){
				$_desc .= "<br/>Director: ".$current->ItemAttributes->Director;
		} elseif(isset($current->ItemAttributes->Author)) {
				$_desc .= "<br/>Author: ".$current->ItemAttributes->Author;
		} elseif(isset($current->ItemAttributes->Artist)) {
			$_desc .= "<br/>Artist: ".$current->ItemAttributes->Artist;
		}
		$_desc .="<br/>Price: ".$current->Offers->Offer->OfferListing->Price->FormattedPrice;
		
		
?>		
<form   action="/?a=products.video_submit&t=picker" method="post" name="form_edit_<?= $i ?>" >	
	<input type="hidden" name="_video_id" value="<?= $_REQUEST["video_id"] ?>" />
	<input type="hidden" name="_link" value="<?= $current->DetailPageURL ?>">
	<input type="hidden" name="_name" value="<?= $current->ItemAttributes->Title ?>">
	<input type="hidden" name="_thumb" value="<?= $current->MediumImage->URL ?>">
	
	<input type="hidden" name="_price" value="<?= $current->Offers->Offer->OfferListing->Price->FormattedPrice ?>">
	<input type="hidden" name="_type" value="book">
	
</form>	
 		
	<tr >
		<td>	
		<a href="javascript:document.form_edit_<?= $i ?>.submit();">		
		<img src="<?= $current->MediumImage->URL ?>" /></a>
		</td>
		<td style="border-bottom: 1px solid #000">
			
		<?= $current->ItemAttributes->Title ?><br/>
		<?=$_desc ?><br/>
		ASIN:	<?= $asin?><br/>
		<a href="<?= $current->DetailPageURL ?>" target="_new">link</a>


		
		

		
			
	
	

			


		
		</td>
	</tr>	
			
<?
			$i++;
			}
		}
	}else{
		//print("<center>No matches found.</center>");
	}

?>	
</table>


<?

	die();
	
	
function ItemSearch($SearchIndex, $Keywords, $ItemPage){
	$request="http://ecs.amazonaws.com/onca/xml?Service=AWSECommerceService&AWSAccessKeyId=".KEYID."&AssociateTag=".AssocTag."&Version=2006-09-11&Operation=ItemSearch&ResponseGroup=Medium,Offers";
	$request.="&SearchIndex=$SearchIndex&Keywords=$Keywords&ItemPage=$ItemPage";
	
	
	
	//The use of `file_get_contents` may not work on all servers because it relies on the ability to open remote URLs using the file manipulation functions. 
	//PHP gives you the ability to disable this functionality in your php.ini file and many administrators do so for security reasons.
	//If your administrator has not done so, you can comment out the following 5 lines of code and uncomment the 6th.  
	$session = curl_init($request);
	curl_setopt($session, CURLOPT_HEADER, false);
	curl_setopt($session, CURLOPT_RETURNTRANSFER, true);
	$response = curl_exec($session);
	curl_close($session); 
	//$response = file_get_contents($request);
	
	
	
	$parsed_xml = simplexml_load_string($response);
	return $parsed_xml;
}		
	






?>