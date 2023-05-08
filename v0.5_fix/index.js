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