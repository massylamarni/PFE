<form class="list_el prevent_list_el" method="post" action="doctor_index.php">
	<div class="pfp">
		<img src="assets/pfp2.png">
		<input type="hidden" name="tpatient_pf_img">
		<div class="pfp_text">
			<div class="pfp_text_name"><input type="text" name="tpatient_name"></div>
		</div>
	</div>
	<div class="list_el_brief">
		<div class="brief_datetime_in"><input type="datetime-local" name="appt_date"></div>
		<div class="brief_motif">
			<p>Motif de consultption</p>
		</div>
		<div class="brief_action"><input type="submit" class="input_button" name="PS_apptlist_blank_submit" value="Ajouter"><p class="input_button" onclick="addto_apptlist(1, this)">Annuler</p></div>
	</div>
</form>