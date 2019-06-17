var windw = this;

$.fn.followWhen = function ( pos ) {
    var $this = this,
        $window = $(windw);

    $window.scroll(function(e){
    	// console.log($window.scrollTop());
        if ($window.scrollTop() >= pos) {
        	// console.log(">>" + $window.scrollTop());
            $this.css({
                position: 'fixed',
                top: 0,
                right: '43px',
                width: '236px',
                'z-index': 5
            });
        } else {
            $this.css({
                position: 'relative',
                width: '25%',
                right: 0
                //,
                // top: 0
            });
        }
    });
};