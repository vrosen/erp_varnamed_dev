var isdirty = false;	// wordt true als een invoer veld gewijzigd is
var curl = 'maxmedicalcontrol.db.genxls';

function hasChanged() {
	isdirty = true;
}

function ConfirmSavechanges() { /*zonder parameters*/ 
	if (isdirty) {
		var lConfirm = confirm('Möchten Sie die Änderungen Speichern?');
		if (lConfirm) {
			isdirty = false;
			document.forms[0].submit();
		}
	}
}

function gotoPage(cDoel) {
	document.form1.doel.value = cDoel;
	document.form1.submit();
}

function ConfirmSavechanges2(oForm) { /*met formnaam als parameter (voor als er twee forms op de pagina staan)*/
	if (isdirty) {
		var lConfirm = confirm('Möchten Sie die Änderungen Speichern?');
		if (lConfirm === true) {
			isdirty = false;
			oForm.submit();
		}
	}
}

function ConfirmSavechanges3(FormiName,TeDoen) { /*formnaam als parameter, verzenden via verzendscript*/
	if (isdirty) {
		var lConfirm = confirm('Möchten Sie die Änderungen speichern?');
		if (lConfirm == true) {
			isdirty = false;
			VerzendScript(FormiName, TeDoen);
		}
	}
}

function VerzendScript(FormiName, TeDoen) {
	isdirty = false;
	if (TeDoen == 'DisaBled') {
		document.forms[FormiName].submit();
	}
	else {
		if(TeDoen=='verwijderen') {
			var lConfirm = confirm('Sind Sie sicher davon?')
			if (lConfirm == true) {
				document.forms[FormiName].opdracht.value = TeDoen;
				document.forms[FormiName].submit();
			}
		}
		else {
			document.forms[FormiName].opdracht.value = TeDoen;
			document.forms[FormiName].submit();
		}
	}
}

function VerzendScript2(FormiName, TeDoen) {
	isdirty = false;
	if (checkform()==true) {
		document.forms[FormiName].submit();
	}
}

function VerzendScript3(FormiName, cName, cValue)	{
	isdirty = false;
	document.forms[FormiName][cName].value = cValue;
	document.forms[FormiName].submit();
}

function Savechanges()  /*zonder parameter*/{
	isdirty = false;
	document.forms[0].submit()
}

function Savechanges2(oForm)  { /*met formnaam als parameter (voor als er twee forms op de pagina staan)*/
	isdirty = false;
	oForm.submit() ;
}

function changesortorder(cparam1, cparam2, nparam3,csortorder)  { /*alleen gebruikt vanaf management.html*/
	isdirty=false;
	document.forms[0].type.value=cparam1;
	document.forms[0].idnr.value=cparam2;
	document.forms[0].nwlv.value=nparam3;
	document.forms[0].curorder.value=csortorder;
	document.forms[0].submit();
}

function management(cparam1, cparam2, cparam3)  {
	isdirty=false;
	document.forms[0].type.value=cparam1;
	document.forms[0].idnr.value=cparam2;
	document.forms[0].leidingnr.value=cparam3;
	document.forms[0].nwlv.value=document.forms[0].nwlv2.value;
	document.forms[0].nosort.value='yes';
	document.forms[0].submit();
}
function management2(cparam1, cparam2, nparam3)  {
	isdirty=false;
	document.forms[0].type.value=cparam1;
	document.forms[0].idnr.value=cparam2;
	document.forms[0].nwlv.value=nparam3;
	document.forms[0].nosort.value='yes';
	document.forms[0].submit();
}
function changesortorder(cparam1, cparam2, nparam3,csortorder)  {
	isdirty=false;
	document.forms[0].type.value=cparam1;
	document.forms[0].idnr.value=cparam2;
	document.forms[0].nwlv.value=nparam3;
	document.forms[0].curorder.value=csortorder;
	document.forms[0].submit();
}
function wordPopUp(topic) { /*voor het openen van RTF bestanden (factuur, opdracht etc)*/
	aPopUp=window.open(topic,'','','toolbar=no,location=no,directories=no,status=yes,scrollbars=yes,resizable=yes,copyhistory=no');
}
function helpPopUp(topic,width,height) {
	aPopUp=window.open(topic,'','height='+height+',width='+width+',toolbar=no,location=no,directories=no,status=no,scrollbars=yes,resizable=yes,copyhistory=no');
}
function IndexPopup(nitem) {
	aPopUp=window.open(nitem,'','','toolbar=no,location=no,directories=no,status=yes,scrollbars=yes,resizable=yes,copyhistory=no');
}
function PopUpPrint(topic,width,height) { /* alleen gebruikt in downloads.html */
	aPopUp=window.open(topic,'','height='+height+',width='+width+',toolbar=yes,location=no,directories=no,status=no,scrollbars=yes,resizable=yes,copyhistory=no');
}
function ControlNaam() { /*wordt gebruikt op editmenu, editmenu0 en editproduct */
	var tmpDOM = document.getElementById("naam")
	if (tmpDOM.value == "") {
		alert("Bitte geben Sie eine Name ein.");
		tmpDOM.focus();
		return false ;
	}
	else {
		return true ;
	}
}

/* Form submitten als op Enter gedrukt wordt */
NS4 = (document.layers) ? true : false;

function lCheckEnter(event) {
	if (event.keyCode==13) { 
		return true ;
	}
	return false ;
}

function checkEnter(FormaName,event) {
	var code = 0;
	if (NS4) 
		code = event.which;
	else
		code = event.keyCode;
		if (code==13) { 
			VerzendScript(FormaName,"opslaan");
		}
	}

function checkEnterBedrag(FormaName,event,veldnaam) {
/* als op Enter wordt gedrukt in een veld met een bedrag
   dan moet eerst de opmaak van het getal worden gecontroleerd 
   en dan pas het form gesubmit */
	var code = 0;
	if (NS4) {
		code = event.which;
	}
	else {
		code = event.keyCode;
		if (code==13) {
			BedragOpmaken(veldnaam);
			if (FormaName == 'login') {
				document.forms[FormaName].submit();
			}
			else {
				VerzendScript(FormaName,"opslaan");
			}
		}
	}
}

function checkEnterKomma(FormaName,event,veldnaam) {
/* als op Enter wordt gedrukt in een veld met een kommagetal
   dan moet eerst de opmaak van het getal worden gecontroleerd 
   en dan pas het form gesubmit */
	var code = 0;
	if (NS4) {
		code = event.which;
	}
	else {
		code = event.keyCode;
		if (code==13) {
			DecimaalGetalOpmaken(veldnaam);
			if (FormaName == 'login') {
				document.forms[FormaName].submit();
			}
			else {
				VerzendScript(FormaName,"opslaan");
			}
		}
	}
}

// alleen gebruikt op editgutschrift!
/* function checkinput(formaname) {
	csetfocus ='' ;
	lreturn = true
	oform = document.forms[formaname]
	for (var i = 0; i<oform.length; i++) {
		cartfield=oform.elements[i].name ;
		if (cartfield.substring(0,3)=='anr'){
		// zoek het bijbehorende aantalve veld op
		cvefield = 'ave_'+cartfield.substring(4,cartfield.length) ;
		// beide velden zijn nu bekend. Controleer nu of een van de 2 velden leeg is
		cartvalue = oform.elements[cartfield].value ;
		cvevalue = oform.elements[cvefield].value ;
			if ((cartvalue.length==0 &&  cvevalue.length>0) || (cartvalue.length>0 &&  cvevalue.length==0))  {
				if (lreturn==true){
				if (cartvalue.length==0){
					csetfocus = cartfield ;
				}
				if (cvevalue.length==0){
					csetfocus = cvefield ;
				}				
				alert('Auftrag is nicht komplett!') ;
				lreturn = false
			}
			}
		}
	}
	if (lreturn==false){
	oform.elements[csetfocus].focus()
	}
return lreturn
} */

function TcheckEnterArtikel(FormaName,event,cwaarde)
{ 	
	var code = 0;
	if (NS4)
		code = event.which;
	else
		code = event.keyCode;
	if (code==13)
		VerzendScript(FormaName,cwaarde)
}
function TcheckEnterRelatie(FormaName,event)
{ 	
	if (event.keyCode==13) {
		document.forms[FormaName].curname.value = "editrelatie" ;
		VerzendScript('tools','zoekrelatie') ;
		}
}

function toevoegen(fbox,tbox) {

		var i = 0;
		
		if(fbox.value != "") {
			var no = new Option();
			no.value = fbox.value;
			no.text = fbox.value;
			tbox.options[tbox.options.length] = no;
			fbox.value = "";
   		}
	}
	
function verwijderen(box) {

	for(var i=0; i<box.options.length; i++) {
	if(box.options[i].selected && box.options[i] != "") {
		box.options[i].value = "";
		box.options[i].text = "";
		}
	}
	BumpUp(box);
}

function BumpUp(abox) {
	for(var i = 0; i < abox.options.length; i++) {
		if(abox.options[i].value == "")  {
			for(var j = i; j < abox.options.length - 1; j++)  {
				abox.options[j].value = abox.options[j + 1].value;
				abox.options[j].text = abox.options[j + 1].text;
				}
			var ln = i;
			break;
			}
		}
		if(ln < abox.options.length)  {
			abox.options.length -= 1;
			BumpUp(abox);
		}
}
			
// Verplaatsten van menu items

function Moveit(dbox,direction) {

	if (direction == 'up') {
		for(var i = 0; i < dbox.options.length; i++) {
			if (dbox.options[i].selected && dbox.options[i] != "" && dbox.options[i] != dbox.options[0]) {
				var tmpivalue = dbox.options[i].value;
				var tmpitext = dbox.options[i].text;
				var tmpiname = dbox.options[i].id;
				var tmpiminname = dbox.options[i - 1].id;
				var tmpiminvalue = dbox.options[i - 1].value

				dbox.options[i].value = dbox.options[i - 1].value;
				dbox.options[i].text = dbox.options[i - 1].text;
				dbox.options[i-1].value = tmpivalue;
				dbox.options[i-1].text = tmpitext;
				dbox.options[i-1].selected = true;

				// hidden fields bijwerken:
				document.form1[tmpiname].value = tmpiminvalue;
				document.form1[tmpiminname].value = tmpivalue;
			}
		}
	}
	else {
		for(var j = dbox.options.length -1 ; j > -1 ; j--) {
			if (dbox.options[j].selected && dbox.options[j] != "" && dbox.options[j+1] != dbox.options[dbox.options.length]) {
				var tmpjvalue = dbox.options[j].value;
				var tmpjtext = dbox.options[j].text;
				var tmpjname = dbox.options[j].id;
				var tmpjmaxname = dbox.options[j + 1].id;
				var tmpjmaxvalue = dbox.options[j + 1].value

				dbox.options[j].value = dbox.options[j+1].value;
				dbox.options[j].text = dbox.options[j+1].text;
				dbox.options[j+1].value = tmpjvalue;
				dbox.options[j+1].text = tmpjtext;
				dbox.options[j+1].selected = true;

				// hidden fields bijwerken:
				document.form1[tmpjname].value = tmpjmaxvalue;
				document.form1[tmpjmaxname].value = tmpjvalue;
				//document.getElementsByName(tmpjname)[0].value = tmpjmaxvalue;
				//document.getElementsByName(tmpjmaxname)[0].value = tmpjvalue;
			}
		}
	}
}
// Script voor het vinden van een formulierobject
function zetaktief() {
	  var bFound = false;

	  // for each form
	  for (f=0; f < document.forms.length; f++)
	  {
		// for each element in each form
		for(i=0; i < document.forms[f].length; i++)
		{
		  // if it's not a hidden element
		  if (document.forms[f][i].type != "hidden")
		  {
			// and it's not disabled
			if (document.forms[f][i].disabled != true)
			{
				// set the focus to it
				document.forms[f][i].focus();
				var bFound = true;
			}
		  }
		  // if found in this element, stop looking
		  if (bFound == true)
			break;
		}
		// if found in this form, stop looking
		if (bFound == true)
		  break;
	  }
}

// Script voor voorvertoon van Logo's en productfoto's
function PreviewImage(tiepe,Lokatie) {
		for (var j = document.forms['form3'].elements[Lokatie].options.length -1 ; j > -1 ; j--) {
			if (document.forms['form3'].elements[Lokatie].options[j].selected && document.forms['form3'].elements[Lokatie].options[j] != "" && document.forms['form3'].elements[Lokatie].options[j+1] != document.forms['form3'].elements[Lokatie].options[document.forms['form3'].elements[Lokatie].options.length]) {
				document.forms['form3'].elements[tiepe].src = document.forms['form3'].elements[Lokatie].options[j].value;
			}
		}
		for(var j = 0; j < document.forms['form3'].elements[Lokatie].options.length; j++) {
			if (document.forms['form3'].elements[Lokatie].options[j].selected && document.forms['form3'].elements[Lokatie].options[j] != "" && document.forms['form3'].elements[Lokatie].options[j] != document.forms['form3'].elements[Lokatie].options[0]) {
				document.forms['form3'].elements[tiepe].src = document.forms['form3'].elements[Lokatie].options[j].value;
				}
			}
	}

function replacestr(oObj,cFind,cRepl) {
	str = oObj.value;
	while(str.indexOf(cFind)>0) {
		str = str.replace(cFind,cRepl);
	}
	oObj.value = str
}

// Print functie
function printVersion (cellid){
	var docHead=document.getElementsByTagName("head")[0].innerHTML;
	var docContent=document.getElementById(cellid).innerHTML;
	var artikel=document.getElementById("artTitle").innerHTML;
	var prWindow;

	prWindow = window.open('','thePrWindow','width=650,height=400,menubar,resizable,toolbar,scrollbars');
  prWindow.document.open();
  prWindow.document.write('\
<?xml version="1.0" encoding="iso-8859-1"?>\n\
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">\n\
<html xmlns="http://www.w3.org/1999/xhtml">\n\
<html>\n\
<head>'+docHead+'</head>\n\
<body>\n\
<div id="Layer1" style="position:absolute; left:0px; top:0px; width:634px; height:266px; z-index:1; overflow: visible;">\n\
  <table width="100%" border="0" align="left" cellpadding="0" cellspacing="0" class="cattitelsub">\n\
    <tr valign="middle" bgcolor="#AA0850">\n\
      <td height="31" colspan="2"><img src="/img/medsorg-logo.gif" width="160" height="26" hspace="10"/></td>\n\
    </tr>\n\
    <tr>\n\
      <td colspan="2" >&nbsp;</td>\n\
    </tr>\n\
    <tr>\n\
      <td colspan="2" class="cattitel">'+artikel+'</td>\n\
    </tr>\n\
    </tr>\n\
    <tr>\n\
      <td colspan="2"><img src="/img/spacer.gif" width="4" height="6" /></td>\n\
    </tr>\n\
        <tr>\n\
      <td colspan="2" bgcolor="#ffffff"  style="WIDTH: 127px; HEIGHT: 3px"> </td>\n\
    </tr>\n\
	'+docContent+'</table>\n\
</div>\n\
</body>\n\
</html>')

	prWindow.document.close()
	prWindow.focus();
}

// functies voor het controleren en verbeteren van decimaal scheidingstekens en van duizendtallen scheidingstekens
function BedragOpmaken(iVeld) {
	if (!isLeeg(iVeld.value)) iVeld.value = expBedrag(iVeld.value);
}
function DecimaalGetalOpmaken(iVeld) {
	if (!isLeeg(iVeld.value)) iVeld.value = expDecimaal(iVeld.value);
}
function isLeeg(cTk) {
	for (var i=0;i < cTk.length;i++) {
		if (cTk.substring(i,i+1) != " ") return(false);
	}
	return(true);
}
function expBedrag(cInBedrag) {
	var nKPos,nPPos,nPos,cGuld,cCent;
	var cBedrag = rTrim(cInBedrag);
	while (((nPos = eIndexOf(cBedrag,'+')) > -1) || ((nPos = eIndexOf(cBedrag,' ')) > -1))
					{
					cBedrag = cBedrag.substring(0,nPos) + cBedrag.substring(nPos + 1,cBedrag.length);
					}
	nKPos = cBedrag.lastIndexOf(',');
	nPPos = cBedrag.lastIndexOf('.');
	nPos = Math.max(nKPos,nPPos);
	if (nPos < 0)
					{
					cGuld = cBedrag;
					cCent = "00";
					}
	else {
					cGuld = cBedrag.substring(0,nPos);
					cCent = cBedrag.substring(nPos + 1,nPos + 3);
					while (cCent.length < 2) cCent+= "0";
					while (true)
									{
									nPos = eIndexOf(cGuld,',');
									if (nPos < 0) break;
									cGuld = cGuld.substring(0,nPos) + cGuld.substring(nPos + 1,cGuld.length);
									}
					while (true)
									{
									nPos = eIndexOf(cGuld,'.');
									if (nPos < 0) break;
									cGuld = cGuld.substring(0,nPos) + cGuld.substring(nPos + 1,cGuld.length);
									}
	}
	cGuld = wegVNul(cGuld); 
	cBedrag = cGuld + "," + cCent
	if (isLeeg(cBedrag) && !isLeeg(cInBedrag)) cBedrag = "0";
	return(cBedrag);
}

function expDecimaal(cInBedrag) {
        var nKPos,nPPos,nPos,cGuld,cCent;
        var cBedrag = rTrim(cInBedrag);
        while (((nPos = eIndexOf(cBedrag,'+')) > -1) || ((nPos = eIndexOf(cBedrag,' ')) > -1)) {
                cBedrag = cBedrag.substring(0,nPos) + cBedrag.substring(nPos + 1,cBedrag.length);
                }
        nKPos = cBedrag.lastIndexOf(',');
        nPPos = cBedrag.lastIndexOf('.');
        nPos = Math.max(nKPos,nPPos);
        if (nPos < 0) {
                cGuld = cBedrag;
                cCent = "";
                }
        else {
                cGuld = cBedrag.substring(0,nPos);
                cCent = cBedrag.substring(nPos + 1,cBedrag.length);
                while (true)
                        {
                        nPos = eIndexOf(cGuld,',');
                        if (nPos < 0) break;
                        cGuld = cGuld.substring(0,nPos) + cGuld.substring(nPos + 1,cGuld.length);
                        }
                while (true)
                        {
                        nPos = eIndexOf(cGuld,'.');
                        if (nPos < 0) break;
                        cGuld = cGuld.substring(0,nPos) + cGuld.substring(nPos + 1,cGuld.length);
                        }
        }
	cGuld = wegVNul(cGuld); 
	if (!isLeeg(cCent)) {
		cBedrag = cGuld + "," + cCent;
	}
	else {
		cBedrag = cGuld;
	}
	if (isLeeg(cBedrag) && !isLeeg(cInBedrag)) cBedrag = "0";
	return(cBedrag);
}

function rTrim(STRING){
	while(STRING.charAt((STRING.length -1))==" "){
		STRING = STRING.substring(0,STRING.length-1);
	}
	return STRING;
}

function eIndexOf(cVeld,cKarakter) {
	if (cVeld.length == 0 ) return -1;
	return (cVeld.indexOf(cKarakter));
}

function wegVNul(cTk) {
	while (cTk.charAt(0) == "0") cTk = cTk.substring(1,cTk.length);
	if (cTk.length == 0) cTk="0"
	return(cTk);
}

function invoervalideren(form)
{
   if ((form.webrelaties.cpvoornaam.value=="")||(form.webrelaties.contactpersoon.value=="")||(form.webrelaties.straat.value=="")||(form.webrelaties.huisnr.value=="")||(form.webrelaties.postcode.value=="")||(form.webrelaties.plaats.value=="")||(form.webrelaties.land.value=="")||(form.webrelaties.telefoon.value=="")||(form.weblogin.naam.value==""))
   {
      alert("Verplichte velden (•) zijn niet goed ingevuld");
  	  return false;
   }
}

function MM_reloadPage(init) {  //reloads the window if Nav4 resized
  if (init==true) with (navigator) {if ((appName=="Netscape")&&(parseInt(appVersion)==4)) {
    document.MM_pgW=innerWidth; document.MM_pgH=innerHeight; onresize=MM_reloadPage; }}
  else if (innerWidth!=document.MM_pgW || innerHeight!=document.MM_pgH) location.reload();
}
MM_reloadPage(true);
function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}

function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function Submitdoel(oForm,cDoel)  {
	oForm.curname.value=cDoel;
	oForm.submit()
}

function MM_nbGroup(event, grpName) { //v6.0
  var i,img,nbArr,args=MM_nbGroup.arguments;
  if (event == "init" && args.length > 2) {
    if ((img = MM_findObj(args[2])) != null && !img.MM_init) {
      img.MM_init = true; img.MM_up = args[3]; img.MM_dn = img.src;
      if ((nbArr = document[grpName]) == null) nbArr = document[grpName] = new Array();
      nbArr[nbArr.length] = img;
      for (i=4; i < args.length-1; i+=2) if ((img = MM_findObj(args[i])) != null) {
        if (!img.MM_up) img.MM_up = img.src;
        img.src = img.MM_dn = args[i+1];
        nbArr[nbArr.length] = img;
    } }
  } else if (event == "over") {
    document.MM_nbOver = nbArr = new Array();
    for (i=1; i < args.length-1; i+=3) if ((img = MM_findObj(args[i])) != null) {
      if (!img.MM_up) img.MM_up = img.src;
      img.src = (img.MM_dn && args[i+2]) ? args[i+2] : ((args[i+1])? args[i+1] : img.MM_up);
      nbArr[nbArr.length] = img;
    }
  } else if (event == "out" ) {
    for (i=0; i < document.MM_nbOver.length; i++) {
      img = document.MM_nbOver[i]; img.src = (img.MM_dn) ? img.MM_dn : img.MM_up; }
  } else if (event == "down") {
    nbArr = document[grpName];
    if (nbArr)
      for (i=0; i < nbArr.length; i++) { img=nbArr[i]; img.src = img.MM_up; img.MM_dn = 0; }
    document[grpName] = nbArr = new Array();
    for (i=2; i < args.length-1; i+=2) if ((img = MM_findObj(args[i])) != null) {
      if (!img.MM_up) img.MM_up = img.src;
      img.src = img.MM_dn = (args[i+1])? args[i+1] : img.MM_up;
      nbArr[nbArr.length] = img;
  } }
}

function transferCSV(cId,cFilename){
	//alert('transferCSV');
	var r  = 0;
	var numofRows = document.getElementById(cId).rows.length-1;
	var rowcsv= [numofRows];
	for (r == 0; r <= numofRows; r++) {
		var numofCells =  document.getElementById(cId).rows[r].cells.length-1
		var c =0;
		tempdata = "";
		for (c == 0; c<=numofCells; c++) {
			var text = getInnerText(document.getElementById(cId).rows[r].cells[c])
			text = text.fulltrim();
			// Als er een slash '/' in de tekst staat, dan bestaat het gevaar dat excel dit als een datum gaat zien
			// 6/16 wordt dat 16-jun. Om dit voorkomen moet er een ' (= %27) voorgezet worden. Staat niet echt fraai, maar het kan niet anders...
			if (text.indexOf("/")>0) text = "%27" + text;
			//text = encodeURIComponent(text);
			// Komma's in nummerieke velden zijn decimaal scheidingstekens, laten staan!
			// text = text.replace(/,/g,"");
			if (c != numofCells) {
				tempdata+= text + "~";
				}else{
				tempdata+= text + "<br />";
			}
		}
		rowcsv[r] = tempdata
	}
	var rowcnt = 0;
	var c = "";
	for (rowcnt == 0; rowcnt<= rowcsv.length-1; rowcnt++){
		c+=rowcsv[rowcnt];
	}
	//alert(c);
	//PopUp = window.open(curl,'','');
	var keys = [1];
	var values = [1]
	keys[0] = "file";
	values[0] = cFilename+'.csv';
	keys[1] = "csv";
	values[1] = c;
	PopUp = openWindowWithPost(curl,'',keys,values);
}
function openWindowWithPost(url,name,keys,values){
	var newWindow = window.open('', name);
	if (!newWindow) return false;
	var html = "";
	html += "<html><head></head><body><form id='formid' method='post' target='_blank' action='" + url + "'>";
	if (keys && values && (keys.length == values.length))
	for (var i=0; i < keys.length; i++)
	html += "<input type='hidden' name='" + keys[i] + "' value='" + values[i] + "'/>";
	html += "</form><script type=\"text/javascript\">document.getElementById(\"formid\").submit();window.close();</script></body></html>";
	newWindow.document.write(html);
	return newWindow;
}
String.prototype.fulltrim = function() {
// verwijderd spaties, tabs en return aan begin en eind van de string.
// vervangt spaties, tabs en returns in de string door een spatie (ook &nbsp;)
return this.replace(/&nbsp;/gi," ").replace(/(?:(?:^|\n)\s+|\s+(?:$|\n))/g,"").replace(/\s+/g," ");
}
function getInnerText(elt) {
	var _innerText = elt.innerText;
	if (_innerText == undefined) {
  		_innerText = elt.innerHTML.replace(/<[^>]+>/g,"");
	}
	return _innerText;
}
function FreezeScreen() {
	scroll(0,0);
	var outerPane = document.getElementById('FreezePane');
	var innerPane = document.getElementById('InnerFreezePane');
	if (outerPane) outerPane.className = 'FreezePaneOn';
	if (innerPane) innerPane.innerHTML = 'Processing...';
}
$(document).ready(function() { 
	$("#main").submit(function() {
		isdirty = false ;
		FreezeScreen();
		return true;
	});
});