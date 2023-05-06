/* GLOBAL */
var appt_inc = 0;			//!simulation

var date_display = {			//generic
	month: null,
	day: null,
	date: null,
}

var last_pfp_id = 0;			//showprofile

const lastform = 2;			//bookform
var formnum = 0;

var appts_data = [];			//DB
var appt_data = {
	id: null,
	id_client: null,
	id_doctor: null,
	date: null,
	time: null,
	appt_date: null,
	appt_time: null,
	motif: "Motif Inconnus."
}

var resultlist = ["£00000", "£00001", "£00002", "£00003", "£00004"];			//updateresultlist

var apptlist = [];			//updateapptlist

var appthistory = [];			//updateappthistory
var appthistory_state = [];

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
			updateapptlist(2);
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
	const MONTHS = ["Janvier", "Fevrier", "Mars", "Avril", "Mai", "Juin", "Juillet", "Aout", "Septembre", "Octobre", "Novembre", "Decembre"];
	const DAYS = ["Dim", "Lun", "Mar", "Mer", "Jeu", "Ven", "Sam"];
	var datetime_in = document.getElementById("datetime_in").value;
	var _datetime_in = new Date(datetime_in);
	var _date = new Date();
	appt_data.id = "0";
	appt_data.id_client = "0";
	appt_data.id_doctor = sessionStorage.getItem('last_profile_id');
	appt_data.date = _date.getDate() + '-' + _date.getMonth() + '-' +_date.getFullYear();
	appt_data.time = _date.getHours() + ':' + _date.getMinutes();
	appt_data.appt_date = _datetime_in.getDate() + '-' + _datetime_in.getMonth() + '-' +_datetime_in.getFullYear();
	appt_data.appt_time = _datetime_in.getHours() +  ':' + _datetime_in.getMinutes();
	let bfb_textarea = document.getElementsByClassName("bfb_textarea")[0];
	if (bfb_textarea.value != "") appt_data.motif = document.getElementsByClassName("bfb_textarea")[0].value;

	date_display.day = DAYS[_datetime_in.getDay()];
	date_display.date = _datetime_in.getDate();
	date_display.month = MONTHS[_datetime_in.getMonth()];

	document.getElementsByClassName("bookform_result")[0].innerHTML = "RDV pour le " + date_display.day + " " 
	+ date_display.date + " " + date_display.month + " a " + appt_data.appt_time + "\nMotif: " + appt_data.motif;
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
	if (sessionStorage.getItem('apptlist') !== null) apptlist = JSON.parse(sessionStorage.getItem('apptlist'));
	if (sessionStorage.getItem('appts_data') !== null) appts_data = JSON.parse(sessionStorage.getItem('appts_data'));
	if (op == 0)
	{
		var apptlist_null = document.getElementsByClassName("apptlist_null")[0];
		if (apptlist.length != 0)
		{
			apptlist_null.innerHTML = "";
			for (i=0; i<apptlist.length; i++)
			{
				fetch(`components/apptlist.php?appt_id=${apptlist[i]}`)
  				.then(response => response.text())
  				.then(data => {
 					apptlist_null.innerHTML += data;
  				});
			}
		}
		else
		{
			apptlist_null.innerHTML = "Pas de rendez-vous en cours !";
		}
	}
	else if (op == 1)
	{
		for (i=0; i<apptlist.length; i++)
		{
			if (apptlist[i] == el.id)
			{
				apptlist.splice(i, 1);
			}
			if (appts_data[i] == el.id)
			{
				appts_data.splice(i, 1);
			}
		}
		sessionStorage.setItem('apptlist', JSON.stringify(apptlist));
		sessionStorage.setItem('appts_data', JSON.stringify(apptlist));
		updateapptlist(0);
		updateappthistory(2, el.id, 'RDV Annulé');
	}
	else
	{
		appt_data.id = "£" + appt_inc++;
		sessionstorage(apptlist, 'apptlist', appt_data.id);
		sessionstorage(appts_data, 'appts_data', appt_data);
	}
}
function updateappthistory(op, id, state)
{
	if (sessionStorage.getItem('appthistory') !== null) appthistory = JSON.parse(sessionStorage.getItem('appthistory'));
	if (sessionStorage.getItem('appthistory_state') !== null) appthistory_state = JSON.parse(sessionStorage.getItem('appthistory_state'));
	if (op == 0)
	{
		var appthistory_null = document.getElementsByClassName("appthistory_null")[0];
		var brief_state = document.getElementsByClassName("brief_state")[0];	
		if (appthistory.length != 0)
		{
			appthistory_null.innerHTML = "";
			for (i=0; i<appthistory.length; i++)
			{
				fetch(`components/appthistory.php?appt_id=${appthistory[i]}&state=${appthistory_state[i]}`)
  				.then(response => response.text())
  				.then(data => {
 					appthistory_null.innerHTML += data;
  				});
			}
		}
		else
		{
			appthistory_null.innerHTML = "Vous n'avez pris aucun rendez-vous";
		}
	}
	else
	{
		sessionstorage(appthistory, 'appthistory', id);
		sessionstorage(appthistory_state, 'appthistory_state', state);
		updateappthistory(0);
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