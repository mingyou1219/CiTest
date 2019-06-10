<?php include("_site_header.php"); ?>
<div class="container post">
	<?php include("_content_nav.php") ?>	
	<!-- content -->
	<div class="content">
		<form action="<?=site_url("article/posting")?>" method="post" > 
			<?php if(isset($errorMessage)){ ?>
			<div class="alert alert-error"><?=$errorMessage?></div>
			<?php } ?>
			<table>
				<tr>
					<td>標題</td>
					<?php if(isset($title)){ ?>
						<td><input type="text" name="title" 
							value="<?=htmlspecialchars($title)?>" /></td>
					<?php }else{ ?>
						<td><input type="text" name="title" /></td>
					<?php } ?>
				</tr>
				<tr>
					<td> 內容 </td>
					<td><textarea name="content" rows="10" cols="60"><?php 
						if(isset($content)){
							echo $content;
						}
					?></textarea></td>
				</tr>
				<tr>
					<td colspan="2"> 
						<a class="btn" href="<?=site_url("/")?>">取消</a>
						<input type="submit" class="btn" value="送出" />
					</td>
				</tr>
			</table>
		</form>
	</div>
</div>
<?php include("_site_footer.php"); ?>