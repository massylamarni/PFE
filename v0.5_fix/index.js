/* GLOBAL */

var date_display = {			//generic
	month: null,
	day: null,
	date: null,
	time: null
}

var appt = {
	appt_doctor_id: null,
	appt_date: null,
	appt_keep_date: null,
	appt_motif: "Motif Inconnus."
};

var last_pfp_id = 0;			//showprofile

const lastform = 2;			//bookform
var formnum = 0;

var resultlist = [0, 1, 2, 3, 4];			//updateresultlist

var apptlist = [];			//updateapptlist
var appt_ids = 0;

/* GENERIC */
function sessionstorage(v, k, n)
{
	if (sessionStorage.getItem(k) !== null) v = JSON.parse(sessionStorage.getItem(k));
	v.push(n);
	sessionStorage.setItem(k, JSON.stringify(v));
}

/* APTLIST & RESULTLIST */
function showprofile()
{
	var list_els = document.getElementsByClassName("list_el");
	for (i = 0; i < list_els.length; i++)
	{
		let list_el = list_els[i];
		list_el.addEventListener("click", 
			function(event)
			{
				if ((event.target.tagName != 'P') && (event.target.tagName != 'A'))
				{
					if ((list_el.id == last_pfp_id) && (document.getElementsByClassName("secondary")[0].style.display == "flex"))
					{
						document.getElementsByClassName("secondary")[0].style.display = "none";
					}
					else
					{
						document.getElementsByClassName("secondary")[0].style.display = "flex";
						last_pfp_id = list_el.id;
					}
					console.log("last_pfp_id: " + last_pfp_id);
				}
				else if ((event.target.tagName == 'P'))
				{
					console.log("motif: " + list_el.getElementsByClassName("motif")[0].innerHTML);
				}
			}
		);
	}
}

/* BOOKFORM */
function bookform(op, brief_book)
{
	var bfc = document.getElementsByClassName("bookform_container")[0];
	var bf = bfc.children;
	if (op == 0)	//display
	{
		bookform(3);
		bfc.classList.remove("hidden");
		sessionStorage.setItem('last_profile_id', brief_book.id);
	}
	else if (op == 1)	//boookform next
	{
		bf[formnum].classList.add("hidden");
		bf[++formnum].classList.remove("hidden");
	}
	else if (op == 2)	//endscreen & save_data
	{
		bf[formnum].classList.add("hidden");
		bf[++formnum].classList.remove("hidden");
		setTimeout(() => {
			bfc.classList.add("hidden");
			fetch(`components/appt.php?op=0&appt_doctor_id=${appt.appt_doctor_id}
			&appt_date=${appt.appt_date.toUTCString()}&appt_keep_date=${appt.appt_keep_date.toUTCString()}&appt_motif=${appt.appt_motif}`)
			.then(response => response.text())
			.then(data => {
				document.getElementsByClassName("fetchto")[0].innerHTML += data;
			});
			bookform(3);
		}, 1000);
	}
	else if (op == 3)	//reset
	{
		var bf = document.getElementsByClassName("bookform_container")[0].children;
		bf[formnum].classList.add("hidden");
		formnum = 0;
		bf[formnum].classList.remove("hidden");
	}
	//save_state
	var datetime_in = document.getElementById("datetime_in").value;
	var datetime_in_obj = new Date(datetime_in);
	appt.appt_doctor_id = sessionStorage.getItem('last_profile_id');
	appt.appt_date = datetime_in_obj;
	appt.appt_keep_date = new Date();
	let bfb_textarea = document.getElementsByClassName("bfb_textarea")[0];
	if (bfb_textarea.value != "") appt.appt_motif = document.getElementsByClassName("bfb_textarea")[0].value;
	
	const MONTHS = ["Janvier", "Fevrier", "Mars", "Avril", "Mai", "Juin", "Juillet", "Aout", "Septembre", "Octobre", "Novembre", "Decembre"];
	const DAYS = ["Dim", "Lun", "Mar", "Mer", "Jeu", "Ven", "Sam"];
	date_display.month = MONTHS[datetime_in_obj.getMonth()];
	date_display.day = DAYS[datetime_in_obj.getDay()];
	date_display.date = datetime_in_obj.getDate();
	date_display.time = datetime_in_obj.getHours() + ':' + datetime_in_obj.getMinutes();

	document.getElementsByClassName("bookform_result")[0].innerHTML = "RDV pour le " + date_display.day + " " 
	+ date_display.date + " " + date_display.month + " a " + date_display.time + "\nMotif: " + appt.appt_motif;
}

/* RESULTLIST */
function updateresultlist()
{
	if (resultlist.length != 0)
	{
		var list_null = document.getElementsByClassName("resultlist_null")[0];
		list_null.innerHTML = "";
		for (i=0; i<resultlist.length; i++)
		{
			fetch(`components/resultlist.php?id=${resultlist[i]}`)
  			.then(response => response.text())
  			.then(data => {
 				list_null.innerHTML += data;
  			});
		}
	}
}

/* INDEX */
function updateapptlist(op, el)
{
	if (op == 1)	//remove
	{
		fetch(`components/appt.php?op=3&appt_id=${el.id}`)
  		.then(response => response.text())
  		.then(data => {
			document.getElementsByClassName("fetchto")[0].innerHTML += data;
		});
		fetch(`components/appt.php?op=1&patient_appthistory=${el.id}&appthistory_state=RDV Annule`)
  		.then(response => response.text())
  		.then(data => {
			document.getElementsByClassName("fetchto")[0].innerHTML += data;
			updateapptlist(0);
  		});
	}
}

/*
//funtion for the size of texts area
function sizeArea(){let maxTextArea=[50,15,15,500,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15];
	let el=document.getElementsByTagName('textarea');
	for (i=0; i<el.length; i++){
		let line = el[i].value.split('\n');
		let row = line.length;
		let col = line.reduce(function(max, line){
			return Math.max(max, line.length);
		}, 0);
		el[i].rows=row;
		el[i].cols=col;
	}
};

var el=document.getElementsByTagName('textarea');
for (let k=0;el.length;k++){
el[k].addEventListener('keydown',function(event){
		if(el[k].value.length<=maxTextArea[k]){
			sizeArea();
		}else{
			event.preventDefault();
			el[k].value = el[k].value.slice(0,-1);
		}
	}
)
}
*/

// ajouter une langue
let langue=document.getElementById('prelangue');
function ajouterunelangue(){
	var ajouter=document.getElementById('ajouter');



ajouter.addEventListener('click',function(event){
	event.preventDefault();
	let nouvel=document.createElement('textarea');
	nouvel.after(ajouter)
	nouvel.rows=1;
	nouvel.cols=15;
    nouvel.style.display='block';
	nouvel.style.marginTop='3px';
	
	/*nouvel.addEventListener('keydown',function(event){
		if(nouvel.value.length <= 15){
			sizeArea();
		}else{event.preventDefault();
			nouvel.value = nouvel.value.slice(0,-1);}
	})*/
	nouvel.classList.add('langue');
	langue.appendChild(nouvel);
});}


//ajouter diplome et classification
function ajouterundiplome(){
var ajouterdiplome=document.getElementById('diplome');

let diplome=document.getElementById('prediplome')

ajouterdiplome.addEventListener('click',function(event){
	event.preventDefault();
	let nouvel=document.createElement('textarea');
	let annee=document.createElement('textarea');
	nouvel.after(ajouterdiplome);
	annee.after(diplome);
	nouvel.rows=1;
	nouvel.cols=50;
	annee.rows=1;
	annee.cols=10;
	annee.classList.add('pf_body_field');
	nouvel.classList.add('pf_body_field');
/*	nouvel.addEventListener('keydown',function(event){
		if(nouvel.value.length <= 15){
			sizeArea();
		}else{event.preventDefault();
			nouvel.value = nouvel.value.slice(0,-1);}
	})
	annee.addEventListener('keydown',function(event){
		if(annee.value.length <= 15){
			sizeArea();
		}else{event.preventDefault();
			annee.value = nouvel.value.slice(0,-1);}
	})*/

	let container=document.createElement('div');
	  container.appendChild(annee);
	  container.appendChild(nouvel);
	  container.classList.add('tarifdiv');
	diplome.appendChild(container);
	

})};

//ajouter tarifs
function ajoutertarifs(){
let ajoutertarifs=document.getElementById('tarif');

let tarifs=document.getElementById('pretarif');

ajoutertarifs.addEventListener('click',function(event){
	event.preventDefault();
	let nouvel=document.createElement('textarea');
	let prix=document.createElement('textarea');
	nouvel.after(ajoutertarifs);
	prix.after(ajoutertarifs);
	nouvel.rows=1;
	nouvel.cols=50;
	prix.rows=1;
	prix.cols=10;
	prix.classList.add('pf_body_field');
	nouvel.classList.add('pf_body_field');
	prix.before(ajoutertarifs);
	nouvel.after(ajoutertarifs);
/*	nouvel.addEventListener('keydown',function(event){
		if(nouvel.value.length <= 15){
			sizeArea();
		}else{event.preventDefault();
			nouvel.value = nouvel.value.slice(0,-1);}
	})
	prix.addEventListener('keydown',function(event){
		if(prix.value.length <= 15){
			sizeArea();
		}else{event.preventDefault();
			prix.value = nouvel.value.slice(0,-1);}
	})*/
	let container=document.createElement('div');
	  container.appendChild(nouvel);
	  container.appendChild(prix);
	  container.classList.add('tarifdiv');
	tarifs.appendChild(container);
	

})};

//ajouter un rendez-vous
function ajouterunrendez(){
let ajouterrendez=document.getElementById('ajouterrendez');

ajouterrendez.addEventListener('click',function(event){
	event.preventDefault();
    let photo=document.createElement('img');
	photo.src='assets/pfp2.png';
	

	let nom=document.createElement('input');
	nom.type='text';
    nom.classList.add('pfp_text_name');
	nom.style.width='128px';

    let pfp_text=document.createElement('div');
	pfp_text.classList.add('pfp_text');
    pfp_text.appendChild(nom);

	let pfp =document.createElement('div');
	pfp.appendChild(photo);
	pfp.appendChild(pfp_text);
    pfp.classList.add('pfp');

	let calend=document.createElement('input');
	calend.type='datetime-local';
	calend.classList.add('brief_datetime');
	calend.style.width='100px';
	calend.style.height='20px';
	calend.style.marginTop='37px';
	calend.style.padding='20px;'

	let divtime=document.createElement('div');
	divtime.classList.add('brief_datetime');

	let motif=document.createElement('p');
	let motif2=document.createTextNode('Motife de consultation');
	motif.appendChild(motif2);
	motif.classList.add('brief_motif');
	motif.addEventListener('mouseover',function(event){
		event.preventDefault();
		motif.style.cursor='pointer';
		motif.style.textDecoration='underline';
	});
	motif.addEventListener('mouseout',function(event){
		event.preventDefault();
		motif.style.textDecoration='none';
	})

	let ajouter=document.createElement('p');
	let ajouter2=document.createTextNode('ajouter');
	ajouter.appendChild(ajouter2);
	ajouter.classList.add('brief_cancel');
	ajouter.addEventListener('mouseover',function(event){
		event.preventDefault();
		ajouter.style.cursor='pointer';
		ajouter.style.textDecoration='underline';

	});
	ajouter.addEventListener('mouseout',function(event){
		event.preventDefault();
		ajouter.style.textDecoration='none';
	})

	let list_el_brief=document.createElement('div');
	list_el_brief.appendChild(calend);
	list_el_brief.appendChild(divtime);
	list_el_brief.appendChild(motif);
	list_el_brief.appendChild(ajouter);
	list_el_brief.classList.add('list_el_brief');
	

	let tout=document.createElement('div');
	tout.appendChild(pfp);
	tout.appendChild(list_el_brief);
    tout.classList.add('list_el');
	
	

	

	let list=document.getElementsByClassName('list')[0];
	list.appendChild(tout);

	let generale=document.getElementsByClassName('std_containerI')[0];
	generale.appendChild(list);
})};

//modifie
function modifie(){
let modifie=document.getElementById('modifie');
let langage=document.getElementsByClassName('langue');
modifie.addEventListener('click',function(event){
	event.preventDefault();
    let tablangue=[];
	let m=0;
for(let g=0;g<langage.length;g++){
	if(langage[g].value.trim().length!=0) {
	tablangue[m]=langage[g].value;
	m++;
	}
	if(langage[g].value.trim().length==0) langue.removeChild(langage[g]);

}



})};




