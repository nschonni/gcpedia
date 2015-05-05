var GCPEDIA_usernameExp = new RegExp("^[a-z]{1,50}[.]{1}[a-z]{1,50}$","m");
var GCPEDIA_emailExp = new RegExp("^[a-z|A-Z|0-9|\_|\.|@|-]{1,100}gc\.ca$","m");
var GCPEDIA_realNameExp = new RegExp("^[a-z|A-Z| ]{1,100}$","m");

var GCPEDIA_passwordExp1 = new RegExp("[a-z]{1,}");
var GCPEDIA_passwordExp2 = new RegExp("[A-Z]{1,}");
var GCPEDIA_passwordExp3 = new RegExp("[0-9]{1,}");
var GCPEDIA_passwordExp4 = new RegExp("[.|?|@]{1,}");
var GCPEDIA_passwordExp5 = new RegExp("[^a-zA-Z0-9.?@]{1,}");


var GCPEDIA_username;
var GCPEDIA_password;
var GCPEDIA_pwdRetype;
var GCPEDIA_email;
var GCPEDIA_realName;
var GCPEDIA_submitBttn;
var GCPEDIA_msg;
var GCPEDIA_beforeInfo;


var GCPEDIA_username_errorEn = "invalid username, must be in the format \'givenname.lastname\' (all lower case)";
var GCPEDIA_password_errorEn = "password cannot be blank";
var GCPEDIA_passwordRetypeEn = "passwords do not match"
var GCPEDIA_passwordCharErrorEn = "password must contain atleast 1 lower case letter, 1 upcase letter, 1 special character, and 1 digit";
var GCPEDIA_passwordLengthErrorEn = "password must be atleast 6 character long and no longer than 12";
var GCPEDIA_email_errorEn = "email must end with gc.ca";
var GCPEDIA_realName_errorEn = "real name cannot be left blank";

var GCPEDIA_username_errorFr = "un &#60;&#60; nom d&#39;usager non valide &#62;&#62; doit &#234;tre indiqu&#233; en format pr&#233;nom/nom de famille &#62;&#62; (tout le bas de casse)";
var GCPEDIA_password_errorFr = "un champ de&#60;&#60; mot de passe &#62;&#62; ne peut &#234;tre laiss&#233; en blanc";
var GCPEDIA_passwordRetype_errorFr = "les &#60;&#60; mots de passe&#62;&#62; ne correspondent pas";
var GCPEDIA_passwordCharErrorFr = "le mot de passe doit contenir atleast 1 lettre de bas de casse, 1 lettre upcase, 1 caract&#232;re sp&#233;cial et 1 chiffre";
var GCPEDIA_passwordLengthErrorFr = "le mot de passe doit &#234;tre atleast 6 caract&#232;re longtemps et plus que 12";
var GCPEDIA_email_errorFr = "l&#39;adresse courriel doit se terminer par gc.ca";
var GCPEDIA_realName_errorFr = "le nom r&#233;el doit &#234;tre indiqu&#233;";

var GCPEDIA_username_error;
var GCPEDIA_password_error;
var GCPEDIA_passwordRetype_error;
var GCPEDIA_passwordCharError;
var GCPEDIA_passwordLengthError;
var GCPEDIA_email_error;
var GCPEDIA_realName_error;

var firstname;
var lastname;

var focus;

function initalizeVariables()
{
	focus = 0;
	
	GCPEDIA_username = document.getElementById("wpName2");
	GCPEDIA_password = document.getElementById("wpPassword2");
	GCPEDIA_pwdRetype = document.getElementById("wpRetype");
	GCPEDIA_email = document.getElementById("wpEmail");
	GCPEDIA_realName = document.getElementById("wpRealName");
	GCPEDIA_submitBttn = document.getElementById("wpCreateaccount");
	GCPEDIA_msg = document.getElementById("errorList");
	
	GCPEDIA_beforeInfo = document.getElementById("beforeInfo");
	
	GCPEDIA_username.attachEvent('onkeyup',GCPEDIA_chkInput);
	GCPEDIA_password.attachEvent('onkeyup',GCPEDIA_chkInput);
	GCPEDIA_pwdRetype.attachEvent('onkeyup',GCPEDIA_chkInput);
	GCPEDIA_email.attachEvent('onkeyup',GCPEDIA_chkInput);
	GCPEDIA_email.attachEvent('onfocus',function(){focus=1;});
	GCPEDIA_email.attachEvent('onblur',function(){focus=0;});
	//GCPEDIA_realName.attachEvent('onkeyup',GCPEDIA_chkInput);
	
	GCPEDIA_email.focus();
	
	if (lang=="fr")
	{
		GCPEDIA_username_error = GCPEDIA_username_errorFr;
		GCPEDIA_password_error = GCPEDIA_password_errorFr;
		GCPEDIA_passwordRetype_error = GCPEDIA_passwordRetype_errorFr;
		GCPEDIA_passwordCharError = GCPEDIA_passwordCharErrorFr;
		GCPEDIA_passwordLengthError = GCPEDIA_passwordLengthErrorFr;
		GCPEDIA_email_error = GCPEDIA_email_errorFr;
		GCPEDIA_realName_error = GCPEDIA_realName_errorFr;
	}
	else
	{
		GCPEDIA_username_error = GCPEDIA_username_errorEn;
		GCPEDIA_password_error = GCPEDIA_password_errorEn;
		GCPEDIA_passwordRetype_error = GCPEDIA_passwordRetypeEn;
		GCPEDIA_passwordCharError = GCPEDIA_passwordCharErrorEn;
		GCPEDIA_passwordLengthError = GCPEDIA_passwordLengthErrorEn;
		GCPEDIA_email_error = GCPEDIA_email_errorEn;
		GCPEDIA_realName_error = GCPEDIA_realName_errorEn;
	}
}

function GCPEDIA_chkInput()
{
	if (GCPEDIA_chkValues()) GCPEDIA_submitBttn.disabled = false;
	else GCPEDIA_submitBttn.disabled = true;
}

function GCPEDIA_chkValues()
{
	GCPEDIA_msg.innerHTML = "";
	
	//GCPEDIA_username.value = focus;
	if (focus == 1) getName();

	if (!GCPEDIA_emailExp.test(GCPEDIA_email.value)) return GCPEDIA_error(GCPEDIA_email_error);
	if (!GCPEDIA_chkpassword()) return false;
	
	
	if (!GCPEDIA_usernameExp.test(GCPEDIA_username.value)) return GCPEDIA_error(GCPEDIA_username_error);
	//if (!GCPEDIA_realNameExp.test(GCPEDIA_realName.value)) return GCPEDIA_error(GCPEDIA_realName_error);
	
	return true;
}

function GCPEDIA_chkpassword()
{
	if (GCPEDIA_password.value == "") return GCPEDIA_error(GCPEDIA_password_error);
	
	//if (!GCPEDIA_passwordExp1.test(GCPEDIA_password.value)) return GCPEDIA_error(GCPEDIA_passwordCharError);
	//if (!GCPEDIA_passwordExp2.test(GCPEDIA_password.value)) return GCPEDIA_error(GCPEDIA_passwordCharError);
	//if (!GCPEDIA_passwordExp3.test(GCPEDIA_password.value)) return GCPEDIA_error(GCPEDIA_passwordCharError);
	//if (!GCPEDIA_passwordExp4.test(GCPEDIA_password.value)) return GCPEDIA_error(GCPEDIA_passwordCharError);
	//if (GCPEDIA_passwordExp5.test(GCPEDIA_password.value)) return GCPEDIA_error(GCPEDIA_passwordCharError);
	
	//if (GCPEDIA_password.value.length < 6 || GCPEDIA_password.value.length > 12 ) return GCPEDIA_error(GCPEDIA_passwordLengthError);
	
	if (GCPEDIA_password.value != GCPEDIA_pwdRetype.value) return GCPEDIA_error(GCPEDIA_passwordRetype_error);
	
	return true;
}

function GCPEDIA_error(error_msg)
{
	GCPEDIA_msg.innerHTML = "<span id='userLogin_error_msg' style='color: red'>"+error_msg+"</span>";
	return false; 
}

function chkLanguage()
{
	var url = document.location.href;
	var getVarStart = url.indexOf('?',0);
	if (getVarStart==-1) return "en"
	
	var getString = url.substring(getVarStart,url.length);
	var getArray = new Array();
	getArray = getString.split("&");
	
	for ( var i in getArray )
	{
		var langString = "uselang=";
		langStart = getArray[i].indexOf("uselang=")
		if (langStart > -1)
		{
			var value = getArray[i].substr(langStart+langString.length,getArray[i].length);
			return value;
		}
	}
	return "en";
}

function getName()
{
	var email = GCPEDIA_email.value;
	var firstWordEndIndex = email.indexOf('.');
	
	if (firstWordEndIndex > -1)
	{
		firstname = email.substring(0, firstWordEndIndex);
		var restofLine = email.substring(eval(firstWordEndIndex+1), email.length);
		
		var secondWordEndIndex = restofLine.indexOf('@');
		
		if (secondWordEndIndex > -1)
		{
			lastname = restofLine.substring(0, secondWordEndIndex);
			writeUserName();
			writeRealName();
		}
	}
}

function writeRealName()
{
	var fname_firstLetter = firstname.substring(0,1);
	var lname_firstLetter = lastname.substring(0,1);
	
	var new_firstname = fname_firstLetter.toUpperCase() + firstname.substring(1,firstname.length);
	var new_lastname = lname_firstLetter.toUpperCase() + lastname.substring(1,lastname.length);
	
	GCPEDIA_realName.value = new_firstname + " " + new_lastname;
}

function writeUserName()
{
	GCPEDIA_username.value = firstname + "." + lastname;
}

window.onload = initalizeVariables;