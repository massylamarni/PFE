/* GLOBAL */
var apt_inc = 0;			//!simulation

var list_el_id_active = 0;			//showprofile

const lastform = 2;			//bookform
var formnum = 0;
var apts = [];
var apt = {
	id: null,
	id_client: null,
	id_doctor: null,
	date: null,
	time: null,
	apt_date: null,
	apt_time: null,
	motif: "Motif Inconnus."
}
var date_display = {
	month: null,
	day: null,
	date: null,
}

var resultlist = ["£00000", "£00001", "£00002", "£00003", "£00004"];			//updateresultlist

var aptlist = [];			//updateaptlist

var apthistory = [];			//updateapthistory
var apthistory_state = [];



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
					if ((list_el.getElementsByClassName("list_el")[0].id == list_el_id_active) && (document.getElementsByClassName("secondary")[0].style.display == "flex"))
					{
						document.getElementsByClassName("secondary")[0].style.display = "none";
					}
					else
					{
						document.getElementsByClassName("secondary")[0].style.display = "flex";
						list_el_id_active = list_el.getElementsByClassName("list_el")[0].id;
					}
					console.log(list_el_id_active);
				}
			}
		);
	}
}

/* BOOKFORM */
function bookform(op, el)
{
	var bfc = document.getElementsByClassName("bookform_container")[0];
	var bf = document.getElementsByClassName("bookform_container")[0].children;
	if (op == 0)
	{
		bfc.classList.remove("hidden");
		sessionStorage.setItem('last_profile_id', el.id);
	}
	else
	{
		if (formnum < lastform)
		{
			bf[formnum].classList.add("hidden");
			bf[++formnum].classList.remove("hidden");
		}
		else if (formnum == lastform)
		{
			bf[formnum].classList.add("hidden");
			bf[++formnum].classList.remove("hidden");
			setTimeout(() => {
				bfc.classList.add("hidden");
				updateaptlist(2);
				resetbookform();
			}, 1000);
			apt.id = apt_inc++;
			if (sessionStorage.getItem('aptlist') !== null) aptlist = JSON.parse(sessionStorage.getItem('aptlist'));
			aptlist.push(apt.id);
			sessionStorage.setItem('aptlist', JSON.stringify(aptlist));
			apts.push({...apt});		//DB_SAVE
			console.log(apts);
		}
		savebookformstate()
	}
}
function resetbookform()
{
	var bf = document.getElementsByClassName("bookform_container")[0].children;
	bf[formnum].classList.add("hidden");
	formnum = 0;
	bf[formnum].classList.remove("hidden");
}
function savebookformstate()
{
	bfb_textarea = document.getElementsByClassName("bfb_textarea")[0];
	const MONTHS = ["Janvier", "Fevrier", "Mars", "Avril", "Mai", "Juin", "Juillet", "Aout", "Septembre", "Octobre", "Novembre", "Decembre"];
	const DAYS = ["Dim", "Lun", "Mar", "Mer", "Jeu", "Ven", "Sam"];
	var datetime_in = document.getElementById("datetime_in").value;
	var _datetime_in = new Date(datetime_in);
	var _date = new Date();
	apt.id = "0";
	apt.id_client = "0";
	apt.id_doctor = sessionStorage.getItem('last_profile_id');
	apt.date = _date.getDate() + '-' + _date.getMonth() + '-' +_date.getFullYear();
	apt.time = _date.getHours() + ':' + _date.getMinutes();
	apt.apt_date = _datetime_in.getDate() + '-' + _datetime_in.getMonth() + '-' +_datetime_in.getFullYear();
	apt.apt_time = _datetime_in.getHours() +  ':' + _datetime_in.getMinutes();
	if (bfb_textarea.value != "") apt.motif = document.getElementsByClassName("bfb_textarea")[0].value;

	date_display.day = DAYS[_datetime_in.getDay()];
	date_display.date = _datetime_in.getDate();
	date_display.month = MONTHS[_datetime_in.getMonth()];
	document.getElementsByClassName("bookform_result")[0].innerHTML = "RDV pour le " + date_display.day + " " + date_display.date + " " + date_display.month + " a " + apt.apt_time + "\nMotif: " + apt.motif;
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
function updateaptlist(op, el)
{
	if (sessionStorage.getItem('aptlist') !== null) aptlist = JSON.parse(sessionStorage.getItem('aptlist'));
	if (op == 0)
	{
		var aptlist_null = document.getElementsByClassName("aptlist_null")[0];
		if (aptlist.length != 0)
		{
			aptlist_null.innerHTML = "";
			for (i=0; i<aptlist.length; i++)
			{
				fetch(`components/aptlist.php?apt_id=${aptlist[i]}`)
  				.then(response => response.text())
  				.then(data => {
 					aptlist_null.innerHTML += data;
  				});
			}
		}
		else
		{
			aptlist_null.innerHTML = "Pas de rendez-vous en cours !";
		}
	}
	else if (op == 1)
	{
		for (i=0; i<aptlist.length; i++)
		{
			if (aptlist[i] == el.id)
			{
				aptlist.splice(i, 1);
			}
		}
		sessionStorage.setItem('aptlist', JSON.stringify(aptlist));
		updateaptlist(0);
		updateapthistory(2, el.id, 'RDV Annulé');
	}
	else
	{
		if (sessionStorage.getItem('aptlist') !== null) aptlist = JSON.parse(sessionStorage.getItem('aptlist'));
		aptlist.push(sessionStorage.getItem('last_apt_id'));
		sessionStorage.setItem('aptlist', JSON.stringify(aptlist));
	}
}
function updateapthistory(op, id, state)
{
	if (sessionStorage.getItem('apthistory') !== null) apthistory = JSON.parse(sessionStorage.getItem('apthistory'));
	if (sessionStorage.getItem('apthistory_state') !== null) apthistory_state = JSON.parse(sessionStorage.getItem('apthistory_state'));
	if (op == 0)
	{
		var apthistory_null = document.getElementsByClassName("apthistory_null")[0];
		var brief_state = document.getElementsByClassName("brief_state")[0];	
		if (apthistory.length != 0)
		{
			apthistory_null.innerHTML = "";
			for (i=0; i<apthistory.length; i++)
			{
				fetch(`components/apthistory.php?apt_id=${apthistory[i]}&state=${apthistory_state[i]}`)
  				.then(response => response.text())
  				.then(data => {
 					apthistory_null.innerHTML += data;
  				});
			}
		}
		else
		{
			apthistory_null.innerHTML = "Vous n'avez pris aucun rendez-vous";
		}
	}
	else
	{
		if (sessionStorage.getItem('apthistory') !== null) apthistory = JSON.parse(sessionStorage.getItem('apthistory'));
		apthistory.push(id);
		sessionStorage.setItem('apthistory', JSON.stringify(apthistory));
		if (sessionStorage.getItem('apthistory_state') !== null) apthistory_state = JSON.parse(sessionStorage.getItem('apthistory_state'));
		apthistory_state.push(state);
		sessionStorage.setItem('apthistory_state', JSON.stringify(apthistory_state));
		updateapthistory(0);
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
//le bouton ajouter une langue .
var ajouter=document.getElementById('ajouter');
var langue=document.getElementsByClassName('pf_body_field')[7];

ajouter.addEventListener('click',function(event){
	event.preventDefault();
	let nouvel=document.createElement('textarea');
	nouvel.after(ajouter)
	nouvel.rows=1;
	nouvel.cols=15;
	nouvel.addEventListener('keydown',function(event){
		if(nouvel.value.length <= 15){
			sizeArea();
		}else{event.preventDefault();
			nouvel.value = nouvel.value.slice(0,-1);}
	})
	langue.appendChild(nouvel);
});
*/