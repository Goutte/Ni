function aPeopleConstructor()
{
	this.indexSuccess = function(options) {

	  $('a.person-expand-toggle').click(function() {

	    var toggle = $(this);
	    var url = toggle.attr('href');
	    var person = toggle.closest('.person');
	    var personInfo = person.find('div.person-info');
	    var bodyExpanded = person.find('div.person-info-expanded');
			var spinner = $('<span class="a-spinner a-align-right"></span>');

			toggle.toggleClass('open');

	    if (bodyExpanded.hasClass('expanded'))
	    {
	    	// If this person's info was already ajax'd in,
				// bodyExpanded has the class .expanded
				// So we can just toggle it open and closed
				// Avoiding unnecessary Ajax requests for the same data over and over again ))<>((
	      bodyExpanded.toggle();
	      personInfo.toggle();
	    }
	    else
	    {
	      $.ajax({
	        type: 'post',
	        url: url,
					beforeSend: function() {
						// before we do it, show a spinner
						toggle.append(spinner);
					},
	        success: function(data) {
						// ok it's done, ditch that spinner
						toggle.find('.a-spinner').remove();
	          personInfo.hide();
	          bodyExpanded.html(data);
	          bodyExpanded.addClass('expanded');
	          bodyExpanded.show();
	        },
	        dataType: 'html'
	      });
	    }
	  });
	};
}

window.aPeople = new aPeopleConstructor();