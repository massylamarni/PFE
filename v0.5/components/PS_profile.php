<?php
$id = "£00000";
$name = "User Name";
$email = "dummy@email.com";
$password = "**********";
$phone = "0752692364";
$bday = date("d-m-y");
$gender = "M";
$pf_img = "assets/pfp2.png";
$location = "75017 Colorado, USA";
$speciality = array("Psychologue", "Dermatologue");
$description = "Spécialisé dans le traitement des maladies de la peau, des ongles et des cheveux,\nnotamment les éruptions cutanées, les infections de la peau, l'acné, les taches de\nvieillesse, les cancers de la peau, les allergies cutanées et les affections auto-immunes.";
$worktime = array(array("09h30", "19h30"), array("09h30", "19h30"), array("09h30", "19h30"), array("09h30", "19h30"), array("09h30", "19h30"), array("", ""), array("09h30", "19h30"));
$pricing = array(array("Consultation simple", "100 £"), array("Consultation avec acte", "200 £"));
$dq = array(array("1977", "Diplôme d'État de docteur en médecine - Université Paris 11 - Paris-Saclay"), array("1977", "D.E.S. Dermatologie et vénéréologie - UFR de médecine Lariboisière-Saint-Louis"));
$language = array("Anglais", "Francais", "Espagnol");
?>

<div class="pf" id="<?php echo $id ?>">
	<div class="pf_header">
		<img src="<?php echo $pf_img ?>">
		<div class="pf_header_text">
			<div class="pf_header_text_name"><?php echo $name ?></div>
			<div class="pf_header_text_id"><?php echo $id ?></div>
			<div class="pf_header_text_speciality">
				<?php echo $speciality[0] ?>, 
				<?php echo $speciality[1] ?>
			</div>
		</div>
	</div>
	<div class="pf_body">
		<div class="pf_body_field"><h3>Description</h3>
			<pre><?php echo $description ?></pre>
		</div>
		<div class="pf_body_field"><h3>Numero telephone</h3><?php echo $phone ?></div>
		<div class="pf_body_field"><h3>Adresse</h3><?php echo $location ?></div>
		<div class="pf_body_field"><h3>Date Naissance</h3><?php echo $bday ?></div>
		<div class="pf_body_field"><h3>Horaires de travail</h3>
			<pre>
				Dim:<?php echo $worktime[0][0] ?> - <?php echo $worktime[0][1] ?>
				Lun:<?php echo $worktime[1][0] ?> - <?php echo $worktime[1][1] ?>
				Mar:<?php echo $worktime[2][0] ?> - <?php echo $worktime[2][1] ?>
				Mer:<?php echo $worktime[3][0] ?> - <?php echo $worktime[3][1] ?>
				Jeu:<?php echo $worktime[4][0] ?> - <?php echo $worktime[4][1] ?>
				Ven:<?php echo $worktime[5][0] ?> - <?php echo $worktime[5][1] ?>
				Sam:<?php echo $worktime[6][0] ?> - <?php echo $worktime[6][1] ?>
			</pre>
		</div>
		<div class="pf_body_field"><h3>Tarifs</h3>
			<pre>
				<?php echo $pricing[0][0] ?> <?php echo $pricing[0][1] ?>
				<?php echo $pricing[1][0] ?> <?php echo $pricing[1][1] ?>
			</pre>
		</div>
		<div class="pf_body_field"><h3>Diplomes & Qualifications</h3>
			<pre>
				<?php echo $dq[0][0] ?> <?php echo $dq[0][1] ?>
				<?php echo $dq[1][0] ?> <?php echo $dq[1][1] ?>
			</pre>
		</div>
		<div class="pf_body_field"><h3>Langues parlées</h3>
			<?php echo $language[0] ?>
			<?php echo $language[1] ?>
			<?php echo $language[2] ?>
		</div>
		<div class="pf_body_images"><h3>∮ Images</h3></div>
	</div>
</div>