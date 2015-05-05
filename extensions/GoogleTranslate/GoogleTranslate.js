/* Hide the translate Extension 
 
*/
 
function trans_hide(obj){ 
        var element = document.getElementById(obj); 
        element.style.display='none'; 
        return true
} 
 
/* Hide the translate Extension 
*/
function translate_text(document){
 
	google.load("language", "1");
 
	var text = wDoc.getElementById("wpTextbox1").value;
	var from_lng = wDoc.getElementById("google_translate_from").value;
	var to_lng = wDoc.getElementById("google_translate_to").value; 
 
	google.language.translate(text, "en", "fr", function(result) {  
  	if (!result.error) {    
    	text.value = result.translation;  
    	return true;  
                  }
         });
 
}
 
 
 
function mwGoogleTranslateButton(){   
	/* Load API  
	var script = document.createElement("script");  
  script.src = "http://www.google.com/jsapi";  
  script.type = "text/javascript";  
  document.getElementsByTagName("head")[0].appendChild(script);  */ 
 
 
 
        var toolbar = document.getElementById("toolbar");
        if(!toolbar){
                return false
        }
        var button = document.createElement("a");
        button.href = "#";
 
        button.onclick = function () {
        ls_ajax_onload();
        return false;
        };
 
        var add_image=document.createElement('img');
        add_image.src="/gcwiki/extensions/GoogleTranslate/Button_translate_en.png";
 
        toolbar.appendChild(button);
        button.appendChild(add_image);
 
        return true
}
 
var ss_memory = null;
 
function GoogleTranslateCall() {
        var newdiv = document.getElementById("GoogleTranslate");
 
        if(!newdiv){
                var newdiv = document.createElement("div");
                newdiv.id = "GoogleTranslate";
                newdiv.style.display='block'
 
                var output = document.getElementById("toolbar");
                output.appendChild(newdiv);
        }
        else{ newdiv.style.display='block'
        } 
        var x = document.getElementById("google_translate_from").value;
 
        if (x == ss_memory) {
        return;
    }
    ss_memory = x;
    if (x.length < 30 && x.length > 2 && x.value != "") {
        sajax_do_call("wfAjaxGoogleTranslate", [x], newdiv);
        }
}
// -----------------------------------------------------------------------
// Next two functions try is used to split text in sentences and linebreaks
// Can be extended to deal with parser things like <code ...> and others! 
 
 
// function returns the next full stopposition  in a string 
function nextStop(text) { 
	 var pos = text.length;
	 var pos2 = text.indexOf(".");
	 if (pos2 > 0 && pos >pos2) { pos = pos2 + 1};                                       // lastPos is the next Sentence stats 
	 var pos2 = text.indexOf("!");
	 if (pos2 > 0 && pos >pos2) { pos = pos2 + 1}; 
	 var pos2 = text.indexOf("?");
	 if (pos2 > 0 && pos >pos2) { pos = pos2 + 1};
 
	 var patt1 = /\x10/; 
	 var pos2 = text.search(patt1);                         
	 if (pos2 > 0 && pos >pos2) { pos = pos2}; 
 
	 var patt1 = /\x13/; 
	 var pos2 = text.search(patt1);                         
	 if (pos2 > 0 && pos >pos2) { pos = pos2}; 
 
	 var patt1 = /\n/; 
	 var pos2 = text.search(patt1);                         
	 if (pos2 > 0 && pos >pos2) { pos = pos2}; 
 
	 if (pos == 0) { pos = text.length };
 
   return pos; 
 
 
}
// If there are more than one . ! ? or "\n" we need to move a bit forward to the next actual string 
// Figure out the next start position, eg after things like .!? and \n 
function nextStart(text) { 
	 var newStart = 1; 
	 var retStart = 0;
	 var pos = -1; // Previous char 
	 var posX = 0; 
	 var aText = text; // work your way through this 
	 while (pos < newStart) {
	 	 pos = newStart; // exit condition 
	 	 posX = aText.indexOf(".");
	 	 if (newStart == posX) {
	 	 	newStart++; };
	 	 posX = aText.indexOf("!");
	 	 if (newStart == posX) {
	 	 	newStart++; };
	 	 posX = aText.indexOf("?");
	 	 if (newStart == posX) {
	 	 	newStart++; };
 
	 	 var patt1 = /\x13/; // are you sure you are not looking for "\r" (#13 decimal, not hex)?
	 	 posX = aText.search(patt1) + 1;
	 	 if (newStart == posX) {
	 	 	newStart++; };
 
	 	 var patt1 = /\x10/; // are you sure you are not looking for "\n" (#10 decimal, not hex)?
	 	 posX = aText.search(patt1) + 1;
	 	 if (newStart == posX) {
	 	 	newStart++; };
 
 
	 	 var patt1 = /\n/;
	 	 // var patt1 = new RegExp("\n");
	 	 posX = aText.search(patt1) + 1;
// document.write("********** funde ved : " + posX);
	 	 // posX = aText.indexOf("\n") + 1;
	 	 if (newStart == posX) {
	 	 	newStart++; };
 
	 	  if (pos < newStart) {
	 	  	retStart += newStart; 
	 	  	pos = newStart - 1;  
	 	  	aText = aText.substring(pos);  // One more round!! 
	      }
	    } 
	   //  retStart--;
	  	return retStart
	}
 
 
 
/* 
    This function builds the translation bar eg. the text 'Translate from/to' etc. 
     - it also attempts to load the API, what a mess
 
    */  
function ls_ajax_onload() {
        // Change to your language specific texts 
        var from_to_text = "Translate from/to: ";                // " Translate from/to: "
        var translate_text = " click here to translate ";   // " click here to translate "       
       var close_text = " ( close translate tool. ) ";     // " ( close translate tool ) "       
 
        var newdiv = document.getElementById("googlelanguage");
        if (!newdiv) {
 
                var newdiv = document.createElement("div");
                newdiv.id = "googlelanguage";
 
                var output = document.getElementById("toolbar");
                output.appendChild(newdiv);
 
                var search = document.createTextNode(from_to_text);
                newdiv.appendChild(search);
 
                var html = document.createElement("input");
                html.id = "google_translate_from";
 
                newdiv.appendChild(html);
 
                var x = document.getElementById( 'google_translate_from' );
                x.value = 'en';
 
                var lng_slash = document.createTextNode(" / ");
                newdiv.appendChild(lng_slash);
 
                var html = document.createElement("input");
                html.id = "google_translate_to";
 
                newdiv.appendChild(html);
 
                var y = document.getElementById( 'google_translate_to' );
                y.value = 'fr';
 
 
                var transl = document.createElement("transl");
                transl.href = "#";
 
                transl.onclick = function () {
                  	google.load("language", "1");
                    var myTranslate=function(el,str,startPos, endPos) {
                          return function(result){
                            if(!result.error) { 
                            	 var strX = "Visit W3Schools.\n Learn JavaScript."; 
                               var patt1 = /\n/;
                               var resultX = strX.search(patt1);
 
                              var x=el.innerHTML;
                              // + "/" +  startPos + "/" + endPos
                              // var myX = x.replace(str,result.translation + "/" +  startPos + "/" + endPos + " (" + resultX + ")\n");
                              var myX = x.replace(str,result.translation);
                              el.innerHTML=myX; 
									                }
										      else {
												var xx = result;    // Just to stop and see 
											  return result; } // or other error processing 
 
											}
  									}; 
             /*     	translate_text(document); */
 
	                  var from_lng = document.getElementById("google_translate_from").value;
	                  var to_lng = document.getElementById("google_translate_to").value; 
 
                    var el = document.getElementById("wpTextbox1");    
	                  var text = document.getElementById("wpTextbox1").innerHTML;
                    // var text = text.replace(/\x10/,/\n/);
	                  // var text = text.replace(/\x13/,/\r/);
	                  // text = textConv(text);
 
                    var mLen = text.length;
                    var tStart = nextStart(text); // In case there are '\n' to start?
                    var tNext = nextStop(text,tStart);
                    var xNext = 0; 
 
                   // The real translation takes off here!	         
	                 while (tNext < text.length) { 
	                    var wText = text.substring(tStart, tNext); 
 
                      google.language.translate(wText, from_lng , to_lng , myTranslate(el,wText,tStart,tNext) );
 
                      tNext = tNext + 1;
                      tStart = tNext; 
                      var tStart = nextStart(text.substring(tNext)) + tStart; 
                      tNext = nextStop(text.substring(tStart)) + tStart;
 
                      if (tNext == -1) { tNext =text.length; } 
 
	                  }; 
	                  return;
                };
 
                newdiv.appendChild(transl);    
 
                var transl_text = document.createTextNode(translate_text);
                transl.appendChild(transl_text);
 
 
                var hide = document.createElement("a");
                hide.href = "#";
 
                hide.onclick = function () {
                        trans_hide('googlelanguage');
                        return false;
                };
 
                newdiv.appendChild(hide);    
 
                var hide_text = document.createTextNode(close_text);
                hide.appendChild(hide_text);
 
 
        }else{
                var x = document.getElementById( 'google_translate_from' );
                var element = document.getElementById('googlelanguage'); 
                element.style.display='';
        } 
 
        x.onkeyup = function(){
                GoogleTranslateCall();
    }
}
 
 
function Insertlink(name) {
        var input = document.getElementById("google_translate_from");
        input.value = '';
 
        trans_hide('googletranslate');
        insertTags('[['+name+']]', '', '');              
} 
 
 
document.onclick=check; 
 
function check(e){ 
        var target = (e && e.target) || (event && event.srcElement); 
        var obj = document.getElementById('googletranslate'); 
        if (obj) {
                var parent = checkParent(target); 
                if(parent){
                        obj.style.display='none';
                } 
        } 
} 
 
function checkParent(t){ 
        while(t.parentNode){ 
                if(t==document.getElementById('googletranslate')){ 
                        return false 
                } 
                t=t.parentNode 
        } 
        return true 
}
