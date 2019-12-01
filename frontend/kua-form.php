<?php
if(!defined('ABSPATH')) {
	exit('Hi there, no direct script access allowed.');
}
?>
<form method="post" action="<?php basename(__FILE__); ?>">
	<select name="wpknc_yyyy">
		<option value="">Year:</option>
		<?php for($yy = 1950; $yy <= date('Y'); $yy++): ?>
		<option value="<?php echo $yy; ?>" <?php if(isset($_POST['wpknc_yyyy']) && $_POST['wpknc_yyyy'] == $yy) {echo 'selected';} ?>><?php echo $yy; ?></option>
		<?php endfor; ?>
	</select>
	<select name="wpknc_mm">
		<option value="">Month:</option>
		<?php for($mm = 1; $mm <= 12; $mm++): ?>
		<option value="<?php echo $mm; ?>" <?php if(isset($_POST['wpknc_mm']) && $_POST['wpknc_mm'] == $mm) {echo 'selected';} ?>><?php echo $mm; ?></option>
		<?php endfor; ?>
	</select>
	<select name="wpknc_dd">
		<option value="">Day:</option>
		<?php for($dd = 1; $dd <= 31; $dd++): ?>
		<option value="<?php echo $dd; ?>" <?php if(isset($_POST['wpknc_dd']) && $_POST['wpknc_dd'] == $dd) {echo 'selected';} ?>><?php echo $dd; ?></option>
		<?php endfor; ?>
	</select>
	<select name="wpknc_gender">
		<option value="">Gender:</option>
		<option value="male" <?php if(isset($_POST['wpknc_gender']) && $_POST['wpknc_gender'] == 'male') {echo 'selected';} ?>>Male</option>
		<option value="famale" <?php if(isset($_POST['wpknc_gender']) && $_POST['wpknc_gender'] == 'famale') {echo 'selected';} ?>>Famale</option>
	</select>
	<br />
	<input type="submit" name="wpknc_submit" value="Submit" />
</form>
<script>
if(window.history.replaceState) {
	window.history.replaceState(null, null, window.location.href);
}
</script>