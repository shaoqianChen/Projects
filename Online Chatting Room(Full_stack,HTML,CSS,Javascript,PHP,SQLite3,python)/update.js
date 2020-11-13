let timeout = setTimeout("location.reload(true);",2000);//refresh the chat window every 2 second

window.scrollTo(0,document.querySelector(".scrollingContainer").scrollHeight);//keep scrolling the window to the bottom


// function resetTimeout(){
// 	clearTimeout(timeout);
// 	timeout = setTimeout("location.reload(true);",1000);
// }

//AJAX update

// const period = 1; // 10ms


// let Temperature = { // global object stores	
// 	event_id: null, // timer event id
// 	file: "user.txt", // the file to read from
// 	element_id: "temp", // the id of span element
// 	temp: null // current temperature
// }

// function read_text(data){
// 	let xhttp = new XMLHttpRequest();

// 	xhttp.onreadystatechange = function() {
// 		// ensure process is done and successful before accessing response
// 		if (this.readyState === 4 && this.status === 200) {
// 			data.temp = this.responseText;
// 		}
// 		set_value(data.element_id, data.temp);
// 	};

// 	xhttp.open("GET", data.file, true);
// 	xhttp.send();
// }


// /**
//  Function append the innerHTML of an element

//  @param {string} id the id of the element to set
//  @param {string} the text to add inside the element
//  */
// function set_value(id, value){

// 	document.getElementById(id).innerHTML = value;
	
// 	let div_node = document.getElementsByTagName("div")[0];
// 	let need_to_change = document.getElementById

// 	for(let i=0; i <= 2; i+=1){ // let it range from 100 to 900
// 		let new_p = document.createElement("p");
// 		let label = document.createTextNode(value);

// 		new_p.appendChild(label);
// 		new_p.style.fontWeight = 200;
// 		new_p.style.fontSize = 5 + "em";

// 		let first_child = div_node.firstChild;
// 		if(first_child === null){ // if div has no children
// 			div_node.appendChild(new_p); // add the child
// 		}
// 		else{ // if it has children
// 			div_node.insertAfter(new_p, first_child); // make this new first
// 		}
// 	}
// }


// window.onload = function(){
// 	read_text(Temperature); // read from the file to set the span
// 	// do ajax calls periodically, using Temperature as argument for read_text
// 	Temperature.event_id = setInterval(read_text, period, Temperature);

// }





















