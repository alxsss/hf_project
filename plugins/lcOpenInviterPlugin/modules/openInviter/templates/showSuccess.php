<style>
body {
font-size:11px;
text-align:left;
}
#address_book{margin:10px 0 20px;}
.contacts_header{border-right:1px solid #c0c0c0;background:#ededed;}
.contacts_header a{color:gray;}
.contacts_wrapper{margin:0px auto;border:1px solid #c0c0c0;background:#ffffff;}
.contacts_header td, .contacts_wrapper td{margin-top:0px;padding:2px;}
.contacts_wrapper table{width:488px;}
.contacts_wrapper tr.row1{background:#f5f5f5;}
.contacts_wrapper td.name:hover,
.contacts_wrapper td.email:hover{cursor:pointer;cursor:hand;}
.contacts_wrapper td.checkbox{width:20px;}
#address_book_selector h2{margin-bottom:5px;}
#address_book_selector .buttons{margin:10px 0;width:200px;}
#address_book_selector .buttons .aux{background:#F0F0F0;border-color:#E7E7E7 #666 #666 #e7e7e7;color:#000;}
#address_book_selector .buttons input{float:left;margin-right:10px;}
</style>
<?php use_helper('I18N')?>
<?php
$str=''; 
  //print the addressbook 
  $str.= "<table cellspacing='0' cellpadding='0' border='0' class='contacts_list' id='email_contacts_list'>";
  foreach ($contacts as $email=>$name) 
  {
	$rep 		  = array("<br>","&nbsp;");
	$str.="<tr><td class='checkbox'>
    <input type='checkbox' value='' name='contacts' id='contacts' class='inputcheckbox'/></td>
    <td class='name'>".$name."</td><td class='email'>".$email."</td></tr>";
	$email = str_replace($rep, "",$email);
	$name  = str_replace($rep, "",$name);
  }
  $str.= "</table>";
?>
<div id="address_book">
  <h3><?php echo  __('Your Contacts')?></h3>
  <div class="instructions"><?php echo  __('Select which contacts to invite from the list below')?> </div>
  <div id="email_contacts_container" class="contacts_wrapper">
    <div class="contacts_header" id="email_contacts_header">
      <table cellspacing="0" cellpadding="0" border="0">
      <tbody>
      <tr>
        <td class="checkbox">
          <input type="checkbox" value="" name="contacts" id="toggle_all_checkbox" onclick="toggle_all(true);" class="inputcheckbox"/>
        </td>
        <td>
          <a onclick="toggle_all(); return false;">
         <?php echo  __('Select/Unselect All')?></a>
       </td>
      </tr>
      </tbody>
      </table>
     </div>
     <div class="contacts_wrapper" id="email_contacts_wrapper">
        <?php echo $str;?>
     </div>
</div>

<div class="buttons"><input type="button" value="<?php echo  __('Add')?>" name="save" id="save" onclick="add_contacts('sfApplyInviteFriend_recepient_email')" class="inputbutton"/><input type="button" value="<?php echo  __('Cancel')?>" name="cancel" id="cancel" onclick="window.close()" class="inputbutton inputsubmit inputaux"/>
<script type="text/javascript">
function add_contacts(recepients)
{
  //list=ge('email_contacts_list');
  list=document.getElementById('email_contacts_list');
  var separator=', ';
  var obj=implode_recepients(list,separator);
  var str=obj[0]; 
  var count=obj[1];
  var w=window.opener; 
  if(w)
  {
    d=w.document;
	
	if(d)
    {
	 
      var emails_element=d.getElementById(recepients);
	  if(emails_element)
	  {
	    var existing_content=emails_element.value;
		if(existing_content)
		{
		  str+=separator+existing_content;
		}
        emails_element.value=str;
	  }
     }
	 
     w.focus();
	 window.close();
  }
}

function implode_recepients(list,separator)
{
  var str='';
  var count=0;
  var rows=list.getElementsByTagName('tr');
  for(var i=0;i<rows.length;i++)
  {
    var inputs=rows[i].getElementsByTagName('input');
	if(inputs.length)
	{
	  if(inputs[0].checked)
	  {
	    count++;
		var sn=rows[i].getAttribute('screenname');
	    if(sn)
	    {
	      str+=sn;
	    }
	    else
	    {
	      var tds=rows[i].getElementsByTagName('td');
		  //str+=tds[1].innerHTML;
		  if(tds[2])
          str+=tds[2].innerHTML.replace('&lt;','<').replace('&gt;','>');
	    }
        str+=separator;
	  }
    }
  }
  if(str)
  {
    str=str.substr(0,str.length-separator.length);
  }
  return[str,count];
}
function toggle_all(clicked)
{
  _toggle_all(clicked,'toggle_all_checkbox','address_book');
  return false;
}
function _toggle_all(clicked,master_str,chooser_str)
{
  var master=document.getElementById(master_str);
  if(clicked)
  {
    i=1;
	var new_value=master.checked;
  }
  else
  {
    i=0;
	var new_value=!master.checked;
  }
  var chooser=document.getElementById(chooser_str);
  var all_inputs=chooser.getElementsByTagName('input');
  for(i=0;i<all_inputs.length;i++)
  {
    if(all_inputs[i].type=='checkbox')
	{
	  all_inputs[i].checked=new_value;
	}
  }
  return false;
}
</script>
