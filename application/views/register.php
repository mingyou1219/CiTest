<?php include("_site_header.php"); ?>
<div class="container">
	<?php include("_content_nav.php") ?>  <?php /* include content_nav  */ ?>
	<div class="content">
		<form action="<?=site_url("/user/registering")?>" method="post"  >
			<?php  if (isset($errorMessage)){?>
			<div class="alert alert-error">
				<?=$errorMessage?>
			</div>
			<?php }?>
			<table class="table table-bordered">
				<tr>
					<td>
						Account
					</td>
					<td>
						<?php if(isset($account)){ ?>
						<input class="user" type="text" name="account" value="<?=htmlspecialchars($account)?>" />
						<?php }else{ ?>
						<input class="user" type="text" name="account" />
						<?php } ?>
					</td>
				</tr>
				<tr>
					<td>
						Password
					</td>
					<td>
						<input class="user" type="password" name="password" />
					</td>
				</tr>
				<tr>
					<td>
						Re-type Password
					</td>
					<td>
						<input class="user" type="password" name="passwordrt" />
					</td>
				</tr>
				<tr>
					<td colspan="2">
						<input class="btn" type="submit" value="送出" />
					</td>
				</tr>
			</table>
		</form>
	</div>
</div>
<?php include("_site_footer.php"); ?>