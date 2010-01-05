<?

$_show_id = isset($_GET['show_id']) ? $_GET['show_id'] : '0';


$win_title = "Tags List";

$rowcount = 0;
$sql = " SELECT t.*,
 	if(s.tag_id is  null , 0, 1) as count, 
	if(s.weight is  null , 0, s.weight ) as weight
	
 	FROM tags t LEFT OUTER JOIN
	show_tags AS s on t.tag_id = s.tag_id AND s.show_id = '{$_show_id}'
	WHERE tag_type_id = 1
	 
	ORDER BY order_by, name ;";
	
$q = DB::query($sql);




$sql = "SELECT
		f.tag_id, f.weight, f.parent_id,
		if(s.tag_id is  null , 0, 1) as count, 
		if(s.weight is  null , 0, s.weight ) as weight,
		f.name AS name,  p.name AS parent_name, 
		COUNT( p.tag_id ) AS depth,
		if (COUNT( p.tag_id ) = 0, f.name, p.name) as a_order_by,
		if (COUNT( p.tag_id ) = 0, f.order_by, p.order_by) as top_order_by,
		f.order_by
		FROM
		tags AS f LEFT OUTER JOIN
		tags AS p ON f.parent_id = p.tag_id
		LEFT OUTER JOIN
		show_tags AS s on f.tag_id = s.tag_id AND s.show_id = '{$_show_id}'
		WHERE f.tag_type_id = 2 
		group by f.tag_id
		ORDER BY a_order_by, top_order_by, depth, f.order_by ";
  
$q1 = DB::query($sql);

?>