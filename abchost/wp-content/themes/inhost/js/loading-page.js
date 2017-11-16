(function (window){
    "use strict";	
	var div = document.createElement('div');
	div.className = 'page-loading';
	var timeout = '';
	timeout = setInterval(function(){
		if(document.querySelector('body')){
			div.innerHTML += '<div class="page-loading-bg"></div><div class="page-loading-icon"><div class="sk-folding-cube">\
            <div class="sk-cube1 sk-cube"></div>\
            <div class="sk-cube2 sk-cube"></div>\
            <div class="sk-cube4 sk-cube"></div>\
            <div class="sk-cube3 sk-cube"></div>\
        </div></div>';
document.querySelector('body').appendChild(div);
clearInterval(timeout);
		}
	},20);

})(window);
