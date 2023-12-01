<?php
use WHMCS\Database\Capsule;

add_hook('ClientAreaPrimaryNavbar', 1, function($primaryNavbar) {
    
    $settings=Capsule::table('mod_HivelocityTheme')->where('key','megamenu')->first();

    if($settings->value=='1')
    {
        $removesarr = array(
					'Services',
					'Domains',
					'Announcements',
					'Support',
					'Knowledgebase',
					'Network Status',
					'Open Ticket',
					'Contact Us',
					'Billing',
					'Store',
					'Home',
				);

        foreach ($removesarr as $value) {
	        if (!is_null($primaryNavbar->getChild($value))) {
	            $primaryNavbar->removeChild($value);
	        }
	    }
    }

    function setMenu($get,$primaryNavbar)
    {
    	if($get->parent==0)
        {
	       $newMenu = $primaryNavbar->addChild(
		        $get->name,
		        array(
		            'name' => $get->name,
		            'uri' => $get->link,
		            'order' => $get->order,
		        )
		    );

	        if($get->newtab==1)
	        {
	       		$newMenu->setAttribute("target", '_blank');
	        }
   		}
        else if($get->parent)
        {
        	$row=Capsule::table('mod_HivelocityTheme_defaultmenu')->where('id',$get->parent)->first();
			if (!is_null($primaryNavbar->getChild($row->name))) {
		        $newMenu=$primaryNavbar->getChild($row->name)
		            ->addChild($get->name, array(
		            	'name' => $get->name,
		                'uri' => $get->link,
		                'order' => $get->order,
		            ));

	            if($get->newtab==1)
		        {
		       		$newMenu->setAttribute("target", '_blank');
		        }
		    }
        }
    }

    if($settings->value=='0')
    {
    	$client = Menu::context('client');
		foreach (Capsule::table('mod_HivelocityTheme_defaultmenu')->where('status','Active')->get() as $get) {
	     	
			if($get->logged_only=='Login User' && !is_null($client))
			{
				setMenu($get,$primaryNavbar);
			}
			else if($get->logged_only=='Guest User' && is_null($client))
			{
				setMenu($get,$primaryNavbar);
			}
	        
	    }
	}
	$_SESSION['navbarMenus']=$primaryNavbar;
});

add_hook('ClientAreaHeaderOutput', 1, function($vars) { 

	$client = Menu::context('client');

	function isParent($id)
	{
		$row=Capsule::table('mod_HivelocityTheme_megamenu')->where('parent',$id)->first();

		if($row)
		{
			return true;
		}
		return false;
	}

	function getChild($id)
	{
		$q=full_query("SELECT * FROM mod_HivelocityTheme_megamenu WHERE parent=".$id." AND status='Active' ORDER BY `order` ASC");
		while($row=mysql_fetch_object($q)) {
			
			$arr[$row->id]['name']=$row->name;
			$arr[$row->id]['link']=$row->link;
			$arr[$row->id]['isParent']=isParent($row->id);
			$arr[$row->id]['parent']=$row->parent;
			$arr[$row->id]['order']=$row->order;
			$arr[$row->id]['newtab']=$row->newtab;
			$arr[$row->id]['description']=$row->description;
			$arr[$row->id]['customhtml']=html_entity_decode($row->customhtml);
			if(isParent($row->id))
			{
				$arr[$row->id]['child']=getChild($row->id);	
			}
			
		} 
		return $arr;
	}

	GLOBAL $smarty;
	foreach(Capsule::table('mod_HivelocityTheme')->get() as $setting)
	{
		if($setting->key=='megamenu' && $setting->value=='1')
		{
			$smarty->assign('cusmegamenu',$setting->value);
		}

		if($setting->key=='sidebarpositon')
		{
			$smarty->assign('sidebarpositon',$setting->value);
		}

		if($setting->key=='customcsscode')
		{
			$smarty->assign('customcsscode',$setting->value);
		}

		if($setting->key=='captionalign')
		{
			$smarty->assign('captionalign',$setting->value);
		}

		if($setting->key=='isbreadcrumb')
		{
			$smarty->assign('isbreadcrumb',$setting->value);
		}

		if($setting->key=='bannerheight')
		{
			$smarty->assign('bannerheight',$setting->value);
		}

		if($setting->key=='footercontent')
		{
			$smarty->assign('footercontent',$setting->value);
		}

		if($setting->key=='footercss')
		{
			$smarty->assign('footercss',$setting->value);
		}

		if($setting->key=='applyanimation' && $setting->value=='1')
		{
			$smarty->assign('applyanimation',$setting->value);
		}
	}

	foreach (Capsule::table('mod_HivelocityTheme_megamenu')->where('status','Active')->get() as $get) {

		if($get->logged_only=='Login User' && !is_null($client))
		{
			if($get->parent==0){
				$primaryNavbar[$get->id]['name']=$get->name;
				$primaryNavbar[$get->id]['link']=$get->link;
				$primaryNavbar[$get->id]['isParent']=isParent($get->id);
				$primaryNavbar[$get->id]['parent']=$get->parent;
				$primaryNavbar[$get->id]['order']=$get->order;
				$primaryNavbar[$get->id]['newtab']=$get->newtab;

				if(isParent($get->id)){
					$primaryNavbar[$get->id]['description']=$get->description;
					$primaryNavbar[$get->id]['customhtml']=html_entity_decode($get->customhtml);
				}
			}

			if($get->parent)
			{
				$primaryNavbar[$get->parent]['child']=getChild($get->parent);
			}
		}
		else if($get->logged_only=='Guest User' && is_null($client))
		{
			if($get->parent==0){
				$primaryNavbar[$get->id]['name']=$get->name;
				$primaryNavbar[$get->id]['link']=$get->link;
				$primaryNavbar[$get->id]['isParent']=isParent($get->id);
				$primaryNavbar[$get->id]['parent']=$get->parent;
				$primaryNavbar[$get->id]['order']=$get->order;
				$primaryNavbar[$get->id]['newtab']=$get->newtab;

				if(isParent($get->id)){
					$primaryNavbar[$get->id]['description']=$get->description;
					$primaryNavbar[$get->id]['customhtml']=html_entity_decode($get->customhtml);
				}
			}

			if($get->parent)
			{
				$primaryNavbar[$get->parent]['child']=getChild($get->parent);
			}
		}

    }

   	$smarty->assign('primaryMegaNavbar',$primaryNavbar);

   	$banners=Capsule::table('mod_HivelocityTheme_banners')->get();
    $smarty->assign('banners', json_decode($banners,true));

    $page=Capsule::table('mod_HivelocityTheme_banners')->where('page',str_replace('/','',$_SERVER['REQUEST_URI']))->select('mod_HivelocityTheme_banners.page')->get();

    $page=json_decode($page);
    $smarty->assign('current_pageuri',$page[0]->page);

	$smarty->assign('domain', $CONFIG['SystemURL']);    
});

add_hook('ClientAreaFooterOutput', 1, function($vars) {
    
    $client = Menu::context('client');

    $userlogin='Guest User';
    if(!is_null($client))
    {
    	$userlogin='Login User';
    }

    $q=full_query("SELECT * FROM mod_HivelocityTheme_footermenu WHERE status='Active' AND logged_only='".$userlogin."' ORDER BY `order` ASC");

     while($rows=mysql_fetch_object($q)){

    	$arr[$rows->id]['name']=$rows->name;
		if($rows->parent)
		{
			$arr[$rows->parent]['child'][$rows->id]['name']=$rows->name;
			$arr[$rows->parent]['child'][$rows->id]['link']=$rows->link;
			$arr[$rows->parent]['child'][$rows->id]['newtab']=$rows->newtab;
		}
    }

    GLOBAL $smarty;
    $smarty->assign('footermenus', $arr);
});

add_hook('ClientAreaPage', 1, function($vars) {

	require_once __DIR__.'/functions.php';

	$row=Capsule::table('tblproducts')->where('servertype','Hivelocity')->first();

	GLOBAL $smarty;
    $smarty->assign('clientareaproducts', getAllProducts($row->gid));
});				
