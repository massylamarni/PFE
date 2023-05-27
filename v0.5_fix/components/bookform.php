<?php
	$doctor_id = $_GET['doctor_id'];
?>
<form name="book_<?php echo $doctor_id ?>" id="<?php echo $doctor_id ?>" method="post" action="resultlist.php" class="bookform_container hidden">
	<div class="bookform_close" onclick="bookform(2, <?php echo $doctor_id ?>)"></div>
	<div class="bookform">
		<input type="hidden" name="doctor_id" value="<?php echo $doctor_id ?>">
		<div class="bookform_title"><h3>Horaire</h3></div>
		<input class="appt_date" name="appt_date" type="datetime-local">
		<div class="bookform_submit"><button type="button" onclick="bookform(1, <?php echo $doctor_id ?>)">OK</button></div>
	</div>
	<div class="bookform hidden">
		<div class="bookform_title"><h3>Motif de consultation</h3></div>
		<div class="bookform_body">
			<p>Donnez une breve description de votre motif de consultation:</p>
			<textarea class="appt_motif" name="appt_motif" placeholder="(Optionnel)"></textarea>
		</div>
		<div class="bookform_submit"><button type="button" onclick="bookform(1, <?php echo $doctor_id ?>)">OK</button></div>
	</div>
	<div class="bookform hidden">
		<div class="bookform_title"><h3>Confirmation</h3></div>	
		<div class="bookform_body">
			<pre class="bookform_result"></pre>
		</div>
		<div class="bookform_submit"><button type="button" onclick="bookform(3, <?php echo $doctor_id ?>)">Annuler</button></div>
		<div class="bookform_submit"><input type="submit" value="OK" name="bookform_submit"></div>
	</div>
	<div class="bookform hidden">
		<div class="bookform_title"><h3>Rendez-vous confirmé !</h3></div>
		<div class="bookform_body">...</div>
	</div>
</form>