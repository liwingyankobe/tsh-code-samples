function readCookie(name) {
	var nameEQ = name + "=";
	var ca = document.cookie.split(';');
	for(var i=0;i < ca.length;i++) {
		var c = ca[i];
		while (c.charAt(0)==' ') c = c.substring(1,c.length);
		if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
	}
	return null;
}

function display(msg) {
	document.getElementById('msg').innerHTML = msg;
}

function solved(num) {
	if (num == -1) {
		display('Not found');
	} else if (num == 0) {
		display('Unsolved');
	} else if (num == 1) {
		display('Solved');
	}
}

function hint(num) {
	var hints = [
		'U2FsdGVkX19Okp0v2l6oXtsGaTt1MsnSD/w+yzNW8tKlCznCzGMwF',
		'U2FsdGVkX19RiP19UDjLVBkgXd6vmseLFWLCNPQwjcAfI5AKUxgAW',
		'U2FsdGVkX1+ALVtZEj6Pn/JaYTtBZc7n7VEtRoYju/qbkbs7k6k8b'
	];
	var hint = CryptoJS.AES.decrypt(hints[num], '????').toString(CryptoJS.enc.Utf8);
	display(hint[cursors[num]]);
	cursors[num] = (cursors[num] + 1) % hint.length;
}

let cookie = readCookie('finale');
let progress1 = cookie.substr(5, 5);
let progress2 = cookie.substr(10, 4);
let progress3 = cookie.substr(14, 3);
var cursors = [0,0,0];
if (progress1 == '11111'){
	pass.addEventListener('keydown', function(e){
		if(e.keyCode ==13){e.preventDefault();}
	});
} else {
	if (progress1 == '22222'){
		document.getElementById("activate").addEventListener("click", clicked);
	}
	let list1 = ['11','12','13','14','15','16','17','18'];
	let list2 = ['21','22','23','24','25','26','27','28'];
	let status1 = [1,1,1,1,1,1,1,1];
	let status2 = [-1,-1,-1,-1,-1,-1,-1,-1];		
	if (progress1 == '33333'){
		status1 = [0,1,0,0,1,1,0,1];
		status2 = [0,1,0,1,0,1,1,0];
		if (parseInt(progress2[0]) > 0){
			status1[0] = 1;
			status2[1] = 1;
		}
		if (parseInt(progress2[1]) > 0){
			status1[2] = 1;
			status2[3] = 1;
		}
		if (parseInt(progress2[2]) > 0){
			status1[4] = 1;
			status2[5] = 1;
		}
		if (parseInt(progress2[3]) > 0){
			status1[6] = 1;
			status2[7] = 1;
		}
	}
	for (let i = 0; i < 8; i++){
		document.getElementById(list1[i]).addEventListener('mouseover', function(){solved(status1[i]);});
		document.getElementById(list2[i]).addEventListener('mouseover', function(){solved(status2[i]);});
		document.getElementById(list1[i]).addEventListener('mouseleave', function(){display('');});
		document.getElementById(list2[i]).addEventListener('mouseleave', function(){display('');});
	}
	if (progress3[0] == '0'){
		document.getElementById('blue').addEventListener('mouseover', function(){hint(0);});
	} else {
		document.getElementById('blue').addEventListener('mouseover', function(){solved(-1);});
	}
	if (progress3[1] == '1'){
		document.getElementById('green').addEventListener('mouseover', function(){hint(1);});
	} else {
		document.getElementById('green').addEventListener('mouseover', function(){solved(-1);});
	}
	if (progress3[2] == '2'){
		document.getElementById('red').addEventListener('mouseover', function(){hint(2);});
	} else {
		document.getElementById('red').addEventListener('mouseover', function(){solved(-1);});
	}
	document.getElementById('blue').addEventListener('mouseleave', function(){display('');});
	document.getElementById('green').addEventListener('mouseleave', function(){display('');});
	document.getElementById('red').addEventListener('mouseleave', function(){display('');});
}

function clicked(){
	var f = document.createElement('form');
	f.action = 'klmno.php';
	f.method = 'POST';
	var i = document.createElement('input');
	i.type = 'hidden';
	i.name = 'activate';
	i.value = '0';
	f.appendChild(i);
	document.body.appendChild(f);
	f.submit();
}