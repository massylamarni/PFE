/* GLOBAL */

var date_display = {			//generic
	month: null,
	day: null,
	date: null,
	time: null
}

var last_pfp_id = 0;			//showprofile
var formnum = 0;				//bookform

/* APTLIST & RESULTLIST */

function showprofile()
{
	let list_el = document.getElementsByClassName("list_el");
	for (let i = 0; i < list_el.length; i++)
	{
		list_el[i].addEventListener("click", function(event){
			if ((event.target.tagName == 'IMG') && (!event.target.classList.contains('prevent_list_el')))	//show doctor profile
			{
				if ((list_el[i].id == last_pfp_id) && (document.getElementsByClassName("secondary")[0].style.display == "flex"))
				{
					document.getElementsByClassName("secondary")[0].style.display = "none";
				}
				else
				{
					if (last_pfp_id != 0) document.getElementById(`pf_${last_pfp_id}`).remove();
					last_pfp_id = list_el[i].id;
					fetch(`components/doctor_profile.php?doctor_id=${last_pfp_id}`)
					.then(response => response.text())
					.then(data => {
						document.getElementById('doctor_profile').insertAdjacentHTML('beforeend', data);
					});
					
					document.getElementsByClassName("secondary")[0].style.display = "flex";
				}
			}
		});
	}
}


/* BOOKFORM */
function bookform(op, doctor_id)
{
	let bfc = document.getElementsByClassName("bookform_container")[0];
	if (op == 0)	//display
	{
		if (bfc != null)
		{
			bookform(3, doctor_id);
			bfc.remove();
		}
		fetch(`components/bookform.php?doctor_id=${doctor_id}`)
		.then(response => response.text())
		.then(data => {
			document.getElementById('toggle_bookform').insertAdjacentHTML('beforeend', data);
			bfc = document.getElementsByClassName("bookform_container")[0];
			bfc.classList.remove("hidden");
		});
	}
	else if (op == 1)	//boookform next
	{
		let bf = bfc.children;
		bf[formnum].classList.add("hidden");
		bf[++formnum].classList.remove("hidden");
		bookform(4, doctor_id);
	}
	else if (op == 3)	//reset
	{
		let bf = bfc.children;
		bf[formnum].classList.add("hidden");
		formnum = 0;
		bf[formnum].classList.remove("hidden");
	}
	else if (op == 4)	//save_state
	{
		let appt_date_in_obj = new Date(bfc.getElementsByClassName("appt_date")[0].value);
		if (bfc.getElementsByClassName("appt_motif")[0].value != "") motif_in = bfc.getElementsByClassName("appt_motif")[0].value; else motif_in = "Motif inconnus.";
		
		const MONTHS = ["Janvier", "Fevrier", "Mars", "Avril", "Mai", "Juin", "Juillet", "Aout", "Septembre", "Octobre", "Novembre", "Decembre"];
		const DAYS = ["Dim", "Lun", "Mar", "Mer", "Jeu", "Ven", "Sam"];
		date_display.month = MONTHS[appt_date_in_obj.getMonth()];
		date_display.day = DAYS[appt_date_in_obj.getDay()];
		date_display.date = appt_date_in_obj.getDate();
		date_display.time = appt_date_in_obj.getHours() + ':' + appt_date_in_obj.getMinutes();
	
		bfc.getElementsByClassName("bookform_result")[0].innerHTML = "RDV pour le " + date_display.day + " " 
		+ date_display.date + " " + date_display.month + " a " + date_display.time + "\nMotif: " + motif_in;
	}
}

/* sanitise input */
function txtarea_autosize(op)
{
	let minlen=[10, 5, 100, 10, 50, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 50, 50];
	let maxlen=[30, 15, 500, 15, 100, 9, 9, 9, 9, 9, 9, 9, 9, 9, 9, 9, 9, 9, 9, 50, 50];
	let txtarea=document.getElementsByClassName('txtarea');
	if (op == 0)
	{
		for (let i = 0; i < txtarea.length; i++) {
			txtarea[i].addEventListener('input', function(event) {
				txtarea_autosize();
			});
		}
		txtarea_autosize();
	}
	else
	{
		for (let i = 0; i < txtarea.length; i++)
		{
			console.log(txtarea[i]);
			if (txtarea[i].tagName === 'INPUT')
			{
				if (txtarea[i].value.length < minlen[i])
				{
					txtarea[i].style.width = minlen[i] + 'ch';
				}
				else if ((txtarea[i].value.length >= minlen[i]) && txtarea[i].value.length <= maxlen[i])
				{
					txtarea[i].style.width = txtarea[i].value.length+1 + 'ch';
				}
				else
				{
					txtarea[i].value = txtarea[i].value.slice(0, maxlen[i]);
				}
			}
			else if (txtarea[i].tagName === 'TEXTAREA')
			{
				if (txtarea[i].value.length <= maxlen[i])
				{
					txtarea[i].style.height = '1em';
					txtarea[i].style.width = minlen[i] + '%';
					if (txtarea[i].scrollHeight > txtarea[i].offsetHeight)
					{
						txtarea[i].style.height = 'auto';
						txtarea[i].style.height = txtarea[i].scrollHeight + 'px';
					}
				}
				else
				{
					txtarea[i].value = txtarea[i].value.slice(0, maxlen[i]);
				}
			}
		}
	}	
}

//add appt (doctor side)
function addto_apptlist(op, el)
{
	if (op == 0)
	{
		fetch('components/doctor_apptlist_el_blank.php')
		.then(response => response.text())
		.then(data => {
			document.getElementsByClassName('list')[0].insertAdjacentHTML('beforeend', data);
		});
	}
	else
	{
		el.parentElement.parentElement.parentElement.remove();
	}
}

//ajouter tarifs
function add_pricing()
{	
	let pretarif = document.getElementById('pretarif');
	let adjhtml = '<div class="tarif_el flex fiveg"> <input placeholder="Sevice" class="txtarea tarif_el_service"></input> <input placeholder="Prix" class="txtarea tarif_el_price"></input></div>';
	pretarif.insertAdjacentHTML('beforeend', adjhtml);
}

//ajouter diplome et classification
function add_dq()
{
	let prediplome = document.getElementById('prediplome');
	let adjhtml = '<div class="dq_el flex flex fiveg"><input class="txtarea dq_el_date"></input><input class="txtarea dq_el_event"></input></div>';
	prediplome.insertAdjacentHTML('beforeend', adjhtml);
}

// ajouter une langue
function add_language()
{
	let prelangue = document.getElementById('prelangue');
	let adjhtml = '<input class="txtarea language_el"></input>';
	prelangue.insertAdjacentHTML('beforeend', adjhtml);
}

function getinput_doctor_editprofile()
{
	//pricing
	let tarif_el_service = document.getElementsByClassName('tarif_el_service');
	let tarif_el_price = document.getElementsByClassName('tarif_el_price');
	let save_pricing = [];
	let n = 0;
	for (let i = 0; i < tarif_el_service.length; i++)
	{
		if ((tarif_el_service[i].value.trim().length != 0) && (tarif_el_price[i].value.trim().length != 0))
		{
			let temp = [];
			temp[0] = tarif_el_service[i].value;
			temp[1] = tarif_el_price[i].value;
			save_pricing[n] = temp;
			n++;
		}
	}
	save_pricing = JSON.stringify(save_pricing);
	console.log(save_pricing);
	document.getElementById('pricing_input').value = save_pricing;

	//dq
	let dq_el_date = document.getElementsByClassName('dq_el_date');
	let dq_el_event = document.getElementsByClassName('dq_el_event');
	let save_dq = [];
	n = 0;
	for (let i = 0; i < dq_el_date.length; i++)
	{
		if ((dq_el_date[i].value.trim().length != 0) && (dq_el_event[i].value.trim().length != 0))
		{
			let temp = [];
			temp[0] = dq_el_date[i].value;
			temp[1] = dq_el_event[i].value;
			save_dq[n] = temp;
			n++;
		}
	}
	save_dq = JSON.stringify(save_dq);
	console.log(save_dq);
	document.getElementById('dq_input').value = save_dq;

	//language

	let language_el = document.getElementsByClassName('language_el');
	let save_language = [];
	n = 0;
	for (let i = 0; i < language_el.length; i++)
	{
		if (language_el[i].value.trim().length != 0)
		{
			save_language[n] = language_el[i].value;
			n++;
		}
	}
	save_language = JSON.stringify(save_language);
	console.log(save_language);
	document.getElementById('languages_input').value = save_language;

	//google map coord 
	previousClickedLocation = JSON.stringify( previousClickedLocation);
	console.log(previousClickedLocation);
	document.getElementById('map_coord').value =  previousClickedLocation;


	document.getElementById('editprofile').submit();
}

//inscription
/*function inscription(){
let inscription=document.getElementById('inscription');
let divinscription=document.getElementById('divinscription');
inscription.addEventListener('click',function(event){
	event.preventDefault();
	divinscription.classList.toggle('hidden');
	divinscription.classList.toggle('inscription');
});}
/*
let profile=document.getElementById('profile');
let divprofile=document.getElementById('divprofile');
profile.addEventListener('click',function(event){
	event.preventDefault();
	divprofile.classList.toggle('hidden');
	divprofile.classList.toggle('profile');
});*/
function profile(){
  let divprofile=document.getElementById('divprofile');
  divprofile.classList.toggle('hidden');
  divprofile.classList.toggle('profile');
}
function toggle_signup(){
	document.getElementById("toggle_signup").classList.toggle('hidden');
}

//photo de profile
/*let photodeprofile=document.getElementById('photodeprofile');
let urlimage=URL.createObjectURL(photodeprofile.files[0]);
console.log(urlimage);*/

function verifyRecaptcha() {
	var response = grecaptcha.getResponse();
	var errorMessage = document.getElementById('recaptcha_error_message');
	if (response.length === 0) {
     
		errorMessage.textContent = 'Please complete the reCAPTCHA.';

	  return false;
	} else {
	  return true;
	}
  }
  
function toggle_motif(op, el)
{
	let brief_motif_in_container = document.getElementsByClassName('brief_motif_in_container')[0];
	if (op == 0)	//set motif
	{
		if (brief_motif_in_container != null)
		{
			if (brief_motif_in_container.style.display == 'flex') brief_motif_in_container.style.display = 'none';
			else brief_motif_in_container.style.display = 'flex';
		}
		else
		{
			let adjhtml = '<div class="brief_motif_in_container"><div class="triangle_up"></div><div class="brief_motif_in"><p>Donnez une breve description de votre motif de consultation: </p><textarea name="appt_motif"></textarea><button type="button" onclick="toggle_motif(0, this)">ok</button></div></div>';
			el.insertAdjacentHTML("afterend", adjhtml);
		}	
	}
	else if (op == 1)	//get motif
	{
		if (brief_motif_in_container != null)
		{
			if (brief_motif_in_container.style.display == 'flex') brief_motif_in_container.style.display = 'none';
			else brief_motif_in_container.style.display = 'flex';
		}
		else
		{
			let motif = el.parentElement.parentElement.getElementsByClassName('motif')[0];
			let adjhtml = `<div class="brief_motif_in_container"><div class="triangle_up"></div><div class="brief_motif_in"><p>${motif.innerHTML}</p></div></div>`;
			el.insertAdjacentHTML("afterend", adjhtml);
		}
	}
}


function previewImage(event) {
	var input = event.target;
	if (input.files && input.files[0]) {
	  var reader = new FileReader();
	  reader.onload = function (e) {
		var previewElement = document.getElementById("preview");
		previewElement.src = e.target.result;
	  }
	  reader.readAsDataURL(input.files[0]);
	}
  }
  