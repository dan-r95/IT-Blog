(function($){
  $(function(){

    $('.button-collapse').sideNav();
    $('.parallax').parallax();
	$(".dropdown-button").dropdown();
  	$("#admin-btn").click(function() {
		a=check()
		console.log(a)
		if(a==true){
			$(".dropdown-button").dropdown('toggle');
		};
	});
	$("#admin-mob-btn").click(function() {
		a=check()
		console.log(a)
		if(a==true){
			$(".dropdown-button").dropdown('toggle');
		};
	});
  }); // end of document ready

})(jQuery); // end of jQuery name space

var check= function(input){
	input = window.prompt("Bitte Passwort eingeben!","");
	// LOL very secure 
	return (input && input == "1234");
}