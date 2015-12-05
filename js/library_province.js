/**
 * @author Christian Rizza
 * www.crizza.com
 * email: christian@crizza.com
 */

function Province()
{
	this.province=new Array();
	this.sigle=new Array();
	
	this.getList=getList;
	this.getHtmlList=getHtmlList;
	
	this.getList();
}
function getHtmlList(container,selected)
{
	var str="<option>Seleziona...</option>";
	for (i=0;i<this.province.length;i++)
	{
		if (this.sigle[i]==selected)
			str+="<option value=\""+this.sigle[i]+"\" selected>"+this.province[i]+"</option>";
		else
			str+="<option value=\""+this.sigle[i]+"\">"+this.province[i]+"</option>";
	}
	document.getElementById(container).innerHTML=str;
}
function getList()
{
	this.sigle.push("AG"); this.province.push("AGRIGENTO");
	this.sigle.push("AL"); this.province.push("ALESSANDRIA");
	this.sigle.push("AN"); this.province.push("ANCONA");
	this.sigle.push("AO"); this.province.push("AOSTA");
	this.sigle.push("AR"); this.province.push("AREZZO");
	this.sigle.push("AP"); this.province.push("ASCOLI PICENO");
	this.sigle.push("AT"); this.province.push("ASTI");
	this.sigle.push("AV"); this.province.push("AVELLINO");
	this.sigle.push("BA"); this.province.push("BARI");
	this.sigle.push("BL"); this.province.push("BELLUNO");
	this.sigle.push("BN"); this.province.push("BENEVENTO");
	this.sigle.push("BG"); this.province.push("BERGAMO");
	this.sigle.push("BI"); this.province.push("BIELLA");
	this.sigle.push("BO"); this.province.push("BOLOGNA");
	this.sigle.push("BZ"); this.province.push("BOLZANO");
	this.sigle.push("BS"); this.province.push("BRESCIA");
	this.sigle.push("BR"); this.province.push("BRINDISI");
	this.sigle.push("CA"); this.province.push("CAGLIARI");
	this.sigle.push("CL"); this.province.push("CALTANISSETTA");
	this.sigle.push("CB"); this.province.push("CAMPOBASSO");
	this.sigle.push("CE"); this.province.push("CASERTA");
	this.sigle.push("CT"); this.province.push("CATANIA");
	this.sigle.push("CZ"); this.province.push("CATANZARO");
	this.sigle.push("CH"); this.province.push("CHIETI");
	this.sigle.push("CO"); this.province.push("COMO");
	this.sigle.push("CS"); this.province.push("COSENZA");
	this.sigle.push("CR"); this.province.push("CREMONA");
	this.sigle.push("KR"); this.province.push("CROTONE");
	this.sigle.push("CN"); this.province.push("CUNEO");
	this.sigle.push("EN"); this.province.push("ENNA");
	this.sigle.push("FE"); this.province.push("FERRARA");
	this.sigle.push("FI"); this.province.push("FIRENZE");
	this.sigle.push("FG"); this.province.push("FOGGIA");
	this.sigle.push("FC"); this.province.push("FORLI'-CESENA");
	this.sigle.push("FR"); this.province.push("FROSINONE");
	this.sigle.push("GE"); this.province.push("GENOVA");
	this.sigle.push("GO"); this.province.push("GORIZIA");
	this.sigle.push("GR"); this.province.push("GROSSETO");
	this.sigle.push("IM"); this.province.push("IMPERIA");
	this.sigle.push("IS"); this.province.push("ISERNIA");
	this.sigle.push("SP"); this.province.push("LA SPEZIA");
	this.sigle.push("AQ"); this.province.push("L'AQUILA");
	this.sigle.push("LT"); this.province.push("LATINA");
	this.sigle.push("LE"); this.province.push("LECCE");
	this.sigle.push("LC"); this.province.push("LECCO");
	this.sigle.push("LI"); this.province.push("LIVORNO");
	this.sigle.push("LO"); this.province.push("LODI");
	this.sigle.push("LU"); this.province.push("LUCCA");
	this.sigle.push("MC"); this.province.push("MACERATA");
	this.sigle.push("MN"); this.province.push("MANTOVA");
	this.sigle.push("MS"); this.province.push("MASSA-CARRARA");
	this.sigle.push("MT"); this.province.push("MATERA");
	this.sigle.push("ME"); this.province.push("MESSINA");
	this.sigle.push("MI"); this.province.push("MILANO");
	this.sigle.push("MO"); this.province.push("MODENA");
	this.sigle.push("NA"); this.province.push("NAPOLI");
	this.sigle.push("NO"); this.province.push("NOVARA");
	this.sigle.push("NU"); this.province.push("NUORO");
	this.sigle.push("OR"); this.province.push("ORISTANO");
	this.sigle.push("PD"); this.province.push("PADOVA");
	this.sigle.push("PA"); this.province.push("PALERMO");
	this.sigle.push("PR"); this.province.push("PARMA");
	this.sigle.push("PV"); this.province.push("PAVIA");
	this.sigle.push("PG"); this.province.push("PERUGIA");
	this.sigle.push("PU"); this.province.push("PESARO E URBINO");
	this.sigle.push("PE"); this.province.push("PESCARA");
	this.sigle.push("PC"); this.province.push("PIACENZA");
	this.sigle.push("PI"); this.province.push("PISA");
	this.sigle.push("PT"); this.province.push("PISTOIA");
	this.sigle.push("PN"); this.province.push("PORDENONE");
	this.sigle.push("PZ"); this.province.push("POTENZA");
	this.sigle.push("PO"); this.province.push("PRATO");
	this.sigle.push("RG"); this.province.push("RAGUSA");
	this.sigle.push("RA"); this.province.push("RAVENNA");
	this.sigle.push("RC"); this.province.push("REGGIO DI CALABRIA");
	this.sigle.push("RE"); this.province.push("REGGIO NELL'EMILIA");
	this.sigle.push("RI"); this.province.push("RIETI");
	this.sigle.push("RN"); this.province.push("RIMINI");
	this.sigle.push("RM"); this.province.push("ROMA");
	this.sigle.push("RO"); this.province.push("ROVIGO");
	this.sigle.push("SA"); this.province.push("SALERNO");
	this.sigle.push("SS"); this.province.push("SASSARI");
	this.sigle.push("SV"); this.province.push("SAVONA");
	this.sigle.push("SI"); this.province.push("SIENA");
	this.sigle.push("SR"); this.province.push("SIRACUSA");
	this.sigle.push("SO"); this.province.push("SONDRIO");
	this.sigle.push("TA"); this.province.push("TARANTO");
	this.sigle.push("TE"); this.province.push("TERAMO");
	this.sigle.push("TR"); this.province.push("TERNI");
	this.sigle.push("TO"); this.province.push("TORINO");
	this.sigle.push("TP"); this.province.push("TRAPANI");
	this.sigle.push("TN"); this.province.push("TRENTO");
	this.sigle.push("TV"); this.province.push("TREVISO");
	this.sigle.push("TS"); this.province.push("TRIESTE");
	this.sigle.push("UD"); this.province.push("UDINE");
	this.sigle.push("VA"); this.province.push("VARESE");
	this.sigle.push("VE"); this.province.push("VENEZIA");
	this.sigle.push("VB"); this.province.push("VERBANO-CUSIO-OSSOLA");
	this.sigle.push("VC"); this.province.push("VERCELLI");
	this.sigle.push("VR"); this.province.push("VERONA");
	this.sigle.push("VV"); this.province.push("VIBO VALENTIA");
	this.sigle.push("VI"); this.province.push("VICENZA");
	this.sigle.push("VT"); this.province.push("VITERBO");
}