<?php
include "db_connect.php";

$limit = 5; 
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$start = ($page - 1) * $limit;

$result = $conn->query("SELECT COUNT(*) AS total FROM posts");
$row = $result->fetch_assoc();
$total_pages = ceil($row['total'] / $limit);

$stmt = $conn->prepare("SELECT * FROM posts LIMIT ?, ?");
$stmt->bind_param("ii", $start, $limit);
$stmt->execute();
$data = $stmt->get_result();
?>
<!DOCTYPE html>
<html>
<body>
<h2>Posts</h2>
<table border="1" cellpadding="10">
<tr>
<th>ID</th>
<th>Title</th>
<th>Content</th>
</tr>
<?php while($row = $data->fetch_assoc()){ ?>
<tr>
<td><?php echo $row['id']; ?></td>
<td><?php echo $row['title']; ?></td>
<td><?php echo $row['content']; ?></td>
</tr>
<?php } ?>
</table>
<br>
<div>
<?php if($page > 1){ ?>
<a href="?page=<?php echo $page-1; ?>">Previous</a>
<?php } ?>
<?php for($i=1; $i<=$total_pages; $i++){ ?>
<a href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
<?php } ?>
<?php if($page < $total_pages){ ?>
<a href="?page=<?php echo $page+1; ?>">Next</a>
<?php } ?>
</div>
</body>
</html>