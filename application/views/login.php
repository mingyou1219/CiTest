<?php include("_site_header.php"); ?>
<link rel="stylesheet" href="<?=base_url();?>css/test.css?<?php echo time();?>">
<div class="container">
	<?php include("_content_nav.php") ?> 
	<div class="content">
		<form action="<?=site_url("user/logining")?>" method="post" > 
			<?php if(isset($errorMessage)){ ?>

			<div class="alert alert-error"><?=$errorMessage?></div>

			<?php } ?>
			<table>
				<tr>
					<td>帳號</td>
                    <?php if(isset($account)){ ?>
						<td><input class="user" type="text" name="account" 
							value="<?=htmlspecialchars($account)?>" /></td>
					<?php }else{ ?>
						<td><input class="user" type="text" name="account" /></td>
					<?php } ?>
				</tr>
				<tr>
					<td> 密碼 </td>
					<td><input class="user" type="password" name="password" /></td>
				</tr>
				<tr>
					<td colspan="2"> 
						<a href="<?=site_url("/user/login")?>">取消</a    >
						<input type="submit" class="btn" value="送出" />
					</td>
				</tr>
			</table>
		</form>
	</div>
</div>