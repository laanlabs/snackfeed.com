<?

$win_title = "Tags List";

$rowcount = 0;
$sql = " SELECT t.*
 	FROM tags t
	WHERE tag_type_id = 1
	ORDER BY order_by, name ;";
	
$q = DB::query($sql);


$sql = "SELECT
		f.tag_id,
		f.name AS name,  p.name AS parent_name,
		COUNT( p.tag_id ) AS depth,
		if (COUNT( p.tag_id ) = 0, f.name, p.name) as a_order_by,
		if (COUNT( p.tag_id ) = 0, f.order_by, p.order_by) as top_order_by,
		f.order_by
		FROM
		tags AS f LEFT OUTER JOIN
		tags AS p ON f.parent_id = p.tag_id
		WHERE f.tag_type_id = 2 
		group by f.tag_id
		ORDER BY a_order_by, top_order_by, depth, f.order_by ";
  
$q1 = DB::query($sql);

?>