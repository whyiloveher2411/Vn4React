$('.left_col:eq(0)').attr('id','step1').attr('data-step',1).attr('data-intro','Main Navigation');
$('#vn4-nav-top-login').attr('data-step',2).attr('data-intro','Toolbar');
$('.right_col').attr('id','step2').attr('data-step',3).attr('data-intro','Work Area');

$('.helper-link ul').prepend('<li><a href="javascript:void(0)" onclick="startIntro(event);"><label>User Guide</label></a></li>');


window.startIntro = function(event){

	event.stopPropagation();

	 let driver = new Driver();
	// Define the steps for introduction
	driver.defineSteps([
	  {
	    element: '#step1',
	    popover: {
	      title: 'Main Navigation',
	      description: 'menu details each of the administrative functions you can perform. At the bottom of that section is a Collapse menu button that shrinks the menu into a set of icons, or to expands to list them by major function. Within each major function, such as Posts, the sub-menu expands when clicked',
	      position: 'right-center'
	    }
	  },
	   
	  {
	    element: '#vn4-nav-top-login',
	    popover: {
	      title: 'Toolbar',
	      description: 'has links to various administration functions, and is displayed at the top of each Administration Screen. Many Toolbar items expand (flyout) when hovered over to display more information.',
	      position: 'bottom-center'
	    }
	  },
	  {
	    element: '#step2',
	    popover: {
	      title: 'Work Area',
	      description: 'In the <strong>work area</strong>, the specific information relating to a particular navigation choice, such as adding a new post, is presented and collected.',
	      position: 'mid-center'
	    }
	  },
	  {
	    element: '#newfeed',
	    popover: {
	      title: 'New Feed',
	      description: 'New Feed',
	      position: 'bottom-center'
	    }
	  },
	]);

	// Start the introduction
	driver.start();
}