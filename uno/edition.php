<!DOCTYPE html>
<?php
if (!isset($_SESSION['cmsuno'])) exit();
?>
<?php
$user=0; $pass=0; // reset
function f_archive()
	{
	// liste des archives dans un select
	$d = "uno/data/";
	$g = glob($d."*.gz");
	if ($g)
		{
		echo '<select>';
		foreach ($g as $r) { echo '<option value="'.$r.'">'.$r.'</option>'; }
		echo '</select>';
		}
	else return false;
	}
?>

<html>
<head>
	<meta charset="utf-8">
	<title>CMS Uno</title>
	<link rel="stylesheet" href="uno/css/uno.css">
	<script type="text/javascript" src="uno/js/jquery-1.7.2.min.js"></script>
	<script type="text/javascript" src="uno/js/jquery-ui.min.js"></script>
	<script type="text/javascript" src="uno/js/ckeditor/ckeditor.js"></script>
	<script type="text/javascript" src="uno/elfinder/js/elfinder.min.js"></script>
	<script type="text/javascript" src="uno/elfinder/js/i18n/elfinder.<?php echo $lang;?>.js"></script>
	<link rel="stylesheet" type="text/css" media="screen" href="uno/css/jquery-ui.css" />
	<link rel="stylesheet" type="text/css" media="screen" href="uno/elfinder/css/elfinder.min.css">
	<script type="text/javascript">
		var p=0,dg=0,sty=0,plug='',plugon=0,unox='<?php echo $unox; ?>',pt=[],pd=[],pm=[],plugact=[];configFile=[],lang='<?php echo $lang; ?>';
  	</script>
</head>
<body>
	<div class="blocTop bgNoir">
		<div class="container">
			<span class="titre" href="/">CMS Uno</span>
			<div id="info"></div>
			<ul>
				<li><a id="apage" style="text-decoration:underline" href=""><?php echo _("Page");?></a></li>
				<li><a id="aconfig" onClick="f_config();" href="javascript:void(0)"><?php echo _("Settings");?></a></li>
				<li><a id="aplugin" onClick="f_plugin(0);" href="javascript:void(0)"><?php echo _("Plugins");?></a></li>
				<li><a id="avoir" href="index.html" target="_blank"><?php echo _("See the website");?></a></li>
				<li><a id="alogout" onClick="f_logout();" href="javascript:void(0)"><?php echo _("Log out");?></a></li>
			</ul>
		</div>
	</div><!-- .blocTop-->

	<div id="pages" class="container">
		<div class="blocBouton">
			<div class="bouton fr" id="boutonFinder" onClick="f_elfinder(this)" title="<?php echo _("File manager");?>"><?php echo _("File Manager");?></div>
			<div id="menu"></div>
		</div>
		<div id="finderDiv"></div>
		<div>
			<div class="input" id="contentP">
				<textarea name="content" id="content"></textarea>
			</div>
		</div>
		<div class="blocBouton" style="text-align:right;">
			<div class="bouton fl" onClick="f_supp_page();" title="<?php echo _("Remove this page and title");?>"><?php echo _("Delete Page");?></div>
			<span class="blocInput fl">
				<label class="label"><?php echo _("Page title");?>&nbsp;:</label>
				<input type="text" name="titre" class="input" style="" />
			</span>
			<div class="bouton" onClick="f_nouv_page();" title="<?php echo _("Inserts a page after this one. Have you saved ?");?>"><?php echo _("New page");?></div>
			<div class="bouton" id="boutonSauv" onClick="f_sauve_page();" title="<?php echo _("Save this page and title");?>"><?php echo _("Save Page");?></div>
			<div class="bouton" id="boutonPub" onClick="f_publier();" title="<?php echo _("Publish on the web all saved pages");?>"><?php echo _("Publish");?></div>
		</div>
	</div><!-- .container -->
	<div id="config" class="container" style="display:none;">
		<div class="blocForm">
			<div class="bouton fr" onClick="f_publier();" title="<?php echo _("Publish on the web all saved pages");?>"><?php echo _("Publish");?></div>
			<h2><?php 
			echo _("My Card"); ?></h2>
			<table class="hForm">
				<tr>
					<td><label><?php echo _("Site Title");?></label></td>
					<td><input type="text" class="input" name="tit" id="tit" onkeyup="f_ctit(this);" /><span id="ctit"></span></td>
					<td><em><?php echo _("Very important. The most important words at the beginning. 65 characters max.");?></em></td>
				</tr><tr>
					<td><label><?php echo _("Site Description");?></label></td>
					<td><input type="text" class="input" name="desc" id="desc" onkeyup="f_cdesc(this);" /><span id="cdesc"></span></td>
					<td><em><?php echo _("Important for attracting visitors. 156 characters max.");?></em></td>
				</tr><tr>
					<td><label><?php echo _("Filename");?></label></td>
					<td><input type="text" class="input" style="text-align:right;width:120px;" name="nom" id="nom" />.html</td>
					<td><em><?php echo _("Created file will be index.html by default.");?></em></td>
				</tr>
			</table>
			<h2><?php echo _("Options");?></h2>
			<table class="hForm">
				<tr>
					<td><label><?php echo _("LazyLoad");?></label></td>
					<td><input type="checkbox" class="input" name="lazy" id="lazy" /></td>
					<td><em><?php echo _("Dynamic images loading (recommended)");?></em></td>
				</tr><tr>
					<td><label><?php echo _("Load JQuery");?></label></td>
					<td><input type="checkbox" class="input" name="jq" id="jq" /></td>
					<td><em><?php echo _("Javascript library useful for some plugins. (not recommended if not required)");?></em></td>
				</tr><tr>
					<td><label><?php echo _("CSS template");?></label></td>
					<td><input type="checkbox" class="input" name="sty" id="sty" /></td>
					<td><em><?php echo _("Same styles in the editor and page. Ref");?> : <span style='font-weight:700'>style.css</span> <?php echo _("or");?> <span style='font-weight:700'>styles.css</span> <?php echo _("in");?> <span style='font-weight:700'>template/</span> <?php echo _("or");?> <span style='font-weight:700'>template/css/</span>.</em></td>
				</tr><tr>
					<td><label><?php echo _("Width page");?> (px)</label></td>
					<td><input type="text" class="input" name="edw" id="edw" style="width:50px;" maxlength="4" onkeypress="return f_nombre(event)"/></td>
					<td><em><?php echo _("Adapt the editor width with the observed width of the HTML page. (960 by default)");?></em></td>
				</tr>
			</table>
			<div class="bouton fr" id="boutonConfig" onClick="f_sauve_config();" title="<?php echo _("Saves settings");?>"><?php echo _("Save");?></div>
			<div class="clear"></div>
		</div>
		<div class="blocBouton">
			<div class="bouton fr" onClick="f_archivage();" title="<?php echo _("Save all the website");?>"><?php echo _("Make a backup");?></div>
			<div id="boutonRestaure" class="bouton fl" onClick="f_restaure(document.getElementById('archive').options[document.getElementById('archive').selectedIndex].value);" title="<?php echo _("Restore a backup (delete the current site)");?>"><?php echo _("Restore a backup");?></div>
			<div id="blocArchive"></div>
		</div>
		<div class="blocForm">
			<h2><?php echo _("Change User / Password / Language");?></h2>
			<table class="hForm">
				<tr>
					<td><label><?php echo _("Current user");?></label></td>
					<td><input type="text" class="input" name="user0" id="user0" /></td>
					<td></td>
				</tr>
				<tr>
					<td><label><?php echo _("Current password");?></label></td>
					<td><input type="password" class="input" name="pass0" id="pass0" /></td>
					<td></td>
				</tr>
				<tr>
					<td><label><?php echo _("User");?></label></td>
					<td><input type="text" class="input" name="user" id="user" /></td>
					<td><em><?php echo _("Enter a nickname. Avoid words that are too simple (admin, user ...)");?></em></td>
				</tr>
				<tr>
					<td><label><?php echo _("Password");?></label></td>
					<td><input type="password" class="input" name="pass" id="pass" /></td>
					<td><em><?php echo _("Very important for the safety of the site. Use lowercase, uppercase and digit.");?></em></td>
				</tr>
				<tr>
					<td><label><?php echo _("Password");?></label></td>
					<td><input type="password" class="input" name="pass1" id="pass1" /></td>
					<td><em><?php echo _("Check. Re-enter the password.");?></em></td>
				</tr><tr>
					<td><label><?php echo _("Language");?></label></td>
					<td>
						<select name="lang" id="lang">
						<?php foreach($langCode as $k=>$r) { echo "<option value='".$k."' ".(($lang==$k)?'selected':'').">".$k."</option>"; } ?>
						</select>
					</td>
					<td><em><?php echo _("Language for the admin side of the site.");?></em></td>
				</tr>
			</table>
			<div class="bouton fr" id="boutonPass" onClick="f_sauve_pass();" title="<?php echo _("Save password");?>"><?php echo _("Save");?></div>
			<div class="clear"></div>
		</div>
	</div><!-- .container -->
	<div id="plugins" class="container" style="display:none;">
		<div class="blocBouton">
			<div class="bouton fr" onClick="f_publier();" title="<?php echo _("Publish on the web all saved pages");?>"><?php echo _("Publish");?></div>
			<div id="listPlugins" style="width:90%;"></div>
		</div>
		<div class="blocBouton">
			<div id="prePlugin" style="display:none;">
				<h1 id="nomPlug"></h1>
				<div>
					<input type="checkbox" class="input" onchange="f_onPlug(this)" id="onPlug" /><label></label>
				</div>
			</div>
		</div>
		<div id="plugin"></div>
	</div><!-- .container -->
<script type="text/javascript">
	function f_get_site(){a=document.getElementById('menu');jQuery(document).ready(function(){
	jQuery.ajax({type:"POST",url:'uno/central.php',data:{'action':'getSite','unox':unox},dataType:'json',async:false,success:function(r){
		if(p!=-1){
			jQuery("#menu").empty();
			if(p!=0){c=document.createElement("span");c.id="p0";c.className="parking";a.appendChild(c);}
			jQuery.each(r.pages,function(k,v){pt[k]=v.t;pd[k]=v.d;
				if(k==p)
					{
					b=document.createElement("span");b.className="bouton current off";b.title="d\351placez moi";jQuery(b).disableSelection();
					b.onmouseover=function(){f_drag(this);};
					b.innerHTML=v.t;a.appendChild(b);
					}
				else
					{
					b=document.createElement("a");b.href="javascript:void(0)";b.className="bouton";b.id="b"+k;b.onclick=function(){f_get_page(k);f_get_site();};b.innerHTML=v.t;a.appendChild(b);
					if(k!=p-1){c=document.createElement("span");c.id="p"+(k+1);c.className="parking";a.appendChild(c);}
					}
				});
			jQuery("input[name='titre']").val(pt[p]);
			document.getElementById('boutonSauv').className="bouton";
			dg=0;if(r.pub) document.getElementById('boutonPub').style.display="inline";
			if(r.edw)document.getElementById('contentP').style.width=r.edw+'px';
		}else{
			document.getElementById('tit').value=r.tit||'';
			document.getElementById('desc').value=r.desc||'';
			document.getElementById('nom').value=r.nom||'';
			document.getElementById('edw').value=r.edw||'';
			if(r.lazy==1)document.getElementById('lazy').checked=true;else document.getElementById('lazy').checked=false;
			if(r.jq==1)document.getElementById('jq').checked=true;else document.getElementById('jq').checked=false;
			if(r.sty==1)document.getElementById('sty').checked=true;else document.getElementById('sty').checked=false;
			}
		if(r.nom)document.getElementById('avoir').href=r.nom+'.html';
		if(sty!=r.sty){CKEDITOR.instances.content.destroy();if(r.sty==1) CKEDITOR.replace('content',{contentsCss:['uno/template/style.css','uno/template/styles.css','uno/template/css/style.css','uno/template/css/style.css']});else CKEDITOR.replace('content'); sty=r.sty;}
	}});});}
	function f_drag(f){ct=0;m=document.getElementById('menu');
		xi=f.offsetWidth/2; yi=f.offsetHeight/2;
		xm=m.getBoundingClientRect().left+window.document.documentElement.scrollLeft-m.ownerDocument.documentElement.clientLeft;
		ym=m.getBoundingClientRect().top+window.document.documentElement.scrollTop-m.ownerDocument.documentElement.clientTop;
		xn=xm+m.offsetWidth; yn=ym+m.offsetHeight;
		jQuery(f).mousedown(function(){jQuery(document).mousemove(function(e)
			{f.style.cursor="move";
			x=Math.min(Math.max(e.pageX,xm+xi-10),xn-xi+10)-xi;
			y=Math.min(Math.max(e.pageY,ym+yi),yn-yi)-yi;
			if(ct/5==Math.floor(ct/5)) jQuery(f).offset({top:y,left:x});ct++;
			});}).mouseup(function(){f.style.cursor="pointer";jQuery(document).unbind('mousemove');jQuery(f).hover(function(){f_collision(f);return;});});
		}
	function f_collision(f)
		{
		x1=f.getBoundingClientRect().left+window.document.documentElement.scrollLeft-f.ownerDocument.documentElement.clientLeft;
		y1=f.getBoundingClientRect().top+window.document.documentElement.scrollTop-f.ownerDocument.documentElement.clientTop;
		x2=x1+f.offsetWidth; y2=y1+f.offsetHeight;
		for(v=0;v<pt.length;v++)
			{
			if(q=document.getElementById('p'+v))
				{
				xp=q.getBoundingClientRect().left+window.document.documentElement.scrollLeft-q.ownerDocument.documentElement.clientLeft;
				yp=q.getBoundingClientRect().top+window.document.documentElement.scrollTop-q.ownerDocument.documentElement.clientTop;
				if(x1<xp&&x2>xp&&y1<yp+10&&y2>yp+10){f_sauve_place(v);return;}}}
		f_get_site();
		}
	function f_get_page(f){jQuery(document).ready(function(){p=f;jQuery.post('uno/central.php',{'action':'getPage','unox':unox,'data':pd[p]},function(r){CKEDITOR.instances['content'].setData(r);});});}
	function f_sauve_page(){jQuery(document).ready(function(){jQuery.post('uno/central.php',{
		'action':'sauvePage',
		'unox':unox,
		'page':p,
		'data':pd[p],
		'content':CKEDITOR.instances['content'].getData(),
		'titre':document.getElementsByName('titre')[0].value
		},function(r){f_get_site();f_alert(r);});});}
	function f_sauve_place(f){if(p!=f){if(f>p)f--;jQuery(document).ready(function(){jQuery.ajax({type:'POST',url:'uno/central.php',data:{
		'action':'sauvePlace',
		'unox':unox,
		'page':p,
		'place':f
		},async:false}).done(function(r){p=f;f_alert(r);f_get_site();});});}}
	function f_sauve_config(){var nom=document.getElementById('nom').value;jQuery(document).ready(function(){jQuery.post('uno/central.php',{
		'action':'sauveConfig',
		'unox':unox,
		'tit':document.getElementById('tit').value,
		'desc':document.getElementById('desc').value,
		'nom':nom,
		'lazy':document.getElementById('lazy').checked,
		'jq':document.getElementById('jq').checked,
		'sty':document.getElementById('sty').checked,
		'edw':document.getElementById('edw').value
		},function(r){f_alert(r);if(nom.length>0)document.getElementById('avoir').href=nom+'.html';});});}
	function f_sauve_pass(){if(document.getElementById('user0').value.length>0||document.getElementById('pass0').value.length>0||document.getElementById('user').value.length>0||document.getElementById('pass').value.length>0){if(document.getElementById('user0').value.length<1||document.getElementById('pass0').value.length<1){f_alert('!<?php echo _("Current elements are missing");?>');return;}if(document.getElementById('user').value.length<4){f_alert('!<?php echo _("Too short name");?>');return;}if(document.getElementById('pass').value!=document.getElementById('pass1').value){f_alert('!<?php echo _("Passwords are different");?>');return;}if(document.getElementById('pass').value.length<6){f_alert('!<?php echo _("Too short password");?>');return;}}
		jQuery(document).ready(function(){jQuery.post('uno/central.php',{
			'action':'sauvePass',
			'unox':unox,
			'user0':document.getElementById('user0').value,
			'pass0':document.getElementById('pass0').value,
			'user':document.getElementById('user').value,
			'pass':document.getElementById('pass').value,
			'lang':document.getElementById('lang').options[document.getElementById('lang').selectedIndex].value
		},function(r){f_alert(r);if(r.substr(0,1)!="!")setTimeout(function(){location.reload();},1000);});});}
	function f_nouv_page(){jQuery(document).ready(function(){jQuery.post('uno/central.php',{'action':'nouvPage','unox':unox,'page':p,'data':pd[p]},function(r){p++;f_get_site();f_get_page(p);f_alert(r);});});}
	function f_supp_page(){jQuery(document).ready(function(){jQuery.post('uno/central.php',{'action':'suppPage','unox':unox,'page':p,'data':pd[p]},function(r){if(p>0)p--;else p=0;f_get_site();f_get_page(p);f_alert(r);});});}
	function f_publier(){jQuery(document).ready(function(){jQuery.post('uno/central.php',{'action':'publier','unox':unox},function(r){document.getElementById('boutonPub').style.display="none";f_alert(r);});});}
	function f_archivage(){jQuery(document).ready(function(){jQuery.post('uno/central.php',{'action':'archivage','unox':unox,'nom':document.getElementById('nom').value},function(r){f_selectArchive();f_alert(r);});});}
	function f_restaure(f){jQuery(document).ready(function(){jQuery.post('uno/central.php',{'action':'restaure','unox':unox,'zip':f},function(r){f_alert(r);});});}
	function f_selectArchive(){jQuery(document).ready(function(){jQuery.post('uno/central.php',{'action':'selectArchive','unox':unox},function(r){if(r){document.getElementById('boutonRestaure').style.display="inline";document.getElementById('blocArchive').innerHTML=r;}else{document.getElementById('boutonRestaure').style.display="none";document.getElementById('blocArchive').innerHTML=''}});});}
	function f_logout(){a=document.getElementById('info');b=document.createElement("form");b.method="POST";b.action="";c=document.createElement("input");c.name="logout";c.type="hidden";c.value=1;b.appendChild(c);a.appendChild(b);b.submit();}
	function f_alert(f){
	//alert(f);
	a=document.getElementById('info');b=document.createElement("span");b.id="alert";if(f.substr(0,1)=="!"){b.style.color="red";f=f.substr(1);}b.innerHTML=f;a.appendChild(b);setTimeout(function(){jQuery("#alert").fadeOut("slow",function(){jQuery("#alert").remove();});jQuery("#info").empty();},2000);}
	function f_config(){document.getElementById('plugins').style.display="none";document.getElementById('apage').style.textDecoration='none';document.getElementById('aplugin').style.textDecoration='none';document.getElementById('aconfig').style.textDecoration='underline';p=-1;f_get_site();document.getElementById('pages').style.display="none";document.getElementById('config').style.display="block";f_selectArchive();}
	function f_page(){document.getElementById('plugins').style.display="none";document.getElementById('apage').style.textDecoration='underline';document.getElementById('aplugin').style.textDecoration='none';document.getElementById('aconfig').style.textDecoration='none';p=0;f_get_site();f_get_page(0);document.getElementById('config').style.display="none";document.getElementById('pages').style.display="block";}
	function f_plugins(){p=-1;a=document.getElementById('listPlugins');document.getElementById('config').style.display="none";document.getElementById('pages').style.display="none";document.getElementById('plugins').style.display="block";jQuery(document).ready(function(){
		jQuery.ajax({type:"POST",url:'uno/central.php',data:{'action':'plugins','unox':unox},dataType:'json',async:false,success:function(r){
			if(r)document.getElementById('prePlugin').style.display='block';
			jQuery(a).empty();jQuery.each(r,function(k,v){
				b=document.createElement("span");
				b.className="bouton";
				b.id="p"+v.substr(1);
				b.onclick=function(){f_plugin(v);};
				b.innerHTML=v.charAt(1).toUpperCase()+v.substr(2);
				if(k==0){b.className="bouton current off";plugon=v.substr(0,1);}a.appendChild(b); // plugon : etat premier plugin : actif (1) inactif (0)
			});
		}});});}
	function f_plugin(f){a=document.getElementById('listPlugins');if(f==0){f_plugins();document.getElementById('apage').style.textDecoration='none';document.getElementById('aplugin').style.textDecoration='underline';document.getElementById('aconfig').style.textDecoration='none';f=plugon+a.firstChild.id.substr(1);}d=a.childNodes;for(v=0;v<d.length;v++){if(d[v].id=="p"+f.substr(1))d[v].className="bouton current off";else d[v].className="bouton";}
		d=document.getElementById('onPlug');d.name=f.substr(1);if(f.substr(0,1)=="1"){d.checked=true;d.nextSibling.innerHTML='<?php echo _("Enable");?>';d.nextSibling.style.color='green';}else{d.checked=false;d.nextSibling.innerHTML='<?php echo _("Disable");?>';d.nextSibling.style.color='#f79f81';}document.getElementById('nomPlug').innerHTML='Plugin : '+f.substr(1);
		document.getElementById('plugin').innerHTML="";jQuery(document).ready(function(){
		jQuery.post('uno/plugins/'+f.substr(1)+'/'+f.substr(1)+'.php',{'action':'plugin'},function(r){document.getElementById('plugin').innerHTML=r;jQuery.getScript('uno/plugins/'+f.substr(1)+'/'+f.substr(1)+'.js');});
		});}
	function f_onPlug(f){if(f.checked){f.nextSibling.innerHTML='<?php echo _("Enable");?>';f.nextSibling.style.color='green';}else{f.nextSibling.innerHTML='<?php echo _("Disable");?>';f.nextSibling.style.color='#f79f81';}jQuery(document).ready(function(){jQuery.post('uno/central.php',{'action':'onPlug','unox':unox,'n':f.name,'c':f.checked});});var t=((f.checked)?"1":"0")+f.name;document.getElementById('p'+f.name).onclick=function(){f_plugin(t);};}
	function f_plugin_hook(){
		jQuery(document).ready(function(){
			jQuery.ajax({type:"POST",url:'uno/central.php',data:{'action':'pluginsActifs','unox':unox},dataType:'json',async:false,success:function(r){
				if(r.pl)jQuery.each(r.pl,function(k,v){plugact[k]=v;}); 
				if(r.ck)jQuery.each(r.ck,function(k,v){configFile[k]=v;}); 
			}});
		});}
	function f_ctit(f){a=document.getElementById('ctit');if(f.value.length>65)a.style.color="red";else a.style.color="green";a.innerHTML=f.value.length;}
	function f_cdesc(f){a=document.getElementById('cdesc');if(f.value.length>156)a.style.color="red";else a.style.color="green";a.innerHTML=f.value.length;}
	function f_elfinder(){a=document.getElementById('finderDiv');if (a.style.display!="block"){jQuery("#finderDiv").elfinder('open');document.getElementById('boutonFinder').className="bouton fr current";return};jQuery("#finderDiv").elfinder('close');document.getElementById('boutonFinder').className="bouton fr";}
	function f_finder_select(f){jQuery('<div \>').dialog({modal:true,width:"940px",title:"<?php echo _("Select a file");?>",zIndex: 9999,create:function(e,u){jQuery(this).elfinder({resizable:false,url:"uno/elfinder/php/connector.php",commandsOptions:{getfile:{oncomplete:'destroy'}},getFileCallback: function(url){document.getElementById(f).value=url;jQuery('a.ui-dialog-titlebar-close[role="button"]').click();}}).elfinder('instance')}});}
	function f_nombre(e){c=(e.which)?e.which:event.keyCode;if(c>31&&(c<48||c>57))return false;return true;}
	//
	f_plugin_hook();
	jQuery('#finderDiv').elfinder({lang:'<?php echo $lang;?>',url:'uno/elfinder/php/connector.php'}).elfinder('instance');jQuery("#finderDiv").elfinder('close');
	jQuery(document).ready(function(){if(dg==0){CKEDITOR.instances["content"].on('change', function(){dg=1;document.getElementById('boutonSauv').className="bouton danger";});jQuery("input[name='titre']").on('keypress', function(){dg=1;document.getElementById('boutonSauv').className="bouton danger";});}});
	f_get_site();
	f_get_page(0);
	CKEDITOR.replace('content');
</script>
</body>
</html>
