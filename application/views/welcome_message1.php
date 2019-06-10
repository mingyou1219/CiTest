
<? session_start() ?>
<?php include("_site_header.php"); ?>
<div class="container home">
	<?php include("_content_nav.php") ?>	

	<!-- content -->
	<div class="content">
		<div>
			<?php if(count($hotArticles) == 0 ){ ?>
				很抱歉，目前尚無熱門文章
			<?php }else{ ?>
			<h1>熱門文章</h1>
			<table class="table"> 
				<tr>
					<td>標題</td>
					<td>作者</td>
					<td>點閱次數</td>
				</tr>
				<?php foreach ($hotArticles as $article) {	?>
				<tr>
					<td>
						<a href="<?=site_url("article/view/".$article->ArticleID)?>">
							<?=htmlspecialchars($article->Title)?>
						</a>
					</td>
					<td>
						<?=htmlspecialchars($article->Account)?>
					</td>
					<td>
						<?=htmlspecialchars($article->Views)?>
					</td>
				<?php } ?>
			</table>
			<?php }   ?>
			
		</div>
		<div>
			<?php if(count($hotUsers) == 0 ){ ?>
				很抱歉，目前尚無熱門作者
			<?php }else{ ?>
			<h1>熱門作者</h1>
			<table class="table"> 
				<tr>
					<td>作者</td>
					<td>文章最高點閱次數</td>
				</tr>
				<?php foreach ($hotUsers as $user) {	?>
				<tr>
					<td>
						<a href="<?=site_url("article/author/".$user->Account)?>">
							<?=htmlspecialchars($user->Account)?>
						</a>
					</td>
					<td>
						<?=htmlspecialchars($user->Views)?>
					</td>
				<?php } ?>
			</table>
			<?php }   ?>
		</div>
	</div>
</div>
<?php include("_site_footer.php"); ?>