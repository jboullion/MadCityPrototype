/**
 * Set a Cookie
 * @param string cname  Cookie Name
 * @param mixed cvalue  Cookie Value
 * @param int exdays How many days before expire
 */
function jbSetCookie(cname, cvalue, exdays) {
	var d = new Date();
	d.setTime(d.getTime() + (exdays*24*60*60*1000));
	var expires = "expires="+ d.toUTCString();
	document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}

/**
 * Get a cookie
 * @param  string cname  Cookie Name
 * @return string        Cookie Value
 */
function jbGetCookie(cname) {
	var name = cname + "=";
	var ca = document.cookie.split(';');
	for(var i = 0; i <ca.length; i++) {
		var c = ca[i];
		while (c.charAt(0)==' ') {
			c = c.substring(1);
		}
		if (c.indexOf(name) == 0) {
			return c.substring(name.length,c.length);
		}
	}
	return "";
}

/**
 * Delete a Cookie
 * @param string cname  Cookie Name
 */
function jbDeleteCookie(cname) {
	jbSetCookie(cname, '', -1);
}

/**
 * Replace variables in a string / template
 * 
 * @param string  tpl     This should be a string containing <%name%> variables that will be replaced by JS.
 * @param json    data    This is the data object
 * 
 * @return string         The updated string with the variables replaced
 * 
 * @usage
 * var newString = JBTemplateEngine(stringTpl, {
                    dataID: 1,
                    name: James
                })
 */
function JBTemplateEngine(tpl, data) {
	for(var key in data){
		var re = new RegExp("<%" + key + "%>", "gi");
		tpl = tpl.replace(re, data[key]);
	}
	return tpl;
}

/**
 * Clean all non numeric characters. Also keeping "."
 * usage: str.jbCleanNumber()
 */
String.prototype.jbCleanNumber = function() {
	var returnValue = this.replace(/[^0-9.-]/g,'');

	//let's make sure we do not return a NaN value
	if(isNaN(returnValue) || returnValue == ""){
		returnValue = 0;
	}

	return returnValue;
}


/**
 * Capitalize the first letter of a string
 * usage: str.capitalize()
 */
String.prototype.capitalize = function() {
	return this.charAt(0).toUpperCase() + this.slice(1);
}


/**
 * Create a default string function to allow replacing all characters in a string
 * 
 * @param string search What are we trying to replace
 * @param string replacement Replace it with what?
 */
String.prototype.replaceAll = function(search, replacement) {
	return this.replace(new RegExp(search, 'g'), replacement);
};

/**
 * Replace all non standard characters with a space
 * 
 * @param string this we are targeting itself
 */
String.prototype.sanitize = function() {
	return this.replaceAll('/[^a-zA-Z0-9]/', ' ');
};


/**
 * Use a number to get a random value bewteen that number and 0
 * usage: Number.random();
 */
Number.prototype.random = function(){
	var min = 1;
	var max = Math.floor(this);
	return Math.floor(Math.random() * (max - min + 1)) + min;
};

/**
 * Format a float as currency
 * usage: floatvalue.jbFormatMoney(0, '.', ',');
 */
Number.prototype.jbFormatMoney = function(c, d, t){
	var n = this, 
		c = isNaN(c = Math.abs(c)) ? 2 : c, 
		d = d == undefined ? "." : d, 
		t = t == undefined ? "," : t, 
		s = n < 0 ? "-" : "", 
		i = parseInt(n = Math.abs(+n || 0).toFixed(c)) + "", 
		j = (j = i.length) > 3 ? j % 3 : 0;

	return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
};

/**
 * Round a number to X decimals
 * @param  int 		decimals  	The number of decimals to round to
 * @return Number           	the resulting rounded number
 */
Number.prototype.round = function(decimals){
	var multiplier = Math.pow(10, decimals || 0);
	return Math.round(this * multiplier) / multiplier;
}

/**
 * Take a form and convert it into a Object for easy manipulation
 * 
 * @link https://stackoverflow.com/a/23315254
 * @link http://jsfiddle.net/akhildave/sxGtM/5002/
 */
$.fn.serializeObject = function() {
	var o = {};
	var a = this.serializeArray();
	$.each(a, function() {
		if (o[this.name] !== undefined) {
			if (!o[this.name].push) {
				o[this.name] = [o[this.name]];
			}
			o[this.name].push(this.value || '');
		} else {
			o[this.name] = this.value || '';
		}
	});
	return o;
};


/**
 * Reset a form element after the close animation completes
 * @param element $formElement The jQuery form element
 */
function resetForm($formElement){
	$formElement.find('.action-close').first().trigger('click');

	setTimeout(function(){
		$formElement.trigger("reset");
	}, ANIMATION_DURATION);
}

/**
 * 
 */
function confirmDelete($message){
	return confirm($message);
}