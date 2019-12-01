<?php defined('ABSPATH') or exit('No direct script access allowed'); ?>
<?php
/*if(!is_null($this->mknm_kua_number)) {
	echo '<div class="mknm-kua-result">Your KUA number is: <span class="mknm-kua-result-number">' . $this->mknm_kua_number . ' (' . $this->mknm_kua_group . ')</span></div>';
}*/
?>
<form method="post" action="<?php basename(__FILE__); ?>">
	<select name="mknm_form_yy">
		<option value="">Year:</option>
		<?php for($yy = 1950; $yy <= date('Y'); $yy++): ?>
		<option value="<?php echo $yy; ?>" <?php if(isset($_POST['mknm_form_yy']) && $_POST['mknm_form_yy'] == $yy) {echo 'selected';} ?>><?php echo $yy; ?></option>
		<?php endfor; ?>
	</select>
	<select name="mknm_form_mm">
		<option value="">Month:</option>
		<?php for($mm = 1; $mm <= 12; $mm++): ?>
		<option value="<?php echo $mm; ?>" <?php if(isset($_POST['mknm_form_mm']) && $_POST['mknm_form_mm'] == $mm) {echo 'selected';} ?>><?php echo $mm; ?></option>
		<?php endfor; ?>
	</select>
	<select name="mknm_form_dd">
		<option value="">Day:</option>
		<?php for($dd = 1; $dd <= 31; $dd++): ?>
		<option value="<?php echo $dd; ?>" <?php if(isset($_POST['mknm_form_dd']) && $_POST['mknm_form_dd'] == $dd) {echo 'selected';} ?>><?php echo $dd; ?></option>
		<?php endfor; ?>
	</select>
	<select name="mknm_form_gender">
		<option value="">Gender:</option>
		<option value="male" <?php if(isset($_POST['mknm_form_gender']) && $_POST['mknm_form_gender'] == 'male') {echo 'selected';} ?>>Male</option>
		<option value="famale" <?php if(isset($_POST['mknm_form_gender']) && $_POST['mknm_form_gender'] == 'famale') {echo 'selected';} ?>>Famale</option>
	</select>
	<br />
	<input type="submit" name="mknm_submit" value="Submit" />
</form>
<!--<script>
if(window.history.replaceState) {
	window.history.replaceState(null, null, window.location.href);
}
</script>-->