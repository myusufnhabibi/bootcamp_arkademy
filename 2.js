function is_name_valid(name) {
	var regex = /[A-Z]{3}/g;
	if(name.match(regex)) {
		return true;
	} else {
		return false;
	}
} 

function is_age_valid(age) {
	var regex = /[0-9]{2}/g;
	if(age.match(regex)) {
		return true;
	} else {
		return false;
	}
}

function is_username_valid(username) {
	var regex = /[a-z]{4}[._][0-9]{3}/g;
	if(username.match(regex)) {
		return true;
	} else {
		return false;
	}
}