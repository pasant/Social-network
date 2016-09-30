//FriendZonia main.js
function send_post()
{
	var hr = new XMLHttpRequest();
	var url = "send_post.php";
	var fn = document.getElementById("post").value;
	var vars = "post="+fn;
	hr.open("POST",url,true);
	hr.setRequestHeader("Content-type","application/x-www-form-urlencoded");
	hr.onreadystatechange = function()
	{
		if( hr.readyState == 4 && hr.status ==200)
		{
			var return_data = hr.responseText;
			document.getElementById("status").innerHTML = return_data;
		}
	}
	hr.send(vars);
	document.getElementById("status").innerHTML = "processing ...";
}