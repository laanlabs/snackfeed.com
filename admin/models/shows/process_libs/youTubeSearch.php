<?
$doc = new DOMDocument();
$doc->load('http://gdata.youtube.com/feeds/api/videos?vq=funny+dogs&start-index=20&max-results=3');
$xp = new domxpath($doc);
$xp->registerNamespace('def','http://www.w3.org/2005/Atom');
$groups = $xp->query('/def:feed/def:entry/media:group');
$search= array();
for ( $i = 0,$len = $groups->length; $i < $len; $i++ ) {
    $titles = $groups->item($i)->getElementsByTagName("title");
    foreach($titles as $title){
        $search['title'][$i][]=$title->firstChild->nodeValue;
    }
    $descriptions = $groups->item($i)->getElementsByTagName("description");
    foreach($descriptions as $description){
        $search['description'][$i][]=$description->firstChild->nodeValue;
    }
    $thumbnails = $groups->item($i)->getElementsByTagName("thumbnail");
    foreach($thumbnails as $thumbnail){
        $search['thumbnail'][$i][]=$thumbnail->getAttribute('url');
    }
    // and so on ......
}
echo "<pre>";
print_r($search);




?>