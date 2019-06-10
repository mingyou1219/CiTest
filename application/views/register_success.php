<?php include("_site_header.php"); ?>
<div class="container">
	<?php include("_content_nav.php") ?>  <?php /* include content_nav  */ ?>
	<div class="content">
		<div class="alert alert-success">
			恭喜你 （<?=$account?>），你已經完成註冊，
			接下來馬上到登入頁面去試試看吧！
			<a href="<?=site_url("user/login")?>">登入</a>
		</div>
	</div>
</div>
<?php include("_site_footer.php"); ?>
