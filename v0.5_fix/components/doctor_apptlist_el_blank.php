<form class="list_el" method="post" action="doctor_index.php">
	<div class="pfp mobadd">
		<img src="assets/pfp2.png">
		<input type="hidden" name="tpatient_pf_img">
		<div class="pfp_text">
			<div class="pfp_text_name"><input type="text" placeholder="Nom du patient" required="" name="tpatient_name"></div>
		</div>
	</div>
	<div class="list_el_brief mobadd">
		<div class="brief_datetime_in"><input type="datetime-local" required="" name="appt_date"></div>
		<div class="brief_motif"><p>Motif de consultation</p></div>
		<input type="hidden" name="appt_motif">
		<div class="brief_action">
		<input type="hidden" name="PS_apptlist_blank_submit" value="Ajouter" />
		<div class="flex flexcenter teng">
			<button type="submit" class="btnprimary"><svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 20 20" enable-background="new 0 0 20 20" xml:space="preserve" fill="#545454" width="14"> <g id="XMLID_1_"> <path id="XMLID_3_" fill="#545454" d="M18,11.7h-6.8v6.8H8.4v-6.8H1.5V8.9h6.9V2h2.8v6.9H18V11.7z"></path> </g> <g id="XMLID_2_"> </g> <g id="XMLID_5_"> </g> <g id="XMLID_6_"> </g> <g id="XMLID_7_"> </g> <g id="XMLID_8_"> </g> <g id="XMLID_9_"> </g> </svg> Ajouter</button>
			<p onclick="addto_apptlist(1, this)">X</p>
		</div>
		</div>
		
	</div>
</form>