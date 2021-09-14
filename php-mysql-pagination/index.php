<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Effective Pagination Example in PHP and MySQL</title>
    </head>
    <body>
		<?php
			require_once 'config.php';
		?>
		<table>
			<thead>
				<tr>
					<th>Category ID</th>
					<th>Category Name</th>
					<th>Category Link</th>
					<th>Parent ID</th>
					<th>Sort Order</th>
				</tr>
			</thead>
			<?php
				$sql = "SELECT * FROM category";
				$itemPerPage = 5;
				$result = dbQuery(getPagingQuery($sql, $itemPerPage));
				$pagingLink = getPagingLink($sql, $itemPerPage);
			?>
			<tbody>
				<?php
					if (dbNumRows($result) > 0) {
						while ($row = dbFetchAssoc($result)) {
							extract($row);
							echo '<tr>';
							echo '<td>' . $row['category_id'] . '</td>';
							echo '<td>' . $row['category_name'] . '</td>';
							echo '<td>' . $row['category_link'] . '</td>';
							echo '<td>' . $row['parent_id'] . '</td>';
							echo '<td>' . $row['sort_order'] . '</td>';
							echo '</tr>';
						}
						if ($pagingLink) {
							echo '<div>' . $pagingLink . '</div>';
						}
					} else {
						echo 'No result found';
					}
				?>
			</tbody>
		</table>
	</body>
</html>