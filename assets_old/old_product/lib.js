/******************************************************
** lib.js version 1.08 Feb 3, 2003
*******************************************************/

/*prevent getting framed: reload in top window if framed */
/*Temporary solution to maintain compatibility between old and new design */
/*owssvr.dll is specific for users that use MS Sharepoint*/


try{
Result=top.location.href.indexOf("owssvr.dll");
}
catch(errorObj){
Result=0;
}

if((self != top) && (Result!=-1)){
if(document.referrer.indexOf("://")!=-1) refString=document.referrer.substring(document.referrer.indexOf("://")+3,document.referrer.length)
else refString=document.referrer

restString=refString.substring(refString.indexOf("/"),refString.length);

/*When site does not contain a dot or does contain '&InfoBar'(DAP) then go back.*/
if((restString.indexOf(".")==-1) || !(restString.indexOf("&InfoBar=01")==-1)) {
	 history.back(-1);
} else {
   top.location.href=self.location.href;
}
}

/* menu item constructor */
function _Item(text, link, nw) {
   this.text=text;
   this.nw=nw;
    if(link=="") {
	this.link="#";
   } else {
	this.link=link;
   }
}

/* site constructor */
function _Site(text, link) {
   this.link=link;
   this.text=text;
}

/* button constructor */
function _Button(text, img, link,width,target) {
   this.link=link;
   this.img=img;
   this.text=text;
   this.width=width;
   this.target=target;
}

/* page constructor */
function _Page() {
	this.items = new Array()             /* array of menu items  */
	this.sites = new Array()             /* array of sites       */
	this.siteIdentifier = "";            /* the Site Identifier  */
	this.item  = "0";                    /* the current selected menu item, default: home */
	this.hideLeftNavigation = false;     /* parameter to control display of left navigation bar, default: false */
	this.trace = false;		       /* if true a _popup window will appear showing generated code */
	this.traceWindow = "0";
	this.traceVar = '';
	this.commonServer='';
	this.buttons = new Array();
	this.listSM=new Array();	
	this.listNr=0;
	this.ns = (navigator.appName=='Netscape'?1:0);
	if (navigator.userAgent.indexOf('Netscape/7')>-1) {this.ns7='1';}
	this.topItem='border-width:0px 0px 0px 0px;';
	this.nsHand=(this.ns==1?'cursor:pointer;':'');
	this.noLink='cursor:default;';
	this.delay=1000;

/*	this.buttons[2]= new _Button("yellow pages","gn_but_yellowpages.gif","http://pww.yellowpages.philips.com",95)*/
/*	this.buttons[3]= new _Button("telephone","gn_but_telephone.gif","http://pww.philips.com/people/phone.html",83) */
/*	this.buttons[4]= new _Button("search","gn_but_search.gif","http://pww.search.philips.com",62) */

	this.lhimgoff = new Image(17,27);
	this.lhimgon = new Image(17,27);
	this.lhimgoff.src = this.commonServer+'/img/sn_left_home.gif';
	this.lhimgon.src = this.commonServer+'/img/sn_left_home_ovr.gif';

}

_Page.prototype.img = function(w,h,a,c,i) {
	if (h==null) h=1;
	if (w==null) w=1;
	if (a==null) a='';
	if (c==null) c='';
	if (i==null) i='t.gif';
	var html='<img src="'+this.commonServer+'/img/'+i+'"'+(c==''?'':' class="'+c+'"')+' width="'+w+'" height="'+h+'" alt="'+a+'" border="0" />';
	return html;
}

_Page.prototype.showLeftNavigator = function() {
    /* determine if we need to show left navigator */

    return(!(this.item==null ||
             this.item==""   ||
             this.hideLeftNavigation))
}

_Page.prototype.output = function(html) {
	var encoded_html;
	if (this.trace) {
		encoded_html=html.replace(/\&/g,"&amp;");
		encoded_html=encoded_html.replace(/>/g,"&gt;");
		encoded_html=encoded_html.replace(/</g,"&lt;");
		encoded_html=encoded_html.replace(/\n/g,"<br />");
		this.traceWindow.document.write(encoded_html)
	}
	document.write(html)
}

_Page.prototype.showButtons  = function() {
	var buttons_html='';
	var butsize=0;

	for (i=0;i<this.buttons.length;i++) {
		buttons_html+='\
						<a href="#" onClick="javascript:window.open(\''+this.buttons[i].link+'\',\'\',\'width=603,height=480,menubar,resizable,toolbar,scrollbars\')">'+
			this.img(this.buttons[i].width,23,this.buttons[i].text,null,this.buttons[i].img)+
			'</a>\n'+
			(i<(this.buttons.length-1)?'\
						'+this.img(9,1)+'\n':'')
			butsize+=this.buttons[i].width+9;
	}
	var spacer=this.clientWidth-butsize-154;
	spacer = spacer<40?40:spacer;
	buttons_html = '<td>'+this.img(spacer,1)+'</td>\n\
					<td nowrap="nowrap">\n' + buttons_html + '\
					</td>\n';

	return(buttons_html)
}

_Page.prototype.startPage = function(item) {
	var p=this;
	/* figure out the window width */
	function getIEVersion() {
		var ua = navigator.userAgent;
		var IEOffset = ua.indexOf('MSIE ')
		return parseFloat(ua.substring(IEOffset + 5, ua.indexOf(';', IEOffset)))
	}

	if (p.ns=='1') {
		p.clientWidth = window.innerWidth-16;
		p.clientHeight = window.innerHeight-14;
	} else {
		if (document.compatMode && document.compatMode != 'BackCompat') {
			p.clientWidth = document.documentElement.clientWidth;
			p.clientHeight = document.documentElement.clientHeight-20;
		} else {
			p.clientWidth = document.body.clientWidth-((getIEVersion()>=5 && getIEVersion() < 5.5)?18:0);
			p.clientHeight = document.body.clientHeight-16;
		}	
	}

	/* If no item is passed as parameter, try and lookup the current location, */
	if (item==null){
		var tmp = linkLookup(p,document.location.pathname);
		p.item=(tmp=="")?"-1":tmp;
	}else{
		if(item==""){
			p.item="-1";
		}else{
			p.item = item;
		}
	}
	if((p.item=="-1"||p.item=="0") && !p.hideLeftNavigation)p.hideLeftNavigation = true;

	/* Global variables */
	var hierArr=p.item.split("_");
	var currentLevel=hierArr.length;
	var deepest=(p.items[p.item+"_1"]==null)?true:false;
	var comsvr = p.commonServer;
	var currentItem=p.items[p.item];
	p.traceVar+='current level='+currentLevel+'<br>deepest='+deepest;

	function linkLookup(p,l) {
		for (i in p.items) {
			if (l == p.items[i].link) {
				return(i);
			}
		}
		return "";
	}

	function leftNavigation (p) {
		var html='';

		function boldItem(t,l){
			return '\
	<tr>\n\
		<td>\n\
			<table border="0" cellspacing="0" cellpadding="0">\n\
				<tr valign="top">\n\
					<td class="p-lnnavb'+l+'">'+p.img(16,15,null,null,'ln_arrow.gif')+'</td>\n\
					<td class="p-lnnavtb"><a href="'+t.link+'"><b>'+t.text+'</b></a></td>\n\
				</tr>\n\
			</table>\n\
		</td>\n\
	</tr>\n';
		}

		function boldItemCur(t,l){
			var s='\
	<tr id="p-lntrsel">\n\
		<td>\n\
			<table border="0" cellspacing="0" cellpadding="0">\n\
				<tr valign="top">\n\
					<td class="p-lnnavb'+l+'">';
			if(!(l==1 && deepest)){
				s+=p.img(16,15,null,null,'ln_arrow.gif');
			} else {
				s+=p.img(16,15);
			}
			s+='</td>\n\
					<td class="p-lnnavtb"><a href="'+t.link+'"><b>'+t.text+'</b></a></td>\n\
				</tr>\n\
			</table>\n\
		</td>\n\
	</tr>\n'
  		return s;
		}

		function normItem(t,l,i){
			var s='\
	<tr class="p-lnitem">\n\
		<td>\n\
			<table border="0" cellspacing="0" cellpadding="0">\n\
				<tr valign="top">\n\
					<td class="p-lnnavl'+l+'">';
			if(!(p.items[i+"_1"]==null)) {
				s+=p.img(16,15,null,null,'ln_arrow_right.gif');
			} else {
				s+=p.img(16,15);
			}
			s+='</td>\n\
					<td class="p-lnnavtn"><a href="'+t.link+'">'+t.text+'</a></td>\n\
				</tr>\n\
			</table>\n\
		</td>\n\
	</tr>\n'
  		return s;
		}

		function normItemCur(t,l){
			return '\
	<tr class="p-lnitem" id="p-lntrsel">\n\
		<td>\n\
			<table border="0" cellspacing="0" cellpadding="0"><tr valign="top"><td class="p-lnnavl'+l+'">\n'+p.img(16,15)+'</td><td class="p-lnnavtn"><a href="'+t.link+'">'+t.text+'</td></tr></table>\n\
		</td>\n\
	</tr>\n';
		}

		function showParents() {
			var s='',x='', m;
			for (var i=0; i<hierArr.length-1; i++) {
				x+=hierArr[i];
				m=p.items[x];
				s+=boldItem(m,i+1)
				x+='_';
			}
			return s;
		}

		function showChildren(x) {
			var s='', c='', m, l=currentLevel+1;
			if(deepest && currentLevel>1)l=currentLevel;
			for (var i=1;!(p.items[x+"_"+i]==null);i++) {
				c=x+"_"+i;
				m=p.items[c];
				if(c==p.item){
					s+=normItemCur(m,l);
				}else{
					s+=normItem(m,l,c);
				}
			}
			return s;
		}

		function showSiblings(){
			var i=hierArr.slice(0,-1).join("_");
                        var s=showChildren(i);
			return s;
		}

		html+='\
<table width="175" border="0" cellspacing="0" cellpadding="0" id="p-lntable">\n\
	<tr>\n\
		<td>'+p.img(1,24)+'</td>\n\
	</tr>\n';
		html+=showParents();
		if(deepest && currentLevel>1){
			html+=showSiblings();
		}else{
			html+=boldItemCur(currentItem,currentLevel);
			html+=showChildren(p.item);
		}

		html+='\
</table>\n';
		p.output('<div id="p-leftnavigation">'+html+'</div>');
		return(html);
	}


	function checkRSStyle(i,p) {
		var s, l=p.sites[i].link;

		style=(i==p.sites.length-1?'padding-bottom:7px;':'');
		
		if (l=='' | l=='#' | l=='javascript:void(null)') {
			s += p.noLink;
		} else {
			s += p.nsHand;
		}

		return s==''?'':' style="'+s+'"';
	}

	function relatedSitesLayer(p){
		var s='\
<table id="p-siteident" cellspacing="0" cellpadding="0" style="position: absolute; top:0px; left: 0px; visibility:hidden"><tr><td class="p-siteidentifier" nowrap="nowrap">\n\
	'+p.siteIdentifier+'\n\
</td></tr></table>\n';

if (_page.ns!='1') {
	s+="<IFRAME frameborder=0 id=if-p-rsdiv src=\"\" scroll=none style=\"FILTER:progid:DXImageTransform.Microsoft.Alpha(style=0,opacity=0);visibility:hidden;height:0;position:absolute;width:0px;top:0px;z-index:2\"></iframe>"
}

s+='<div id="p-rsdiv">\n\
	<table id="p-relsitelay" cellspacing="0" cellpadding="0"><tr><td>\n\
		<table id="p-rstlg" cellspacing="0" cellpadding="0"><tr><td>\n\
			<table id="p-rstdg" cellspacing="0" cellpadding="0"><tr><td>\n\
				<table id="p-rstwh" cellspacing="0" cellpadding="0">\n';

		for (var i=0;i<p.sites.length; i++) {
			var m=p.sites[i];
			s+='\
					<tr><td'+(i==0?' nowrap="nowrap"':'')+
					' id="p-rsrow_'+i+'" class="p-rstd'+
					((i==0)?'main':'')+'"'+
					checkRSStyle(i,p)+
					' onmouseover="_MOverRS(this)" onmouseout="_MOutRS(this)" onclick="_MClickRS(this)">'+m.text+
					((i==0)?p.img(19,11,null,'p-syst','rs_arrow.gif'):'')+
					'</td></tr>\n';
		}				
		s+='\
				</table>\n\
			</td></tr></table>\n\
		</td></tr></table>\n\
	</td>\n\
	<td id="p-rsdotv">'+p.img()+'</td></tr>\n\
	<tr>\n\
		<td id="p-rsdoth">'+p.img()+'</td>\n\
		<td>'+p.img()+'</td>\n\
	</tr>\n\
	</table>\n\
</div>\n';
		return s;
	}

	function relatedSitesLink(p){
		var s='\
<table width="180" border="0" cellspacing="0" cellpadding="0">\n\
	<tr id="p-rs-row1">\n\
		<td id="p-relatedlayerplace">'+p.img(180,9,null,'p-syst')+'</td>\n\
	</tr>\n\
	<tr id="p-rs-row2">\n\
		<td align="left" nowrap="nowrap">';
		if (p.sites.length==0){
			s+='&nbsp;';
		}else{
			if (p.sites.length==1){
				s+='<a href="'+p.sites[0].link+'">'+p.sites[0].text+'</a>';
			}else{
				s+='<a href="#" onmouseover="_showHideRelatedSites()">'+p.sites[0].text+p.img(19,11,null,'p-syst','rs_arrow.gif')+'</a>';
			}
		}
		s+='\
		</td>\n\
	</tr>\n\
</table>\n'
		return s;
	}

	function checkHome(i,l,p) {
		var s;

		s=(i==0?'padding-left:0px;':'');
		if (l=='' | l=='#' | l=='javascript:void(null)') {
			s += p.noLink;
		} else {
			s += p.nsHand;
		}

		return s==''?'':' style="'+s+'"';
	}

	function topBar(p) {
		var x, s='', i;
		var u = p.item.indexOf('_');
		var inx = u<1?p.item:p.item.slice(0,u);

		s+='<table cellpadding="0" cellspacing="0" border="0">\n';
		s+='<tr>\n';
  
		for (i=0;p.items[i.toString()]!=null;i++) {
			var x=i.toString();
			s+='<td id="p-mi_'+i+'" class="p-ti'+(x==inx?'h':'')+'"'+checkHome(i, p.items[x].link,p)+' onmouseover="_MOver(this)" onmouseout="_MOut(this)" onclick="_MClick(this)" nowrap="nowrap">';
			s+=p.items[x].text;
			s+='</td>\n';
		}

		s+='</tr>\n';
		s+='</table>\n';
		p.output('<div id="p-topbar">\n'+s+'</div>\n');
		return s;
	}

	if (p.trace) {
	   p.traceWindow = window.open()
	   p.traceWindow.document.open()
	   p.traceWindow.document.write('<html><body><h1>Trace of generated HTML</h1><pre>')
	}

	p.output(relatedSitesLayer(p));
	var rsl=document.getElementById('p-relsitelay').offsetWidth;
	rsl = rsl<180?180:rsl;

	var tb=topBar(p), ln, lnw;
	if (p.showLeftNavigator()) {
		ln=leftNavigation(p);
		lnw=document.getElementById('p-leftnavigation').offsetWidth-17;
	} else {
		lnw=220;
	}
	var tbw=document.getElementById('p-topbar').offsetWidth;
	tbw=tbw<(p.clientWidth-54)?p.clientWidth-54:tbw;

	document.getElementById('p-topbar').innerHTML='&nbsp;';
/*+p.img(tbw-lnw-17,1)*/
/*p.showButtons()*/
	var html='\
<table id="p-body" border="0" cellspacing="0" cellpadding="0" width="100%"> \n\
	<tr id="p-row1" class="p-bgcc3333"> \n\
		<td width="10">'+p.img(10,1)+'</td>\n\
		<td width="17">'+p.img(17,1)+'</td>\n\
		<td width="158">'+p.img(lnw,1)+'</td>\n\
		<td width="17">'+p.img(17,1)+'</td>\n\
		<td>'+'</td>\n\
		<td width="17">'+p.img(17,1)+'</td>\n\
		<td width="10">'+p.img(10,1)+'</td>\n\
	</tr>\n\
	<tr id="p-row2" class="p-bgcc3333">\n\
    <td colspan="2">&nbsp;</td>\n\
		<td colspan="3">\n\
			<table border="0" cellspacing="0" cellpadding="0">\n\
				<tr>\n\
					<td>'+p.img(140,26,'Logo',null,'logo.gif')+'</td>\n\
					'+'<td><img height="28" border="0" width="44" alt="Vlag" src="/img/vlag.png" style="padding-left:20px;"><span id="pagetitle" style="font-size:12px;font-weight:bold;color:white;"></span></td>'+'\
				</tr>\n\
			</table>\n\
		</td>\
		<td colspan="2">&nbsp;</td>\n\
	</tr>\n\
	<tr id="p-row3" class="p-bgcc3333">\n\
		<td colspan="7">&nbsp;</td>\n\
	</tr>\n\
	<tr id="p-row4">\n\
		<td id="p-onlefttop" colspan="2" >&nbsp;</td>\n\
                <td id="p-onmiddle"  colspan="3">\n\
			<table border="0" cellspacing="0" cellpadding="0">\n\
				<tr>\n\
					<td class="p-siteidentifier" nowrap="nowrap">'+p.siteIdentifier+'\n\
                                        </td>\n'+
					(p.sites.length==0?'':'\
					<td>'+p.img(p.clientWidth -rsl -document.getElementById('p-siteident').offsetWidth -54,1)+'</td>\n\
					<td valign="top">\n'+relatedSitesLink(p)+'\n\
					</td>\n')+'\
				</tr>\n\
			</table>\n\
		</td>\n\
		<td id="p-onrighttop" colspan="2">&nbsp;</td>\n\
	</tr>\n\
	<tr id="p-row5" valign="bottom">\n\
		<td id="p-lefttop">&nbsp;</td>\n';

		if (p.item=="0") {
			html+='\
					<td width="17" id="p-snlefthome" onclick="_MClickLH(this)"'+(p.ns==1?'style="cursor:pointer;"':'style="cursor:hand;"')+'>'+p.img(17,1)+'</td>\n';
		}else {
			html+='\
					<td width="17" id="p-snleft" onmouseover="_MOverLH(this)" onmouseout="_MOutLH(this)" onclick="_MClickLH(this)"'+(p.ns==1?'style="cursor:pointer;':'style="cursor:hand;')+'background-image:url('+comsvr+'/img/sn_left_home.gif);">'+p.img(17,1)+'</td>\n';
		}
		html+='\
		<td id="p-snmiddle" colspan="3">'+tb+'</td>\n\
		<td id="p-snright">&nbsp;</td>\n\
		<td id="p-righttop">&nbsp;</td>\n\
	</tr>\n'

    if (p.showLeftNavigator()) {
       /* show left navigator */
       html+='\
	<tr id="p-row6" valign="top">\n\
		<td id="p-left" width="10"></td>\n\
		<td colspan="2" class="p-bgefefef" width="175">\n\
		<!-- begin left navigation -->\n';
				html+=ln;
				html+='\
		<!-- end left navigation -->\n\
		</td>\n\
		<td class="p-bgffffff" width="17">&nbsp;</td>\n\
		<td class="p-bgffffff">\n\
		<!-- start of content area -->\n\n'
    }
    else {
        /* hide left navigator */
        html+='\
	<tr id="p-row6" valign="top">\n\
		<td id="p-left"></td>\n\
		<td id="p-leftinside">&nbsp;</td>\n\
		<td colspan="3" class="p-bgffffff">\n\
		<!-- start of content area -->\n\n'
    }

   p.output(html)

}

_Page.prototype.siteMap = function() {
	var p=this;
	var html='\
<table border="0" cellspacing="0" cellpadding="0" class="p-sitemap" width="100%">\n\
	<tr>\n';

	function doTable(p, i, l){
		var t;
		var html='\
				<tr>\n\
					<td class="p-sitemapr'+(l>1?2:l)+'"'+(l>1?' style="padding-left:'+(l*16-20)+'px"':'')+'>\n';
		if (l>1) html+='\
					<ul><li>\n';
		html+='\
						<a href="'+p.items[i].link+'">'+p.items[i
].text+'</a></td>\n';

		if (l>1) html+='\
					</li></ul>\n';
		html+='\
				</tr>\n';
		p.output(html);
		if (p.items[i+'_1']!=null) {
			for(t=1; p.items[i+'_'+t.toString()]!=null; t++) {
				doTable(p, i+"_"+t.toString(), l+1);
			}
		}
	}

	for(var i=1; p.items[i.toString()]!=null; i++) {
		html+='\
		<td valign="top" width="33%">\n\
			<table border="0" cellspacing="0" cellpadding="0" class="p-sitemapcol" width="100%">\n';
		p.output(html);

		doTable(p, i.toString(), 0);
		
		html='\
			</table>\n\
		</td>\n';
		if (Math.floor(i/3)==i/3) {
			html+='\
	</tr>\n\
	<tr>\n\
		<td colspan="5">'+p.img(1,30)+'</td>\n\
	</tr>\n\
	<tr>\n';
		} else {
			html+='\
		<td width="17">'+p.img(17,1)+'</td>\n';
		}
	}
	html+='\
	</tr>\n\
</table>\n';

	p.output(html);

}

_Page.prototype.endPage = function() {
	var p=this;
	var ln = (p.showLeftNavigator()?"-ln":"");
	var j;

	function hasSubMenu(item,i,l) {
		var html;
		var style;

		if (p.items[item+"_1"]!=null) {
			html='class="p-mism"';
		} else {
			html='class="p-mi"';
		}
		style = (i==1?p.topItem:'');

		if (l=='' | l=='#' | l=='javascript:void(null)') {
			style += p.noLink;
		} else {
			style += p.nsHand;
		}

		html += (style==''?'':' style="'+style+'"');
		return html;
	}

	function subMenu(item) {
		var index;
		var i;
  		var s="";
  		
  		if (_page.ns!='1') {
			s+="<IFRAME frameborder=0 id=if-p-sm_"+item+" src=\"\" scroll=none style=\"FILTER:progid:DXImageTransform.Microsoft.Alpha(style=0,opacity=0);visibility:hidden;height:0;position:absolute;width:0px;top:0px;z-index:10\"></iframe>"
		}

		s+='<div id="p-sm_'+item+'" class="p-sm">\n\
	<table border="0" cellspacing="0" cellpadding="0" width="100%" class="p-smt">\n';
  
		for (i=1;p.items[item+"_"+i.toString()]!=null;i++) {
			index=item+"_"+i.toString();
			s+='\
		<tr>\n\
			<td id="p-mi_'+index+'" '+hasSubMenu(index,i,p.items[index].link)+' onmouseover="_MOver(this)" onmouseout="_MOut(this)" onclick="_MClick(this)">' + p.items[index].text + '</td>\n\
		</tr>\n';
		}

		s+='\
	</table>\n\
</div>\n';
		return s;
	}

	function createSubmenus(item) {
   		var i;
		if (p.items[item+"_1"]!=null) {
			p.output(subMenu(item));
			for (i=1;p.items[item+"_"+i.toString()]!=null;i++) {
				createSubmenus(item+"_"+i.toString());
			}
		}
	}

	var html='\n\n\
		<!-- end of content area -->\n\
                </td>\n\
		<td id="p-rightinside">&nbsp;</td>\n\
		<td id="p-right">&nbsp;</td>\n\
	</tr>\n\
	<tr id="p-row7">\n\
		<td id="p-bottomleft">&nbsp;</td>\n\
		<td id="p-bottomleftcorner'+ln+'">&nbsp;</td>\n\
                <td class="p-bottom'+ln+'">&nbsp;</td>\n\
		<td class="p-bottom" colspan="2">&nbsp;</td>\n\
		<td id="p-bottomrightcorner">&nbsp;</td>\n\
                <td id="p-bottomright">&nbsp;</td>\n\
	</tr>\n\
</table>\n\
\n';

	p.output(html)

	for (j=0;p.items[j.toString()]!=null;j++) {
       		createSubmenus(j.toString());
	}   

	if (p.trace) {
	   p.traceWindow.document.write('</pre><hr>'+p.traceVar+'<hr>')
	   p.traceWindow.document.write('</body></html>')
	   p.traceWindow.document.close()
	}
	document.close();
}

_Page.prototype.printVersion = function(cellid){
	var docTitle=window.document.title;
	var docHead=document.getElementsByTagName("head")[0].innerHTML;
        
	var docContent=document.getElementById(cellid).innerHTML;
	var prWindow;

	prWindow = window.open('','thePrWindow','width=603,height=480,menubar,resizable,toolbar,scrollbars');
  prWindow.document.open();
  prWindow.document.write('\
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "DTD/xhtml1-transitional.dtd">\n\
<html>\n\
<head>'+docHead+'</head>\n\
<body class="p-printversion">\n\
	<table width="100%" cellpadding="0" cellspacing="0">\n\
		<tr id="p-row1" class="p-bgcc3333">\n\
			<td width="20">'+this.img(20,1)+'</td>\n\
			<td></td>\n\
			<td width="20">'+this.img(20,1)+'</td>\n\
		</tr>\n\
		<tr id="p-row2" class="p-bgcc3333">\n\
			<td>&nbsp;</td>\n\
			<td>\n\
				<table border="0" cellspacing="0" cellpadding="0" width="100%">\n\
					<tr>\n\
						<td>'+this.img(140,26,'Logo',null,'logo.gif')+'</td>\n\
					</tr>\n\
				</table>\n\
			</td>\n\
			<td>&nbsp;</td>\n\
		</tr>\n\
		<tr id="p-row3" class="p-bgcc3333">\n\
			<td colspan="3">&nbsp;</td>\n\
		</tr>\n\
		<tr id="p-carow1">\n\
			<td colspan="3">&nbsp;</td>\n\
		</tr>\n\
		<tr>\n\
			<td>&nbsp;</td>\n\
			<td>\n'+docContent+'</td>\n\
			<td>&nbsp;</td>\n\
		</tr>\n\
		<tr id="p-carow1">\n\
			<td colspan="3">&nbsp;</td>\n\
		</tr>\n\
	</table>\n\
</body>\n\
</html>')

	prWindow.document.close()
	prWindow.focus();
}

function _MOverLH(el) {
	if (el.sn==null) {
		el.sn=document.getElementById('p-snleft');
	}
	if (el.lh==null) {
		el.lh=document.getElementById('p-mi_0');
	}
	if (el.sn!=null) {
		el.sn.style.backgroundColor='#EFEFEF';
		el.sn.style.backgroundImage='url('+_page.lhimgon.src+')';
	}
	if (el.lh!=null) {
		id=el.lh.id.slice(el.lh.id.indexOf('_')+1);
		window.status = _page.items[id].link;
		el.lh.style.backgroundColor='#EFEFEF';
		el.lh.style.color="#cc3333";
	}
}

function _MOutLH(el) {
	window.status = '';
	if (el.sn==null) {
		el.sn=document.getElementById('p-snleft');
	}	
	if(el.lh==null) {
		el.lh=document.getElementById('p-mi_0');
	}
	if (el.sn!=null) {
		el.sn.style.backgroundColor='#DFDFDF';
		el.sn.style.backgroundImage='url('+_page.lhimgoff.src+')';
	}
	if (el.lh!=null) {
		el.lh.style.backgroundColor='#DFDFDF';
		el.lh.style.color="#214439";
	}
	el.className='p-snleft';
}

function _MClickLH(el) {
	if (el.lh==null) {
		el.lh=document.getElementById('p-mi_0');
	}
	_MClick(el.lh);
}

function _MOver(el) {	
	function getScrollX() {
		if (_page.ns=='1') {
			return window.pageXOffset;
		} else {
			if (document.compatMode && document.compatMode != 'BackCompat') {
					return document.documentElement.scrollLeft;
			} else {
					return document.body.scrollLeft;
			}
		}
	}

	function getScrollY() {
		if (_page.ns=='1') {
			return window.pageYOffset;
		} else {
			if (document.compatMode && document.compatMode != 'BackCompat') {
					return document.documentElement.scrollTop;
			} else {
					return document.body.scrollTop;
			}
		}
	}

	clearTimeout(_page.timer);

	var id = el.id.slice(el.id.indexOf('_')+1);

	var l = _page.items[id].link;
	if (l!='' & l!='#' & l!='javascript:void(null)') {
		window.status = l;
	}

	if (el.className!='p-tih') {
		el.style.backgroundColor="#efefef";
   		el.style.color="#cc3333";
		var n1 = parseInt(el.id.indexOf("_"));
		var n2 = parseInt(el.id.lastIndexOf("_"));
		if (n1 == n2) {
			el.style.backgroundImage='url(/img/sn_bg_hover.gif)';
		} 
		/* Links van de Home tab, uitgevoerd door hoover boven home*/
		if (el.id == "p-mi_0") {
			lh=document.getElementById('p-snleft');
			if (lh!=null) {
				lh.style.backgroundImage='url('+_page.lhimgon.src+')';
				el.lh = lh;
			}
		}
	}

	for (i=_page.listNr; i>0; i--) {
		l=_page.listSM[i-1].id.length<el.id.length?_page.listSM[i-1].id.length:el.id.length;
		if (_page.listSM[i-1].id.slice(4) != el.id.slice(4,l)) {
		
			_fixForm(true,_page.listSM[i-1]);
			_page.listSM[i-1].style.visibility='hidden';
			if(_page.listSM[i-1].pe.className!='p-tih') {
				_page.listSM[i-1].pe.style.backgroundColor="#DFDFDF";
				_page.listSM[i-1].pe.style.color="#214439";
				if (_page.listSM[i-1].pe.lh!=null) {
					_page.listSM[i-1].pe.lh.style.backgroundImage='url('+_page.lhimgoff.src+')';
				}
			}
			_page.listNr=i-1;
		}
	}

	if (_page.listNr>0) {
		if(_page.listSM[_page.listNr-1].pe.className!='p-tih') {
			_page.listSM[_page.listNr-1].pe.style.backgroundColor="#EFEFEF";
			_page.listSM[0].pe.style.color="#214439";
		}
	}

	if (el.sm==null) {
		el.sm = document.getElementById('p-sm_' + id);
		if (el.sm!=null) {
			if (_page.ns=='1') {
				var mi = document.getElementById('p-mi_'+id+'_1');
				el.sm.style.width=(mi.offsetWidth+2)+'px';
			}
			if (id.lastIndexOf('_') > -1) {
				el.pm = document.getElementById('p-sm_' + id.slice(0,id.lastIndexOf('_')));
			}
		}
	}

	if (el.sm!=null) {
		if (el.pm!=null) {
			var fmc=id.slice(id.length-2)=='_1'?1:0;
			el.sm.top = el.pm.top+el.offsetTop-fmc;
			if ((el.sm.top+el.sm.offsetHeight)>(_page.clientHeight+getScrollY())){
				el.sm.top=_page.clientHeight+getScrollY()-el.sm.offsetHeight;
			}
			if (el.pm.lft=='1') {
				el.sm.left = el.pm.left+el.offsetWidth-4;
				if ((el.sm.left+el.sm.offsetWidth)>_page.clientWidth-18+getScrollX()) {
					el.sm.left = el.pm.left-el.sm.offsetWidth+4;
					el.sm.lft = '0';
				} else {
					el.sm.lft = '1';
				}
			} else {
				el.sm.left = el.pm.left-el.sm.offsetWidth+4;
				if (el.sm.left<getScrollX()) {
					el.sm.left = el.pm.left+el.offsetWidth-4;
					el.sm.lft = '1';
				} else {
					el.sm.lft = '0';
				}
			}		
		} else {
			/* originele hoogte van el.sm.top=106*/
			el.sm.top=88;
			el.sm.left=el.offsetLeft + (_page.ns=='1'&&_page.ns7!='1'?3:30)-4;
			el.sm.lft='1';
		}
		el.sm.style.top=el.sm.top+'px';
		el.sm.style.left=el.sm.left+'px';
	}


	if (el.sm!=null) {
		el.sm.style.visibility='visible';
		_page.listSM[_page.listNr] = el.sm;
		_page.listSM[_page.listNr].pe = el;
		_page.listNr++;
		
		_fixForm(false, el.sm);
	}
}

function _MOut(el) {
	window.status='';

	if (el.className!='p-tih') {
		el.style.backgroundColor="#DFDFDF";
		el.style.color="#214439";
		var n1 = parseInt(el.id.indexOf("_"))
		var n2 = parseInt(el.id.lastIndexOf("_"))
		if (n1 == n2) {
			el.style.backgroundImage='url(/img/sn_bg.gif)';
		}
		if (el.lh != null) {
			el.lh.style.backgroundImage='url('+_page.lhimgoff.src+')';
		}
	}
	_page.timer=setTimeout(_clearMenu,_page.delay);
}

function _MClick(el) {
	var id = el.id.slice(el.id.indexOf('_')+1);
	var l = _page.items[id].link;

	if (l!='' & l!='#' & l!='javascript:void(null)') {
		if (_page.ns=='1') {
			if (_page.items[id].nw==true) {
				window.open(l, '')
			} else {
				window.location=l;
			}
		} else {
			if (_page.items[id].nw==true || window.event.shiftKey || window.event.ctrlKey) {
				window.open(l, '')
			} else {
				window.location=l;
			}
		}
	}
}

function _clearMenu() {
	var lh;

	for (i=_page.listNr; i>0; i--) {
		_page.listSM[i-1].style.visibility='hidden';
		_fixForm(true,_page.listSM[i-1]);
		if(_page.listSM[i-1].pe.className!='p-tih') {
			_page.listSM[i-1].pe.style.backgroundColor='#DFDFDF';
			_page.listSM[i-1].pe.style.color='#214439';
			if(_page.listSM[i-1].pe.lh != null) {
				_page.listSM[i-1].pe.lh.className='p-snleft';
			}
		}
	}
	_page.listNr=0;
}

function _MOverRS(el) {
	clearTimeout(_page.rsTimer);
	el.style.color='#214439';
	window.status=_page.sites[parseInt(el.id.slice(el.id.indexOf('_')+1))].link;
}
function _MOutRS(el) {
	el.style.color='#0000FF';
	window.status='';
	_page.rsTimer=setTimeout('_showHideRelatedSites()',_page.delay);
}
function _MClickRS(el) {
	var id = parseInt(el.id.slice(el.id.indexOf('_')+1));
	var l=_page.sites[id].link;

		if (_page.ns=='1') {
			if (_page.sites[id].nw==true) {
				window.open(l, '')
			} else {
				window.location=l;
			}
		} else {
			if (_page.sites[id].nw==true || window.event.shiftKey || window.event.ctrlKey) {
				window.open(l, '')
			} else {
				window.location=l;
			}
		}
}

function _showHideRelatedSites(){
	function _findCoordinates(obj,axis)
	{
		var pos = 0;
		while (obj.offsetParent)
		{
			pos += (axis=='y')?obj.offsetTop:obj.offsetLeft;
			obj = obj.offsetParent;
		}
		return pos;
	}

	_page.rsLayer= document.getElementById('p-rsdiv');
	var imgObj=document.getElementById('p-relatedlayerplace');
	_page.rsLayer.style.left = (_findCoordinates(imgObj,'x')-6)+'px';
	_page.rsLayer.style.top = '50px';
	if (_page.rsLayer.style.visibility == 'visible') {
		_page.rsLayer.style.visibility='hidden';
		if (_page.ns!='1') {
			_fixForm(true,document.getElementById('p-rsdiv'));
		}
	} else {
		_page.rsLayer.style.visibility='visible';
		if (_page.ns!='1') {
			_fixForm(false,document.getElementById('p-rsdiv'));
		}
	}
}

/*
This protect menu's from sliding under select boxes.
 */
function _fixForm(show,menuObject){

	function getIEVersion() {
		var ua = navigator.userAgent;
		var IEOffset = ua.indexOf('MSIE ')
		return parseFloat(ua.substring(IEOffset + 5, ua.indexOf(';', IEOffset)))
	}

	if (_page.ns!='1') {
		if(getIEVersion() < 5.5) {
			//Do Nothing.
		} else {
			if(show) {
				document.getElementById("if-"+menuObject.id).style.visibility='hidden';
			} else {
				document.getElementById("if-"+menuObject.id).style.visibility='visible';
				document.getElementById("if-"+menuObject.id).style.top=menuObject.offsetTop+"px";
				document.getElementById("if-"+menuObject.id).style.left=menuObject.offsetLeft+"px";
				document.getElementById("if-"+menuObject.id).style.height=menuObject.offsetHeight+"px";
				document.getElementById("if-"+menuObject.id).style.width=menuObject.offsetWidth+"px";
			}
		}
	}
}

/*
We need only a single instance of _Page class.
 */
var _page = new _Page();

/*
Needed for backwards compatibility 
*/
function _nop() {}
window.onload = _nop;
window.onresize = _nop;