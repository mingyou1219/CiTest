<?php include("_site_header.php"); ?>
<div class="container article-view">
	<?php include("_content_nav.php") ?>	
	<!-- content -->
	<div class="content">
		<table class="table table-bordered">
			<tr>
				<td>作者</td>
				<td><?=htmlspecialchars($article->account)?></td>
			</tr>
			<tr>
				<td>標題</td>
				<td><?=htmlspecialchars($article->Title)?></td>
			</tr>
			<tr>
				<td> 內容 </td>
				<td><?=nl2br(htmlspecialchars($article->Content))?></td>
			</tr>
			<?php if(isset($_SESSION["user"]) && $_SESSION["user"]!= null 
				&& $_SESSION["user"]->UserID == $article->Author ) { ?>
			<tr>
				<td colspan="2">
					<a href="<?=site_url("article/edit/".$article->ArticleID)?>">編輯此文章</a>

					<a class="btn" href="<?=site_url("article/del/".$article->ArticleID)?>">刪除文章</a>
				</td
			</tr>
			<?php } ?>
		</table>
	</div>
</div>
<?php include("_site_footer.php"); ?>