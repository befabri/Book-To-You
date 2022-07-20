<?php if ($notification!= "")  { ?>
	<div class="overlay">
		<div class="popup">
			<div class="popup-title">
				<h2>Notification</h2>
				<a class="close" href="<?php echo $_SERVER['REQUEST_URI']?>">&times;</a>
			</div>
			<div class="popup-content">
				<?php echo $notification?>
			</div>
		</div>
	</div>
<?php } ?>