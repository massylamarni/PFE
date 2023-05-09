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

