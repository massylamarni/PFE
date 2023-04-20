function loginswitch()
{
	document.getElementsByClassName("navbar_auth")[0].style.display = "none";
	document.getElementsByClassName("navbar_loggedin")[0].style.display = "flex";
}
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