/* APTLIST & RESULTLIST */
list_el_id_active = 0;
list_els = document.getElementsByClassName("list_el");
for (i = 0; i < list_els.length; i++)
{
	let list_el = list_els[i];
	list_el.addEventListener("click", 
		function(event)
		{
			if ((event.target.tagName != 'P') && (event.target.tagName != 'A'))
			{
				if ((list_el.getElementsByClassName("pfp")[0].id + '_' == list_el_id_active) && (document.getElementsByClassName("secondary")[0].style.display == "flex"))
				{
					document.getElementsByClassName("secondary")[0].style.display = "none";
				}
				else
				{
					document.getElementsByClassName("secondary")[0].style.display = "flex";
					list_el_id_active = list_el.getElementsByClassName("pfp")[0].id + '_';
				}
				console.log(list_el_id_active);
			}
		}
	);
}

/* BOOKFORM */
const lastform = 2;
formnum = 0;
aptlist = [];
apthistory = [];
apthistory_state = [];
description = "Motif inconnu.";
datetime = {
	month_name: "0",
	day_name: "0",
	day_num: 0,
	time: "0",
}
function bookform(op, el)
{
	bfc = document.getElementsByClassName("bookform_container")[0];
	bf = document.getElementsByClassName("bookform_container")[0].children;
	if (op == 0)
	{
		bfc.classList.remove("hidden");
		sessionStorage.setItem('current_el_id', el.id);
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
		}
		savebookformstate()
	}
}
function resetbookform()
{
	bf = document.getElementsByClassName("bookform_container")[0].children;
	bf[formnum].classList.add("hidden");
	formnum = 0;
	bf[formnum].classList.remove("hidden");
}
function savebookformstate()
{
	bfb_textarea = document.getElementsByClassName("bfb_textarea")[0];
	setdatetime()
	if (bfb_textarea.value != "")
	{
		description = document.getElementsByClassName("bfb_textarea")[0].value;
	}
	document.getElementsByClassName("bookform_result")[0].innerHTML = "RDV pour le " + datetime.day_name + " " + datetime.day_num + " " + datetime.month_name + " a " + datetime.time + "\nMotif: " + description;
}
function setdatetime()
{
	const MONTHS = ["Janvier", "Fevrier", "Mars", "Avril", "Mai", "Juin", "Juillet", "Aout", "Septembre", "Octobre", "Novembre", "Decembre"];
	const DAYS = ["Dim", "Lun", "Mar", "Mer", "Jeu", "Ven", "Sam"];
	datetime_in = document.getElementById("datetime_in").value;
	datetime_in_obj = new Date(datetime_in);
	datetime.month_name = MONTHS[datetime_in_obj.getMonth()];
	datetime.day_name = DAYS[datetime_in_obj.getDay()];
	datetime.day_num = datetime_in_obj.getDate();
	datetime.time = datetime_in_obj.getHours() +  ':' + datetime_in_obj.getMinutes();
}

/* RESULTLIST */
resultlist = ["£00000", "£00001", "£00002", "£00003", "£00004"];
function updateresultlist()
{
	if (resultlist.length != 0)
	{
		list_null = document.getElementsByClassName("resultlist_null")[0];
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
		aptlist_null = document.getElementsByClassName("aptlist_null")[0];
		if (aptlist.length != 0)
		{
			aptlist_null.innerHTML = "";
			for (i=0; i<aptlist.length; i++)
			{
				fetch(`components/aptlist.php?id=${aptlist[i]}`)
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
		aptlist.push(sessionStorage.getItem('current_el_id'));
		sessionStorage.setItem('aptlist', JSON.stringify(aptlist));
	}
}
function updateapthistory(op, id, state)
{
	if (sessionStorage.getItem('apthistory') !== null) apthistory = JSON.parse(sessionStorage.getItem('apthistory'));
	if (sessionStorage.getItem('apthistory_state') !== null) apthistory_state = JSON.parse(sessionStorage.getItem('apthistory_state'));
	if (op == 0)
	{
		apthistory_null = document.getElementsByClassName("apthistory_null")[0];
		brief_state = document.getElementsByClassName("brief_state")[0];	
		if (apthistory.length != 0)
		{
			apthistory_null.innerHTML = "";
			for (i=0; i<apthistory.length; i++)
			{
				fetch(`components/apthistory.php?id=${apthistory[i]}&state=${apthistory_state[i]}`)
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
//pour ajouter un chaux de saisi avec le bouton
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
