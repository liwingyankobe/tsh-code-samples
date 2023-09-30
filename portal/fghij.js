document.getElementById("door").addEventListener("click", clicked);

if(document.getElementById("scene").src == 'https://thestringharmony.com/xxxxxx/?????.jpg'){
	document.getElementById('glados').addEventListener("ended", opensesame);
	setTimeout(function() {
		document.getElementById('bgm').volume = 0.1;
		document.getElementById('glados').play();
	}, 2000);
}

function opensesame(){
	document.getElementById('bgm').volume = 1;
	document.getElementById("scene").src = '?????.jpg';
	document.getElementById("door").coords = '210,80,430,400';
}

function clicked(){
	var f = document.createElement('form');
	f.action = 'fghij.php';
	f.method = 'POST';
	var i = document.createElement('input');
	i.type = 'hidden';
	i.name = 'traverse';
	i.value = '0';
	f.appendChild(i);
	document.body.appendChild(f);
	f.submit();
}