<?php include("_site_header.php"); ?>
<div class="container">
	<?php include("_content_nav.php") ?>
	<div class="content">
		<div class="alert alert-success">
			<!-- Watch up for html injection :p -->
			文章發表成功，<a href="<?=site_url("article/view/".htmlspecialchars($articleID))?>">馬上連往瀏覽!</a>
		</div>
	</div>
</div>
<?php include("_site_footer.php"); ?>