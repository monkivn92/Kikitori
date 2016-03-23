$(document).ready(function() {

	var mc = $('div#main-content');//$('#factory');//
	var ctrl_trai = $('div.control-trai');
	var ctrl_phai = $('div.control-phai');
	var ctrl_len = $('div.control-len');
	var ctrl_xuong = $('div.control-xuong');
	var addline = $('div#line-control');
	var addimage = $('div#image-control');
	var close = $('div#close-control');
	var save = $('div#save-control');
	var color = $('div.color-control');
	var done = $('div.done-control');
	var cur_image = 1;

	
		
	function makedraggable() {		
    	$( 'div#main-content p[class ^= "speech"]' ).draggable();
    	$('.line').draggable();
    	$('img').draggable();    	
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
  	function maincontrolline() {

  		$('img').click(function() {
			$(this).toggleClass('kkselected');	
			maincontrolspeech($(this));
		});
	};

  	function done(obj){
  		done.click(function() {
  			$(obj).removeClass('kkselected');
  		});
  	}
  	
	save.click(function() {

			saveTextarea();
			$('.kkselected').removeClass('kkselected');
			
		    var textToWrite = '<html>' + $('html').html() + '</html>';
		    var textFileAsBlob = new Blob([textToWrite], {type:'text/html'});
		    var fileNameToSaveAs = "saved.html";
		    var downloadLink = document.createElement("a");
		    downloadLink.download = fileNameToSaveAs;
		    downloadLink.innerHTML = "Download File";
		    if (window.URL != null)
		    {
		        // Chrome allows the link to be clicked
		        // without actually adding it to the DOM.
		        downloadLink.href = window.URL.createObjectURL(textFileAsBlob);
		    }
		    else
		    {
		        // Firefox requires the link to be added to the DOM
		        // before it can be clicked.
		        downloadLink.href = window.URL.createObjectURL(textFileAsBlob);
		        downloadLink.onclick = destroyClickedElement;
		        downloadLink.style.display = "none";
		        document.body.appendChild(downloadLink);
		    }

		    downloadLink.click();
	});
  
  	
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

	addimage.click(function() {
		cur_image++;	
	  	mc.append(' <image src="image/'+cur_image+'.png" id="'+cur_image+'"/>');
		makedraggable();	
		maincontrolline();		
	});
	
	$( 'div#main-content' ).click(function(){

		$( 'div#main-content p[class ^= "speech"]' ).click(function(){
			$(this).toggleClass('kkselected');
			maincontrolspeech($(this));
		});
		
	});

	function saveTextarea(){
		var ta = $('textarea');
		var ta_length = ta.length;
		for(var i=0; i<ta_length; i++)
		{
			var obj = ta.eq(i);
			var val = obj.val();
			obj.html(val);
		}
	}

	$(window).bind("beforeunload", function() { 
    return confirm("Do you really want to close?"); 
	});
	
});