<?php
use WHMCS\Database\Capsule;
//use WHMCS\View\Menu\Item;

if (!defined("WHMCS")) {
    die("This file cannot be accessed directly");
}

function HivelocityTheme_config()
{
    return [
        'name' => 'Hivelocity Theme',
        'description' => '',
        'author' => 'Azhar',
        'language' => 'english',
        'version' => '1.0',
        //"fields" => []
    ];
}

function HivelocityTheme_activate()
{
    try {

        if(!Capsule::schema()->hasTable('mod_HivelocityTheme')) 
        {
            Capsule::schema()
            ->create(
                'mod_HivelocityTheme',
                function ($table) {
                    
                    $table->increments('id');
                    $table->string('key');
                    $table->text('value');
                }
            );
        }

        if(!Capsule::schema()->hasTable('mod_HivelocityTheme_pages')) 
        {
            Capsule::schema()
            ->create(
                'mod_HivelocityTheme_pages',
                function ($table) {
                    
                    $table->increments('id');
                    $table->string('name');
                    $table->longText('description');
                    $table->enum('publish', ['1', '0']);
                    $table->enum('required_login', ['0', '1']);
                    $table->string('url');
                    $table->timestamps();
                }
            );
        }

        if(!Capsule::schema()->hasTable('mod_HivelocityTheme_megamenu')) 
        {
            Capsule::schema()
            ->create(
                'mod_HivelocityTheme_megamenu',
                function ($table) {
                    
                    $table->increments('id');
                    $table->string('name');
                    $table->string('status');
                    $table->string('link');
                    $table->integer('parent');
                    $table->integer('order');
                    $table->text('description');
                    $table->text('customhtml');
                    $table->string('logged_only');
                    $table->integer('newtab');
                }
            );
        }

        if(!Capsule::schema()->hasTable('mod_HivelocityTheme_defaultmenu')) 
        {
            Capsule::schema()
            ->create(
                'mod_HivelocityTheme_defaultmenu',
                function ($table) {
                    
                    $table->increments('id');
                    $table->string('name');
                    $table->string('status');
                    $table->string('link');
                    $table->integer('parent');
                    $table->integer('order');
                    $table->text('description');
                    $table->text('customhtml');
                    $table->string('logged_only');
                    $table->integer('newtab');
                }
            );
        }

        if(!Capsule::schema()->hasTable('mod_HivelocityTheme_footermenu')) 
        {
            Capsule::schema()
            ->create(
                'mod_HivelocityTheme_footermenu',
                function ($table) {
                    
                    $table->increments('id');
                    $table->string('name');
                    $table->string('status');
                    $table->string('link');
                    $table->integer('parent');
                    $table->integer('order');
                    $table->string('logged_only');
                    $table->integer('newtab');
                }
            );
        }

        if(!Capsule::schema()->hasTable('mod_HivelocityTheme_banners')) 
        {
            Capsule::schema()
            ->create(
                'mod_HivelocityTheme_banners',
                function ($table) {
                    
                    $table->increments('id');
                    $table->string('banner');
                    $table->string('heading'); 
                    $table->string('page');
                    $table->text('content');
                }
            );
        }

        /*insert_query("mod_HivelocityTheme",array("key"=>"captionalign","value"=>'center'));
        insert_query("mod_HivelocityTheme",array("key"=>"bannerheight","value"=>'60'));
        insert_query("mod_HivelocityTheme",array("key"=>"applyanimation","value"=>'1'));
        insert_query("mod_HivelocityTheme",array("key"=>"megamenu","value"=>'0'));

        insert_query("mod_HivelocityTheme",array("key"=>"footercontent","value"=>'<div class="trustpilot"> <p>Our customer say <strong>Excellent</strong></p> <ul class="star-rating rating-4-4" title="4.4/5"> <li>★</li> <li>★</li> <li>★</li> <li>★</li> <li>★</li> </ul> <p><strong>   <img src="/templates/hivelocity/img/trustpilot-white-logo.svg" alt="" width="108" height="55" /></strong></p> </div> <p><img src="/templates/hivelocity/img/amex.svg" alt="" width="40" height="30" />     <img src="/templates/hivelocity/img/visa.svg" alt="" width="48" height="30" />     <img src="/templates/hivelocity/img/mastercard.svg" alt="" width="48" height="30" />     <img src="/templates/hivelocity/img/paypal.svg" alt="" width="46" height="30" />     <img src="/templates/hivelocity/img/crypto.svg" alt="" width="44" height="30" /></p>'));

        insert_query("mod_HivelocityTheme",array("key"=>"footercss","value"=>"#footer .trustpilot { display: flex; flex-direction: row; justify-content: center; margin-bottom: 20px; align-items: center; } #footer .star-rating { display: flex; flex-direction: row; list-style: none; color: #fff; padding-left: 10px; } #footer .star-rating li { background-color: #00b67a; color: #161a29; width: auto; font-size: 25px; height: 25px; line-height: 1; margin-right: 3px; position: relative; } #footer .star-rating li:last-child:after { width: 40%; } #footer .star-rating li::after { content: '★'; position: absolute; color: rgb(255, 255, 255); top: 0px; left: 0px; overflow: hidden; } #footer .nav{ font-family: 'Proxima-Nova',proxima-nova,sans-serif; font-size: 15px; line-height: 1.5; color: #b0afb1; display: block; }"));

        insert_query("mod_HivelocityTheme_banners",array("banner"=>'Hivelocity_TPA1_3.jpg',"heading"=>'LOREM
',"page"=>'',"content"=>'<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry</p>
<p><a class="btn btn-primary" href="/contact.php">Contact Us</a></p>'));

        insert_query("mod_HivelocityTheme_banners",array("banner"=>'Hivelocity_Home22Header1.jpg',"heading"=>'IPSUM
',"page"=>'',"content"=>'<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry</p>
<p><a class="btn btn-primary" href="/contact.php">Contact Us</a></p>'));

        full_query("INSERT INTO `mod_HivelocityTheme_footermenu` (`name`, `status`, `link`, `parent`, `order`, `logged_only`, `newtab`) VALUES
            ('Terms', 'Active', '#', 5, 4, 'Guest User', 0),
            ('Services', 'Active', '#', 0, 1, 'Guest User', 0),
            ('Data Migration', 'Active', '#', 2, 1, 'Guest User', 0),
            ('Server Management', 'Active', '#', 2, 2, 'Guest User', 0),
            ('About Company', 'Active', '#', 0, 2, 'Guest User', 0),
            ('Careers', 'Active', '#', 5, 2, 'Guest User', 0),
            ('Contact Us', 'Active', '/contact.php', 5, 3, 'Guest User', 1),
            ('Resources', 'Active', '#', 0, 3, 'Guest User', 0),
            ('API Documentation', 'Active', '#', 8, 2, 'Guest User', 0),
            ('Knowledge Base', 'Active', '#', 8, 3, 'Guest User', 0),
            ('Compute Solutions', 'Active', '#', 0, 4, 'Guest User', 0),
            ('Dedicated Servers', 'Active', '#', 11, 2, 'Guest User', 0),
            ('Storage Servers', 'Active', '#', 11, 3, 'Guest User', 0)");

        full_query("INSERT INTO `mod_HivelocityTheme_defaultmenu` (`name`, `status`, `link`, `parent`, `order`, `description`, `customhtml`, `logged_only`, `newtab`) VALUES
            ('VPS', 'Active', 'vps.php', 0, 12, '', '', 'Guest User', 0),
            ('Pricing', 'Active', 'pricing.php', 0, 20, '', '', 'Guest User', 0)");

        $row=Capsule::table('tblproducts')->where('servertype','Hivelocity')->first();

        $description='<center>
<h2 class="elementor-heading-title elementor-size-default">Simple, fast, &amp; reliable VPS hosting plans.</h2>
<div class="elementor-element elementor-element-8f4ec83 elementor-widget elementor-widget-heading" data-id="8f4ec83" data-element_type="widget" data-widget_type="heading.default">
<div class="elementor-widget-container">
<p class="elementor-heading-title elementor-size-default">No setup fees. No commitments. Billed Monthly.</p>
<p class="elementor-heading-title elementor-size-default">{$productplans-gid='.$row->gid.'}</p>
</div>
</div>
<a class="btn btn-order-now" style="padding: 14px;" href="/store/vps">View All VPS Plans</a></center>
<div class="row my-5">
<h2 class="h2 text-center">Superior execution VPS hosting highlights.</h2>
<h6 class="text-center" style="margin-bottom: 74px;">Strong cloud VPS hosting worked for Linux VPS and Windows VPS clients.</h6>
<div class="row mb-3">
<div class="col-md-6">
<h4>Server Assets</h4>
<p>The server\'s assets, including Intel and AMD central processors, are yours. Don\'t bother agonizing over others site traffic influencing your exhibition.</p>
<h4>Worldwide Accessibility</h4>
<p>Send now in Los Angeles, CA; Tampa, FL; furthermore, New York City, NY. Coming soon the capacity to convey your VPS in one of our other 40+ server farm areas.</p>
<h4>Best Costs in the US</h4>
<p>Get the best presentation at the cost of any VPS in sold in North America. We utilize strong computer chips, so each vCPU center with a VPS is more remarkable than a similiar measure of centers with another supplier.</p>
</div>
<div class="col-md-6"><img class="attachment-full size-full wp-image-2741" src="/templates/hivelocity/img/server-management-header-mobile.webp" sizes="(max-width: 768px) 100vw, 768px" srcset="/templates/hivelocity/img/server-management-header-mobile.webp 768w, /templates/hivelocity/img/server-management-header-mobile-300x266.webp 300w" alt="" width="450" height="280" /></div>
</div>
<div class="row mb-3">
<div class="col-md-6"><br /><br /><img class="attachment-full size-full wp-image-2824" src="/templates/hivelocity/img/private-cloud-header-mobile.webp" sizes="(max-width: 768px) 100vw, 768px" srcset="/templates/hivelocity/img/private-cloud-header-mobile.webp 768w, /templates/hivelocity/img/private-cloud-header-mobile-300x266.webp 300w" alt="" width="450" height="280" /></div>
<div class="col-md-6"><br /><br />
<h4>#1 Evaluated Help Group</h4>
<p>Our care staff has the most elevated rankings of any hosting supplier on Trustpilot, G2, HostingAdvice.com, and TechRadar. Breathe a sigh of relief realizing we have staff prepared to deal with your VPS servers day in and day out/365.</p>
<h4>99.99% Uptime SLA</h4>
<p>We\'ve had 3 years running of 100 percent uptime, truth be told. Express farewell to blackouts and rest soundly realizing your VPS hosting is protected.</p>
<h4>Blasting quick 2+ Tpbs Organization</h4>
<p>We cleverly course your traffic over our numerous Level 1 travel transporters guaranteeing your bundles generally travel on the most un-blocked way to their objective. Adored by our streaming and gaming clients, our organization guarantees your end clients get the least inertness and most ideal experience.</p>
</div>
</div>
</div>
<center>
<h2>Alter how you convey your virtual private server.</h2>
Browse a huge determination of working operating systems and hardware.</center>
<div class="row my-5">
<h4 class="text-center">Operating System</h4>
<br /><br /><br />
<div class="col-md-3 text-center"><img class="text-center" src="/templates/hivelocity/img/Ubuntu.svg" alt="" width="100" height="80" />
<p>Ubuntu</p>
</div>
<div class="col-md-2 text-center"><img class="attachment-thumbnail size-thumbnail wp-image-27645" src="/templates/hivelocity/img/Windows.svg" alt="" width="100" height="80" />
<p>Windows</p>
</div>
<div class="col-md-2 text-center"><img class="attachment-thumbnail size-thumbnail wp-image-27642" src="/templates/hivelocity/img/Almalinux.svg" alt="" width="100" height="80" />
<p>Alma</p>
</div>
<div class="col-md-2 text-center"><img class="attachment-thumbnail size-thumbnail wp-image-27643" src="/templates/hivelocity/img/Debian.svg" alt="" width="100" height="80" />
<p>Debian</p>
</div>
<div class="col-md-3 text-center"><img class="attachment-thumbnail size-thumbnail wp-image-27641" src="/templates/hivelocity/img/Rockylinux.svg" alt="" width="100" height="80" />
<p>Rocky</p>
</div>
</div>
<div class="row my-5">
<h4 class="text-center">Hardware</h4>
<br /><br /><br />
<div class="col-md-3 text-center"><img class="attachment-thumbnail size-thumbnail wp-image-27646" src="/templates/hivelocity/img/other.svg" alt="" width="100" height="80" />
<p>Custom ISO</p>
</div>
<div class="col-md-3 text-center"><img class="attachment-thumbnail size-thumbnail wp-image-28741" src="/templates/hivelocity/img/logo-intel-blue.svg" alt="Intel CPU Logo" width="100" height="80" />
<p>Intel</p>
</div>
<div class="col-md-3 text-center"><img class="attachment-thumbnail size-thumbnail wp-image-19150" src="/templates/hivelocity/img/amd-logo-black.svg" alt="" width="100" height="80" />
<p>AMD</p>
</div>
<div class="col-md-3 text-center"><img class="attachment-thumbnail size-thumbnail wp-image-28771" src="/templates/hivelocity/img/image-37.svg" alt="" width="100" height="80" />
<p>Supermicro</p>
</div>
</div>';


        insert_query("mod_HivelocityTheme_pages",array("name"=>'VPS',"description"=>$description,"publish"=>'1',"required_login"=>'0',"url"=>'vps.php','created_at'=> date('Y-m-d H:i:s')));*/

        return [
            'status' => 'success',
            'description' => '',
        ];
    } catch (\Exception $e) {
        return [
            'status' => "error",
            'description' => 'Unable to create mod_HivelocityTheme: ' . $e->getMessage(),
        ];
    }
}

function HivelocityTheme_deactivate()
{
    try {
        /*Capsule::schema()
            ->dropIfExists('mod_HivelocityTheme');

        Capsule::schema()
            ->dropIfExists('mod_HivelocityTheme_pages');

        Capsule::schema()
            ->dropIfExists('mod_HivelocityTheme_megamenu');

        Capsule::schema()
            ->dropIfExists('mod_HivelocityTheme_defaultmenu');

        Capsule::schema()
            ->dropIfExists('mod_HivelocityTheme_footermenu');

        Capsule::schema()
            ->dropIfExists('mod_HivelocityTheme_banners');*/

        return [
            'status' => 'success',
            'description' => '',
        ];
    } catch (\Exception $e) {
        return [
            "status" => "error",
            "description" => "Unable to drop mod_HivelocityTheme: {$e->getMessage()}",
        ];
    }
}

function HivelocityTheme_output($vars)
{

    require_once $_SERVER['DOCUMENT_ROOT'].'/vendor/smarty/smarty/libs/Smarty.class.php';
    $smarty = new Smarty; 

    if($_POST['savepage'])
    {
       insert_query("mod_HivelocityTheme_pages",array("name"=>$_POST['name'],'publish'=>$_POST['status'],'url'=>$_POST['url'],'description'=>$_POST['description'],'required_login'=>$_POST['login'],'created_at'=>date('Y-m-d H:i:s')));
        header('Location: '.$_SERVER['SCRIPT_URL'].'?module=HivelocityTheme&page=pagemanager');
        exit;
    }

    if($_GET['pageact']=='delete')
    {
        Capsule::table('mod_HivelocityTheme_pages')->where('id','=',$_GET['pageid'])->delete();
    }
    
    if($_POST['updatepage'])
    {
        update_query("mod_HivelocityTheme_pages",array("name"=>$_POST['name'],'publish'=>$_POST['status'],'url'=>$_POST['url'],'description'=>$_POST['description'],'required_login'=>$_POST['login'],'updated_at'=>date('Y-m-d H:i:s')),array('id'=>$_POST['id']));
        header('Location: '.$_SERVER['SCRIPT_URL'].'?module=HivelocityTheme&page=pagemanager');
        exit;
    }

    foreach (Capsule::table('mod_HivelocityTheme')->get() as $get) {
       $settings[$get->key]= $get->value;

    }

    $menutable='mod_HivelocityTheme_defaultmenu';
    if($settings['megamenu']=='1')
        $menutable='mod_HivelocityTheme_megamenu';

    if($_POST['savemenu'])
    {
       insert_query($menutable,array("name"=>$_POST['name'],'status'=>$_POST['status'],'link'=>$_POST['link'],'parent'=>$_POST['parent'],'order'=>$_POST['order'],'description'=>$_POST['description'],'customhtml'=>$_POST['customhtml'],'logged_only'=>$_POST['logged_only'],'newtab'=>$_POST['newtab']));
        header('Location: '.$_SERVER['SCRIPT_URL'].'?module=HivelocityTheme&page=menumanager');
        exit;
    }

    if($_GET['menuact']=='delete')
    {
        Capsule::table($menutable)->where('id','=',$_GET['menuid'])->delete();
    }
    
    if($_POST['updatemenu'])
    {
        update_query($menutable,array("name"=>$_POST['name'],'status'=>$_POST['status'],'link'=>$_POST['link'],'parent'=>$_POST['parent'],'order'=>$_POST['order'],'description'=>$_POST['description'],'customhtml'=>$_POST['customhtml'],'logged_only'=>$_POST['logged_only'],'newtab'=>$_POST['newtab']),array('id'=>$_POST['id']));
        header('Location: '.$_SERVER['SCRIPT_URL'].'?module=HivelocityTheme&page=menumanager');
        exit;
    }

    if($_POST['settingsave'])
    {
        unset($_POST['token']);
        unset($_POST['settingsave']);
        foreach ($_POST as $key => $value) {

            /*if($key=='megamenu' && $value=='0')
            {
                full_query("TRUNCATE TABLE mod_HivelocityTheme_megamenu");
            }*/

            Capsule::table('mod_HivelocityTheme')->where('key','=',$key)->delete();
            insert_query("mod_HivelocityTheme",array("key"=>$key,'value'=>$value));
            header("refresh: 0");  
        }
    }

    if($_GET['pageid'])
    {
        $page=Capsule::table('mod_HivelocityTheme_pages')->where('id',$_GET['pageid'])->first();
        $smarty->assign('page', $page);
    }

    $pages=Capsule::table('mod_HivelocityTheme_pages')->get();
    $smarty->assign('pages', json_decode($pages,true));

    if($_GET['menuid'])
    {
        $menu=Capsule::table($menutable)->where('id',$_GET['menuid'])->first();
        $smarty->assign('menu', $menu);
    }

    foreach(Capsule::table($menutable)->get() as $get)
    {
        $menus[$get->id]['id']=$get->id;
        $menus[$get->id]['name']=$get->name;
        $menus[$get->id]['status']=$get->status;
        $row=Capsule::table($menutable)->where('id',$get->parent)->first();
        $menus[$get->id]['parent']=$row->name;
    }

    if($_POST['savebanner'])
    {
        move_uploaded_file($_FILES['banner']['tmp_name'],__DIR__.'/assets/img/'.$_FILES['banner']['name']);
        
        insert_query("mod_HivelocityTheme_banners",array("banner"=>$_FILES['banner']['name'],'heading'=>$_POST['heading'],'content'=>$_POST['content'],'page'=>$_POST['page'])); 
        header('Location: '.$_SERVER['SCRIPT_URL'].'?module=HivelocityTheme&page=banners');
        exit;
    }

    if($_GET['action']=='delete')
    {
        Capsule::table('mod_HivelocityTheme_banners')->where('id','=',$_GET['bid'])->delete();
        header('Location: '.$_SERVER['SCRIPT_URL'].'?module=HivelocityTheme&page=banners');
        exit;
    }
    
    if($_POST['updatebanner'])
    {
        $banner=Capsule::table("mod_HivelocityTheme_banners")->where('id',$_POST['id'])->first();

        $filename=$banner->banner;
        if($_FILES['banner']['name'])
        {
            move_uploaded_file($_FILES['banner']['tmp_name'],__DIR__.'/assets/img/'.$_FILES['banner']['name']);
            $filename=$_FILES['banner']['name'];
        }
        update_query("mod_HivelocityTheme_banners",array("banner"=>$filename,'heading'=>$_POST['heading'],'content'=>$_POST['content'],'page'=>$_POST['page']),array('id'=>$_POST['id']));

        header('Location: '.$_SERVER['SCRIPT_URL'].'?module=HivelocityTheme&page=banners');
        exit;
    }

    if($_GET['bid'])
    {
        $banner=Capsule::table("mod_HivelocityTheme_banners")->where('id',$_GET['bid'])->first();
        $smarty->assign('banner', $banner);
    }

    $cnt=0;
    foreach ($_SESSION['navbarMenus'] as $key => $item) {
        if($item->hasChildren() || $item->getName()=='Home')
        {
            continue;
        }
        $pagearr[$cnt]['name']=$item->getName();
        $pagearr[$cnt]['uri']=str_replace('/','',$item->getUri());

        $cnt++;
    }

    $banners=Capsule::table('mod_HivelocityTheme_banners')->get();
    $smarty->assign('banners', json_decode($banners,true));

    if($_POST['savefootermenu'])
    {
       insert_query('mod_HivelocityTheme_footermenu',array("name"=>$_POST['name'],'status'=>$_POST['status'],'link'=>$_POST['link'],'parent'=>$_POST['parent'],'order'=>$_POST['order'],'logged_only'=>$_POST['logged_only'],'newtab'=>$_POST['newtab']));
        header('Location: '.$_SERVER['SCRIPT_URL'].'?module=HivelocityTheme&page=footermenu');
        exit;
    }

    if($_GET['footermenuact']=='delete')
    {
        Capsule::table('mod_HivelocityTheme_footermenu')->where('id','=',$_GET['footerid'])->delete();
    }
    
    if($_POST['updatefootermenu'])
    {
        update_query('mod_HivelocityTheme_footermenu',array("name"=>$_POST['name'],'status'=>$_POST['status'],'link'=>$_POST['link'],'parent'=>$_POST['parent'],'order'=>$_POST['order'],'logged_only'=>$_POST['logged_only'],'newtab'=>$_POST['newtab']),array('id'=>$_POST['id']));
        header('Location: '.$_SERVER['SCRIPT_URL'].'?module=HivelocityTheme&page=footermenu');
        exit;
    }

    foreach(Capsule::table('mod_HivelocityTheme_footermenu')->get() as $get)
    {
        $footermenus[$get->id]['id']=$get->id;
        $footermenus[$get->id]['name']=$get->name;
        $footermenus[$get->id]['status']=$get->status;
        $row=Capsule::table('mod_HivelocityTheme_footermenu')->where('id',$get->parent)->first();
        $footermenus[$get->id]['parent']=$row->name;
    }

    $smarty->assign('footermenus', $footermenus);

    if($_GET['footerid'])
    {
        $footermenu=Capsule::table('mod_HivelocityTheme_footermenu')->where('id',$_GET['footerid'])->first();
        $smarty->assign('footermenu', $footermenu);
    }

    global $CONFIG;

    $smarty->assign('menus', $menus);
    $smarty->assign('pagearr', $pagearr);

    $smarty->assign('settings', $settings);
    // document root
    $smarty->assign('docroot', $_SERVER['DOCUMENT_ROOT']);

    // system url
    $smarty->assign('systemurl', $CONFIG['SystemURL'].$_SERVER['PHP_SELF']);

    // domain
    $smarty->assign('domain', $CONFIG['SystemURL']);
    $smarty->display(dirname(__FILE__) . '/templates/layout.tpl');
}