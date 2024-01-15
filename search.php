<?php 
	include 'header.php';
	$keyword = $_GET['keyword']	;
	if (empty($keyword)) 
	{
		header('location:index.php');
	}
	// pagination
	if (!isset($_GET['page'])) 
	{
		$page = 1;
	}
	else
	{
		$page = $_GET['page'];
	}
	$limit = 3;
	$offset = ($page - 1) * $limit;
	// -----------

	$sql = "SELECT * FROM blog LEFT JOIN Categories ON blog.category=Categories.Category_id LEFT JOIN user ON blog.author_id=user.user_id WHERE blog_title like '%$keyword%' or blog_body like '%$keyword%' ORDER BY blog.publish_date DESC LIMIT $offset, $limit";
	$run = mysqli_query($config,$sql);
	$rows = mysqli_num_rows($run);
?>
<div class="container mt-2">
	<div class="row">
		<h3 class="mb-0">Search Reasult for: <span class="text-primary"><?= $keyword ?></span></h3>
		<div class="col-lg-8">
			<hr>
			<?php
				if ($rows) 
				{
					while ($result = mysqli_fetch_assoc($run)) {	
			?>
			<div class="card shadow mb-4">
				<div class="card-body d-flex blog_flex">
					<div class="flex-part1">
						<a href="single_post.php?id=<?= $result['blog_id'] ?>">
							<?php $img = $result['blog_img']  ?>
							<img src="admin/upload/<?= $img ?>">
						</a>
					</div>
					<div class="flex-grow-1 flex-part2 px-4 py-2">
						  <a href="single_post.php?id=<?= $result['blog_id'] ?>" id="title">
						  	<?= ucfirst($result['blog_title']) ?>
						  </a>
						<p>
						  <a href="single_post.php?id=<?= $result['blog_id'] ?>" id="body">
						  	<?= strip_tags(substr($result['blog_body'], 0,200))."..." ?>
						  </a> <span><br>
                          <a href="single_post.php?id=<?= $result['blog_id'] ?>" class="btn btn-sm btn-outline-primary mt-2">Continue Reading
                          </a></span>
                        </p>
						<ul>
							<li class="me-2"><a href="" class="text-primary"> <span>
                                <i class="fa fa-pencil-square-o" aria-hidden="true"></i></span>
						  			<?= $result['username'] ?>
                            	</a>
							</li>
							<li class="me-2">
								<a href="" class="text-primary"> <span><i class="fa fa-calendar-o" aria-hidden="true"></i></span> 
						  			<?= date('d/M/Y',strtotime($result['publish_date'])) ?>
								 </a>
							</li>
							<li>
								<a href="category.php?id=<?= $result['category_id'] ?>" class="text-primary"> 
									<span><i class="fa fa-tag" aria-hidden="true"></i></span> 
						  			<?= $result['category_name'] ?>
								 </a>
						    </li>
						</ul>
					</div>
				</div>
			</div>
			<?php } } 
			else 
			{
			 	echo "<h5 class='text-danger'>NO Record Found!</h5> 
			 		<br><br>
			 		Suggestions:
			 		<li>Make sure that word is spelled correctly.</li>
			 		<li>Try different keywords.</li>
			 	"; 
			}
			?>
			<!-- pagination start -->
			<?php
				$pagination = "SELECT * FROM blog WHERE blog_title like '%$keyword%' or blog_body like '%$keyword%'";
				$run_q = mysqli_query($config, $pagination);
				$total_post = mysqli_num_rows($run_q);
				$pages = ceil($total_post / $limit);
				if ($total_post > $limit) {
			?>
			<ul class="pagination pt-2 pb-5">
				<?php for ($i=1; $i <= $pages ; $i++) { ?>
				<li class="page-item <?=($i == $page)? $active = "active":"";?>">
					<a href="search.php?keyword=<?= $keyword ?>&page=<?= $i ?>" class="page-link">
						<?= $i ?>
					</a>
				</li>
				<?php } ?>
			</ul>
			<?php } ?>
			<!-- ---------------- -->
		</div>
		<?php include 'sidebar.php'; ?>
	</div>
</div>
<?php include 'footer.php'; ?>
