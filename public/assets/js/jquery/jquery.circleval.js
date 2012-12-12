(function( $ ){

	$.fn.circleval = function( options ) {  

		var settings = $.extend( {
			'topValue'         : '100',
			'outer'			   : '#000000',
			'inner'			   : '#666666',
			'text'			   : '#000000',
			'specialText'	   : '10',
			'speed'			   : 5,
			'increment'		   : 5,
		}, options);

		
		
		var currentLine = 0;

		$thisCanvas = $("<canvas />").prop({ width: $(this).width(), height: $(this).height() });

		var percent = $(this).html();
		
		var topValue = (isNaN($(this).attr('rel'))) ? settings['topValue'] : $(this).attr('rel');
		
		var totalLine = 360*(((percent/settings['specialText'])*100)/topValue);

		$(this).html($thisCanvas);

		var canvas = $thisCanvas[0];

		var context = canvas.getContext("2d");
		var x = canvas.width / 2;
		var y = canvas.height / 2;
		var lineWidth = (x > y) ? (y*2)*0.08 : (x*2)*0.08;
		var radius = (x > y) ? y-lineWidth : x-lineWidth;

		context.clearRect(0, 0, canvas.width, canvas.height);

		var tInverval = setInterval(function() {
			context.clearRect(0, 0, canvas.width, canvas.height);

			addText(percent);

			if (totalLine >= currentLine) {
				createArc(0,currentLine);
				currentLine=currentLine+settings['increment'];
			} else {
				createArc(0,totalLine);
				clearInterval(tInverval);
			}
		}, settings['speed']	)


		
		
		function createArc(start, end)
		{
			context.beginPath();
			context.arc(x, y, radius, (Math.PI / 180) * (start-90), (Math.PI / 180) * (end-90), false);
			context.lineWidth = lineWidth;
			context.strokeStyle = settings['outer'];
			context.stroke();

			context.beginPath();
			context.lineWidth = lineWidth*0.5;
			context.arc(x, y, radius-(lineWidth+(lineWidth/10)), 0, 2 * Math.PI, false);
			context.strokeStyle = settings['inner'];
			context.stroke();
		}
		
		// Private functions
		function addText(text)
		{
			var fontSize = ((24/100)*(radius+lineWidth))*2;
			context.fillStyle = settings['text'];
			context.font = 'bold '+fontSize+'px verdana';
	        context.textAlign = "center";
			context.textBaseline = 'middle';
			context.fillText(settings['specialText'], x, y-(y/5.5));
			
			
			var fontSize = ((24/150)*(radius+lineWidth))*2;
			context.fillStyle = settings['inner'];
			context.font = 'bold '+fontSize+'px verdana';
	        context.textAlign = "center";
			context.textBaseline = 'middle';
			context.fillText(text, x, y+(y/3.3));
		}

	};

})( jQuery );