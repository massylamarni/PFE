<?php
$pf_id = "pf2";
$pf_image = "assets/pfp2.png";
$pf_name = "User Name";
$pf_location = "COlorado, USA";
$pf_speciality = '<a href="#">Psychologue, </a><a href="#">Dermatologue</a>';
$pf_description = "Spécialisé dans le traitement des maladies de la peau, des ongles et des cheveux,\nnotamment les éruptions cutanées, les infections de la peau, l'acné, les taches de\nvieillesse, les cancers de la peau, les allergies cutanées et les affections auto-immunes.";
$pf_phone = "0752692364";
$pf_adress = "75017 Colorado, USA";
$pf_worktime = "Lundi : 09h30 - 12h30, 13h30 - 19h30\nMardi : 09h30 - 12h30, 13h30 - 19h30\nMercredi : 09h30 - 13h30\nJeudi : 09h30 - 12h30, 13h30 - 19h30\nVendredi : 09h30 - 12h30, 13h30 - 19h30";
$pf_pricing = "Consultation simple		100 €\nConsultation avec acte(s)	200 €";
$pf_dq = "1977	Diplôme d'État de docteur en médecine - Université Paris 11 - Paris-Saclay\n1977	D.E.S. Dermatologie et vénéréologie - UFR de médecine Lariboisière-Saint-Louis";
$pf_languages = "Anglais, Espagnol et Francais";
?>
<div class="pf" id="<?php echo $pf_id ?>">
	<div class="pf_header">
		<img src="assets/pfp2.png">
		<div class="pf_header_text">
			<div class="pf_header_text_name"><?php echo $pf_name ?></div>
			<div class="pf_header_text_location"><?php echo $pf_location ?></div>
			<div class="pf_header_text_speciality"><?php echo $pf_speciality ?></div>
		</div>
	</div>
	<div class="pf_body">
		<div class="pf_body_field"><h3>Description</h3>
			<pre><?php echo $pf_description ?></pre>
		</div>
		<div class="pf_body_field"><h3>Numero telephone</h3><?php echo $pf_phone ?></div>
		<div class="pf_body_field"><h3>Adresse</h3><?php echo $pf_adress ?></div>
		<div class="pf_body_field"><h3>Horaires de travail</h3>
			<pre><?php echo $pf_worktime ?></pre>
		</div>
		<div class="pf_body_field"><h3>Tarifs</h3>
			<pre><?php echo $pf_pricing ?></pre>
		</div>
		<div class="pf_body_field"><h3>Diplomes & Qualifications</h3>
			<pre><?php echo $pf_dq ?></pre>
		</div>
		<div class="pf_body_field"><h3>Langues parlées</h3><?php echo $pf_languages ?></div>
		<div class="pf_body_images"><h3>∮ Images</h3></div>
	</div>
</div>