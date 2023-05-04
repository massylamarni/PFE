<?php
$id = "£00000";
$name = "User Name";
$email = "dummy@email.com";
$password = "**********";
$phone = "+213-123456789";
$bday = date("d-m-y");
$gender = "M";
$pf_img = "assets/pfp2.png";
$location = "75017 Colorado, USA";
$speciality = array("Cardiologue", "Dermatologue");
$description = "Spécialisé dans le traitement des maladies de la peau, des ongles et des cheveux,\nnotamment les éruptions cutanées, les infections de la peau, l'acné, les taches de\nvieillesse, les cancers de la peau, les allergies cutanées et les affections auto-immunes.";
$worktime = array(array("09h30", "19h30"), array("09h30", "19h30"), array("09h30", "19h30"), array("09h30", "19h30"), array("09h30", "19h30"), array("", ""), array("09h30", "19h30"));
$pricing = array(array("Consultation simple", "100 £"), array("Consultation avec acte", "200 £"));
$dq = array(array("1977", "Diplôme d'État de docteur en médecine - Université Paris 11 - Paris-Saclay"), array("1977", "D.E.S. Dermatologie et vénéréologie - UFR de médecine Lariboisière-Saint-Louis"));
$language = array("Anglais", "Francais", "Espagnol");
?>

<h3>Gerer Compte</h3>
<form class="ep_form">
<div class="pf" id="<?php echo $id ?>">
	<div class="pf_header">
		<img src="<?php echo $pf_img ?>">
		<div class="pf_header_text">
			<div class="pf_header_text_name"><textarea rows="1" cols="50"><?php echo $name ?></textarea></div>
			<div class="pf_header_text_id"><?php echo $id ?></div>
			<div class="pf_header_text_speciality">
				<textarea rows="1" cols="15"><?php echo $speciality[0] ?></textarea>, 
				<textarea rows="1" cols="15"><?php echo $speciality[1] ?></textarea>
			</div>
		</div>
	</div>
	<div class="pf_body">
		<div class="pf_body_field"><h3>Description</h3>
			<pre><textarea rows="5" cols="100"><?php echo $description ?></textarea></pre>
		</div>
		<div class="pf_body_field"><h3>Numero telephone</h3><textarea rows="1" cols="15"><?php echo $phone ?></textarea></div>
		<div class="pf_body_field"><h3>Adresse</h3><textarea rows="1" cols="50"><?php echo $location ?></textarea></div>
		<div class="pf_body_field"><h3>Date Naissance</h3><input type="date"></div>
		<div class="pf_body_field"><h3>Horaires de travail</h3>
			<pre>
				Dim:<textarea rows="1" cols="5"><?php echo $worktime[0][0] ?></textarea> - <textarea rows="1" cols="5"><?php echo $worktime[0][1] ?></textarea>
				Lun:<textarea rows="1" cols="5"><?php echo $worktime[1][0] ?></textarea> - <textarea rows="1" cols="5"><?php echo $worktime[1][1] ?></textarea>
				Mar:<textarea rows="1" cols="5"><?php echo $worktime[2][0] ?></textarea> - <textarea rows="1" cols="5"><?php echo $worktime[2][1] ?></textarea>
				Mer:<textarea rows="1" cols="5"><?php echo $worktime[3][0] ?></textarea> - <textarea rows="1" cols="5"><?php echo $worktime[3][1] ?></textarea>
				Jeu:<textarea rows="1" cols="5"><?php echo $worktime[4][0] ?></textarea> - <textarea rows="1" cols="5"><?php echo $worktime[4][1] ?></textarea>
				Ven:<textarea rows="1" cols="5"><?php echo $worktime[5][0] ?></textarea> - <textarea rows="1" cols="5"><?php echo $worktime[5][1] ?></textarea>
				Sam:<textarea rows="1" cols="5"><?php echo $worktime[6][0] ?></textarea> - <textarea rows="1" cols="5"><?php echo $worktime[6][1] ?></textarea>
			</pre>
		</div>
		<div class="pf_body_field"><h3>Tarifs</h3>
			<pre>
				<textarea rows="1" cols="50"><?php echo $pricing[0][0] ?></textarea><textarea rows="1" cols="10"><?php echo $pricing[0][1] ?></textarea>
				<textarea rows="1" cols="50"><?php echo $pricing[1][0] ?></textarea><textarea rows="1" cols="10"><?php echo $pricing[1][1] ?></textarea>
			</pre>
		</div>
		<div class="pf_body_field"><h3>Diplomes & Qualifications</h3>
			<pre>
				<textarea rows="1" cols="10"><?php echo $dq[0][0] ?></textarea><textarea rows="1" cols="50"><?php echo $dq[0][1] ?></textarea>
				<textarea rows="1" cols="10"><?php echo $dq[1][0] ?></textarea><textarea rows="1" cols="50"><?php echo $dq[1][1] ?></textarea>
			</pre>
		</div>
		<div class="pf_body_field"><h3>Langues parlées</h3>
			<textarea rows="1" cols="15"><?php echo $language[0] ?></textarea>,
			<textarea rows="1" cols="15"><?php echo $language[1] ?></textarea>,
			<textarea rows="1" cols="15"><?php echo $language[2] ?></textarea>,
			<input type="submit" id="ajouter">
			
		</div>
		<div class="pf_body_field">
			<h3>Genre</h3>
			<div class="in_radio">
				<div>
					<input type="radio" id="r_male" name="gender" value="male">
					<label for="r_male">Male</label>
				</div>
				<div>
					<input type="radio" id="r_female" name="gender" value="female">
					<label for="r_female">Female</label>
				</div>
			</div>
		</div>
		<div class="pf_body_images"><h3>∮ Images</h3></div>
	</div>
	<div>
		<div class="pf_body_field">
			<label>Email</label>
			<input class="in_text" type="text">
		</div>
		<div class="pf_body_field">
			<label>Mot Passe</label>
			<input class="in_text" type="text">
		</div>
	</div>
</div>
<input type="submit">
</form>