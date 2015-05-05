var tlvp_pages_count = 5;
var tlvp_title = "You came from:";
var tlvp_expiredays = 30;

function start_the_last_visited_pages(){
    if(navigator.cookieEnabled){
        tlvp_the_last_visited_pages();
    }else{
        alert("Please enable the cookie!");
    }
}

function getCookie(name){
    if(document.cookie.length>0){
      start = document.cookie.indexOf(name+"=");
      if(start!=-1){
        start = start+name.length+1;
        end = document.cookie.indexOf(";",start);
        if(end==-1){
            end = document.cookie.length;
        }

        return unescape(document.cookie.substring(start,end));
        }
      }
    return "";
}

function setCookie(name,value,expiredays){
    var exdate = new Date();
    exdate.setDate(exdate.getDate()+expiredays);
    document.cookie = name+"="+escape(value)+((expiredays==null)?"":";expires="+exdate.toGMTString());
}

function tlvp_the_last_visited_pages(){
    tlvp_div = document.getElementById("the_last_visited_pages");

    if(tlvp_pages_count>0){
        for(var i=tlvp_pages_count; i>=0; i--){
            if(i>0){
                setCookie("tlvp_visited_page"+i+"_link",getCookie("tlvp_visited_page"+(i-1)+"_link"),tlvp_expiredays);
                setCookie("tlvp_visited_page"+i+"_title",getCookie("tlvp_visited_page"+(i-1)+"_title"),tlvp_expiredays);
            }else{
                setCookie("tlvp_visited_page"+i+"_link",document.URL,tlvp_expiredays);
                setCookie("tlvp_visited_page"+i+"_title",document.title,tlvp_expiredays);
            }
        }
    }

    tlvp_last_visited_pages_title = document.createElement("div");
    tlvp_last_visited_pages_title.className = "tlvp_title";
    tlvp_last_visited_pages_title_text = document.createTextNode(tlvp_title);
    tlvp_last_visited_pages_title.appendChild(tlvp_last_visited_pages_title_text);
    tlvp_div.appendChild(tlvp_last_visited_pages_title);

    tlvp_last_visited_pages_content = document.createElement("div");
    tlvp_last_visited_pages_content.className = "tlvp_content";

    for(var i=1; i<=tlvp_pages_count; i++){
        tlvp_visited_page_line = document.createElement("p");
        tlvp_visited_page_a = document.createElement("a");
        tlvp_visited_page_a.href = getCookie("tlvp_visited_page"+i+"_link");
        tlvp_visited_page_text = document.createTextNode(getCookie("tlvp_visited_page"+i+"_title"));
        tlvp_visited_page_a.appendChild(tlvp_visited_page_text);
        tlvp_visited_page_line.appendChild(tlvp_visited_page_a);

        tlvp_last_visited_pages_content.appendChild(tlvp_visited_page_line);
    }

    tlvp_div.appendChild(tlvp_last_visited_pages_content);
}