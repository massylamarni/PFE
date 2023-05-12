/* GLOBAL */

var date_display = {			//generic
	month: null,
	day: null,
	date: null,
	time: null
}

var last_pfp_id = 0;			//showprofile

const lastform = 2;			//bookform
var formnum = 0;

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
function bookform(op, doctor_id)
{
	var bfcs = document.getElementsByClassName("bookform_container");
	for (let i = 0; i < bfcs.length; i++)
	{
		if (bfcs[i].id == doctor_id)
		{
			var bfc = bfcs[i];
			var bf = bfc.children;
		}
	}
	if (op == 0)	//display
	{
		bookform(3, doctor_id);
		bfc.classList.remove("hidden");
	}
	else if (op == 1)	//boookform next
	{
		bf[formnum].classList.add("hidden");
		bf[++formnum].classList.remove("hidden");
	}
	else if (op == 3)	//reset
	{
		bf[formnum].classList.add("hidden");
		formnum = 0;
		bf[formnum].classList.remove("hidden");
	}
	//save_state
	var appt_date_in_obj = new Date(bfc.getElementsByClassName("appt_date")[0].value);
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

// ajouter une langue
function ajouterunelangue(){
	let langue=document.getElementById('prelangue');
	var ajouter=document.getElementById('ajouter');
	ajouter.addEventListener('click',function(event){
		event.preventDefault();
		let nouvel=document.createElement('textarea');
		nouvel.after(ajouter)
		nouvel.rows=1;
		nouvel.cols=15;
    	nouvel.style.display='block';
		nouvel.style.marginTop='3px';
		/*nouvel.addEventListener('keydown',function(event){if(nouvel.value.length <= 15){sizeArea();}else{event.preventDefault();nouvel.value = nouvel.value.slice(0,-1);}})*/
		nouvel.classList.add('langue');
		langue.appendChild(nouvel);
	});
}


//ajouter diplome et classification
let diplome=document.getElementById('prediplome');
function ajouterundiplome(){
	var ajouterdiplome=document.getElementById('diplome');
	
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
		annee.classList.add('classannee');
		nouvel.classList.add('classdiplome');
		/*	nouvel.addEventListener('keydown',function(event){if(nouvel.value.length <= 15){sizeArea();}else{event.preventDefault();nouvel.value = nouvel.value.slice(0,-1);}})annee.addEventListener('keydown',function(event){if(annee.value.length <= 15){sizeArea();}else{event.preventDefault();annee.value = nouvel.value.slice(0,-1);}})*/
		let container=document.createElement('div');
		container.appendChild(annee);
		container.appendChild(nouvel);
		container.classList.add('tarifdiv');
		diplome.appendChild(container);
	});
}

//ajouter tarifs
let tarifs=document.getElementById('pretarif');
function ajoutertarifs(){
	let ajoutertarifs=document.getElementById('tarif');
	
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
		nouvel.classList.add('classtarif');
	    prix.classList.add('classprix');
		/*	nouvel.addEventListener('keydown',function(event){if(nouvel.value.length <= 15){sizeArea();}else{event.preventDefault();nouvel.value = nouvel.value.slice(0,-1);}})prix.addEventListener('keydown',function(event){if(prix.value.length <= 15){sizeArea();}else{event.preventDefault();prix.value = nouvel.value.slice(0,-1);}})*/
		let container=document.createElement('div');
		container.appendChild(nouvel);
		container.appendChild(prix);
		container.classList.add('tarifdiv');
		tarifs.appendChild(container);
	});
}


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
console.log(tablangue);
let  tablanguejson = JSON.stringify(tablangue);
document.getElementById("languages_input").value = tablanguejson;
console.log( typeof document.getElementById("languages_input").value);
//modifie tarif 
let tabtarif=[];
	
	let classtrif=document.getElementsByClassName('classtarif');
	let classprix=document.getElementsByClassName('classprix');
    let n=0;
	 for(let y=0;y<classtrif.length;y++){
		if(classtrif[y].value.trim().length!=0 && classprix[y].value.trim().length!=0){
		let minitabtarif=[];
		minitabtarif[0]=classtrif[y].value;
		minitabtarif[1]=classprix[y].value;
		tabtarif[n]=minitabtarif ;
		 n++;}
		else if(classtrif[y].value.trim().length==0 && classprix[y].value.trim().length==0){
			tarifs.removeChild(classprix[y]);
			tarifs.removeChild(classtrif[y]);
		}
		
	}
	console.log(tabtarif);
	let  tabtarifjson = JSON.stringify(tabtarif);
document.getElementById("pricing_input").value = tabtarifjson;
	//modifie diplome
	let tabdiplome=[];
	let classdiplome=document.getElementsByClassName('classdiplome');
	let classannee=document.getElementsByClassName('classannee');
    let p=0;
	 for(let u=0;u<classdiplome.length;u++){
		if(classdiplome[u].value.trim().length!=0 && classannee[u].value.trim().length!=0){
		let minitabdiplome=[];
		minitabdiplome[0]=classannee[u].value;
		minitabdiplome[1]=classdiplome[u].value;
		tabdiplome[p]=minitabdiplome ;
		 p++;}
		else if(classdiplome[u].value.trim().length==0 && classannee[u].value.trim().length==0){
			diplome.removeChild(classdiplome[u]);
			diplome.removeChild(classannee[u]);
		}
		
	}
	console.log(tabdiplome);
	let  tabdiplomejson = JSON.stringify(tabdiplome);
document.getElementById("dq_input").value = tabdiplomejson;


document.getElementById("editprofile").submit();

})};



	





	

