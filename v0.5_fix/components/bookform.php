<div class="bookform_container hidden">
	<div class="bookform">
		<div class="bookform_title"><h3>Horaire</h3></div>
		<input id="datetime_in" type="datetime-local">
		<div class="bookform_submit"><button onclick="bookform(1)">OK</button></div>
	</div>
	<div class="bookform hidden">
		<div class="bookform_title"><h3>Motif de consultation</h3></div>
		<div class="bookform_body">
			<p>Donnez une breve description de votre motif de consultation:</p>
			<textarea class="bfb_textarea" placeholder="(Optionnel)"></textarea>
		</div>
		<div class="bookform_submit"><button onclick="bookform(1)">OK</button></div>
	</div>
	<div class="bookform hidden">
		<div class="bookform_title"><h3>Confirmation</h3></div>	
		<div class="bookform_body">
			<pre class="bookform_result"></pre>
		</div>
		<div class="bookform_submit"><button onclick="bookform(3)">Annuler</button></div>
		<div class="bookform_submit"><button onclick="bookform(2)">OK</button></div>
	</div>
	<div class="bookform hidden">
		<div class="bookform_title"><h3>Rendez-vous confirmé !</h3></div>
		<div class="bookform_body">...</div>
		</div>
	</div>
</div>