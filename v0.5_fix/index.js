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
temp_id = 0;
formnum = 0;
aptlist = [];
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
		temp_id = el;
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
				if (sessionStorage.getItem('aptlist') !== null) aptlist = sessionStorage.getItem('aptlist');
				aptlist.push(temp_id.parentElement.parentElement.getElementsByClassName("pfp")[0].id);
				sessionStorage.setItem('aptlist', aptlist);
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
		list_null = document.getElementsByClassName("list_null")[0];
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
if (sessionStorage.getItem('aptlist') !== null) aptlist = sessionStorage.getItem('aptlist');
function updateaptlist()
{
	if (aptlist.length != 0)
	{
		list_null = document.getElementsByClassName("list_null")[0];
		list_null.innerHTML = "";
		for (i=0; i<aptlist.length; i++)
		{
			fetch(`components/aptlist.php?id=${aptlist[i]}`)
  			.then(response => response.text())
  			.then(data => {
 				list_null.innerHTML += data;
  			});
		}
	}
}

//funtion for the size of texts area
function sizeArea(){
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
}

