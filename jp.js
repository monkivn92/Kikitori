$(document).ready(function() {

	var mc = $('div#main-content');
	var ctrl_trai = $('div.control-trai');
	var ctrl_phai = $('div.control-phai');
	var ctrl_len = $('div.control-len');
	var ctrl_xuong = $('div.control-xuong');
	var addline = $('div#line-control');
	var close = $('div#close-control');
	var save = $('div#save-control');
	var color = $('div.color-control');
	var done = $('div.done-control');
		
	function makedraggable() {
    	$( 'div#main-content p[class ^= "speech"]' ).draggable();
    	$('.line').draggable();
  	};

  	function makeresizeable() {
  		$('.line').resizable({
		    handles: "e,w"
		});
  	}
  	function maincontrolline() {
  		close.click(function() {
  			$('.line.kkselected').remove();
  		});
  		color.click(function() {

  			var att = $(this).attr('id');   					
  			$('.line.kkselected').css('background-color',att);
  		});
  	}
  	function maincontrolspeech(obj) {
  		close.click(function() {
  			obj.remove();
  		});
  		
  	}

  	function done(obj){
  		done.click(function() {
  			$(obj).removeClass('kkselected');
  		});
  	}
  	
	ctrl_trai.click(function() {
	  	
	  	mc.append(' <p class="speech-trai" id="'+Math.floor((Math.random() * 1000) + 1)+'"><textarea></textarea></p>');
		makedraggable()	;			
					
	});

	ctrl_phai.click(function() {
	  	
	  	mc.append(' <p class="speech-phai" id="'+Math.floor((Math.random() * 1000) + 1)+'"><textarea></textarea></p>');
		makedraggable();				
					
	});

	ctrl_len.click(function() {
	  	
	  	mc.append(' <p class="speech-len" id="'+Math.floor((Math.random() * 1000) + 1)+'"><textarea></textarea></p>');
		makedraggable();				
					
	});

	ctrl_xuong.click(function() {
	  
	  	mc.append(' <p class="speech-xuong" id="'+Math.floor((Math.random() * 1000) + 1)+'"><textarea></textarea></p>');
		makedraggable();				
					
	});

	addline.click(function() {
	  	
	  	var id = Math.floor((Math.random() * 1000) + 1);
	  	mc.append(' <div class="line" id="'+id+'"></div>');
		makedraggable();	
		makeresizeable();	
		$('#'+id+'.line').click(function() {					
			$(this).toggleClass('kkselected');							
			maincontrolline();
			done($(this));
		});		
	
				
	});


	$(window).bind("beforeunload", function() { 
    return confirm("Do you really want to close?"); 
	});
	
});