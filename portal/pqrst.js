var f = document.createElement('form');
for (let i = 1; i <= 5; i++){
	var b = document.createElement('input');
	b.type = 'button';
	b.value = ' ';
	b.style = 'background-color: #111111; border: none';
	b.addEventListener('click', function() {clicked(i);});
	f.appendChild(b);
}
document.getElementById('pqrst').appendChild(f);
var p = document.createElement('p');
document.getElementById('pqrst').appendChild(p);

function clicked(i){
	const data = new FormData();
	data.append('p', i.toString());
	fetch("pqrst.php", {
  		method: 'POST',
  		body: data
	})
	.then(response => response.text())
	.then(msg=>{
		if(msg){
			p.innerHTML = msg;
		}
	})
}