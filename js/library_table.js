/**
 * @author Christian Rizza
 * www.crizza.com
 * email: christian@crizza.com
 */

//OBJ TABLE
function Table(id, container)
{
	this.id=id;
	this.container=container;
	this.colonne=new Array();
	
	//Methods
	this.drawTable=drawTable;
	this.removeRow=removeRow;
}
function removeRow(row)
{
	for (i=0;i<this.colonne.length;i++)
	{
		this.colonne[i].remVal(row);
	}
	this.drawTable(true);
	$( "button" ).button();
}
function drawTable(edit)
{	
	str="<table id=\""+this.id+"\" class=\"ui-widget ui-widget-content\">";
	str+="<thead>";
	str+="<tr class=\"ui-widget-header\">";
	
	for (i=0;i<this.colonne.length;i++)
	{
		str+="<th style=\"text-align: center;\" >"+this.colonne[i].name+"</th>";
	}

	if (edit) str+="<th style=\"text-align: center\">Elimina</th>";
	
	str+="</tr>";
	str+="</thead>";
	str+="<tbody>";
	
	for (i=0;i<this.colonne[0].length;i++)
	{
		str+="<tr>";
		for (j=0;j<this.colonne.length;j++)
		{
			str+="<td id=\""+i+"#"+j+"\" style=\"text-align: center;\" >";
			str+=this.colonne[j].getVal(i);
			str+="</td>";
		}
		if (edit) str+="<td style=\"text-align: center\"><button onclick=\""+this.id+".removeRow("+i+");\">Elimina</button></td>";
		str+="</tr>";
	}
	str+="</tbody>";
	str+="</table>";
	
	document.getElementById(this.container).innerHTML=str;
}

//OBJ COLUMN
function Column(name)
{
	this.name=name;
	this.length=0;
	this.rows=new Array();
	
	this.addVal=addVal;
	this.setVal=setVal;
	this.getVal=getVal;
	this.remVal=remVal;
}
function addVal(val)
{
	this.rows.push(val);
	this.length++;
}
function setVal(val, index)
{
	this.rows[parseInt(index)]=val;
}
function getVal(j)
{
	return this.rows[j];
}
function remVal(row)
{	
	var temp=new Array();
	
	for (k=0;k<this.length;k++)
	{			
		if (k!=row)
		{
			temp.push(this.rows[k]);
		}
	}
		
	this.rows=temp;
	this.length = temp.length;
}