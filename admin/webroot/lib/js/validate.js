//created by Matt Curinga
//modified 7/16/1999
//modified 8/3/1999 by matt curinga
//--- added match variable to match 2 (or more) form elements
//modified 9/24/1999
//--- added requirement checking for radio,selects,checkboxes
//--- added legal check type to block illegal chars in a text string

function isSSN(ssn)
{
	if (ssn.length==0)
		return true;
	ssn=ssn.replace(/-/g,"");
	ssn=ssn.replace(/\s/g,"");
	ssn=ssn.replace(/\//g,"");
	if(ssn.length != 9 || !isInt(ssn)) 
		return false;
	return true;
}

function isEmail(e)
{
	if (e.length==0)
		return true;
	if(e.indexOf('@') == -1)
		return false;
	if(e.indexOf(' ') != -1)
		return false;
	return true;
}

function isURL(u)
{
	if (u.length==0)
		return true;
	if(u.substring(0,7) != 'http://')
		return false;
	if(u.indexOf(' ') != -1)
		return false;
	return true;
}

function isTime(t)
{
	c = t.indexOf(":");
	if(t.indexOf(" ")!=-1||c==-1||t.indexOf("-")!=-1)return false;
	hrs=t.substring(0,c);
	mins=t.slice(c+1);
	if(!isInt(hrs)||!isInRange(hrs,0,23)||hrs.lenght>2||mins.length>2||!isInt(mins)||!isInRange(mins,0,59))
		return false;
	return true;
}

function isInt(n)
{
	if(n.indexOf(' ')!=-1)
		return false;
	if(isNaN(n))
		return false;
	if(n.indexOf('.')!=-1)
		return false;
	return true;
}
function isFloat(n)
{
	if(n.indexOf(' ')!=-1)
		return false;
	if(isNaN(n))
		return false;
	return true;
}

function isInRange(n,mn,mx)
{
	if(n<mn||n>mx)
		return false;
	return true;
}

function isMoney(m)
{
	if(m.length==0)
		return true;
	if(m.indexOf(' ')!=-1)
		return false;
	if(m.indexOf('$')!=-1&&m.indexOf('$')!=0)
		return false;
	m=m.replace(/,/g,'');
	m=m.replace(/\$/,'');
	if(isNaN(m))
		return false;
	return true;
}

function isDate(d)
{
	if (d.length==0)
		return true;
	m=d.indexOf('/');
	if(m==-1)
		return false;
	y=d.indexOf('/',(m+1));
	if(y==-1)
		return false;
	month=d.substring(0,(m));
	day=d.substring((m+1),(y));
	year=d.substr(y+1);
	d30='4,6,9,11';
	d30=d30.split(",");
	d31='1,3,5,7,8,10,12';
	d31=d31.split(",");
	if(!isInt(day))
		return false;
	if(!isInt(month))
		return false;
	if(!isInt(year))
		return false;
	if(day<1)
		return false;
	if(month<1||month>12)
		return false;
	//check months with 30 days
	for(q=0;q<d30.length;q++)
	{
		if(d30[q]==month)
		{
			if(day>30)
				return false;
		}
	}
	//check months with 31 days
	for(q=0;q<d31.length;q++)
	{
		if(d31[q]==month)
		{
			if(day>31)
				return false;
		}
	}
	//check January
	if(month==2&&year%4!=0&&(day>28))
		return false;	
	if(month==2&&year%4==0&&(day>29))
		return false;
	if(year.length!=4)
		return false;
	if(year<1753)
	{
		//sql server requirement
		alert('You cannot enter dates before Jan 1, 1753');
		return false;
	}
	return true;
}

function isEmpty(a)
{
	a=a.replace(/ /g,'');
	if(a.length==0)
		return true;
	return false;	
}

function isChecked(f,v)
{
	for(x=0;x<f.elements.length;x++)
	{
		if(f.elements[x].name==v.name&&f.elements[x].checked)
			return true;
	}
	return false;
			
}
function isSelected(v,ind)
{
	//ind is the min index that must be selected
	//it's -1 for multi select and 0 for single selects
	if(v.selectedIndex>ind)
		return true;
	return false;		
}
function makeLegal(source)
{
	var c;
	//if user defines the chars use them, otherwise use the standard set
	illegalChars=(source.illChars)?source.illChars:' \\/@#$%<>:?|^&*()\"\'!';
	var illegal_char_exists = false;
	var legal_string = '';
	for (c = 0; c < source.value.length; c++)
	{
		curr_char = source.value.substr(c, 1);
		if (illegalChars.indexOf(curr_char) > -1)
		{
			legal_string += '_';
			illegal_char_exists = true;
		}
		else 
		{
			legal_string += curr_char;
		}
	}
	if (illegal_char_exists)
	{
		source.value = legal_string;
		alert('One or more illegal characters (' + illegalChars + ') has been detected and replaced.');
	}
}
function isLegal(v)
{
	var c=null;
	//if user defines the chars use them, otherwise use the standard set
	illegalChars=(v.illChars)?v.illChars:' \\/@#$%^&*()\"\'!';
	//loop through string to check against set of illegal chars, one char at a time
	for (c = 0; c < v.value.length; c++)
	{
		curr_char = v.value.substr(i, 1);
		if (illegalChars.indexOf(curr_char) != -1)
			return false;
	}
	return true;
}

//******************* FUNCTION TO LOOP THROUGH FORM *********************
function checkAll(f)
{//begin function
	msg='';
	for(i=0;i<f.elements.length;i++)
	{//begin loop through form elements
		v = f.elements[i];
		
		//if validating radio or checkbox
		if(v.type=='radio'||v.type=='checkbox')
		{
			if(v.req&&!isChecked(f,v))
				msg+='--- '+v.msg+'\n';
		}
		//if validating a single select
		else if(v.type=='select-one')
		{
			if(v.req&&!isSelected(v,0))
				msg+='--- '+v.msg+'\n';			
		}
		//if validating a multi select
		else if(v.type=='select-multiple')
		{
			if(v.req&&!isSelected(v,-1))
				msg+='--- '+v.msg+'\n';			
		}
		//if validating any other type of form element (text,ta,password,file)
		else
		{
			if(v.check=='legal'&&(v.length!=0))//validate that uses legal characters
				makeLegal(v);
			if(v.match && v.value!=v.match.value)//validate matching values
				msg+='--- '+v.msg+'\n';
			if(v.req==1&&isEmpty(v.value))//check required
				msg+='--- '+v.msg+'\n';
			if(v.check=='ssn'&&!isSSN(v.value))//check ssn
				msg+='--- '+v.msg+'\n';
			if(v.check=='email'&&!isEmail(v.value))//check email
				msg+='--- '+v.msg+'\n';
			if(v.check=='url'&&!isURL(v.value))//check ssn
				msg+='--- '+v.msg+'\n';
			if(v.check=='date'&&!isDate(v.value))//check dates
				msg+='--- '+v.msg+'\n';
			if(v.check=="time"&&(!isTime(v.value)&&v.value.length>0))//check times
				msg+='--- '+v.msg+'\n';
			if(v.check=='money'&&!isMoney(v.value))//check money
				msg+='--- '+v.msg+'\n';
			if(v.check=='int'&&(v.value.length!=0&&(!isInt(v.value)||!isInRange(v.value,v.mn,v.mx))))//check ints
				msg+='--- '+v.msg+'\n';
			if(v.check=='float'&&(v.value.length!=0&&(!isFloat(v.value)||!isInRange(v.value,v.mn,v.mx))))//check floats
				msg+='--- '+v.msg+'\n';
		}
	}//end loop through form elements
	if(msg.length>0)
	{
		alert('The form was not submitted because:\n'+msg);
		return false;
	}
	return true;
}//end checkAll

function confirmChange()
{
	if(hasChanged)
			if(confirm('Leave this form without saving changes?'))
				return false;
}
//copyright 1999 Real Network Solutions, LLC
