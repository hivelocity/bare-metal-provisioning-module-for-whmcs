About the Hivelocity WHMCS Dedicated Server Module.
Hivelocity Dedicated Servers For WHMCS will let you automatically deploy dedicated servers powered by Hivelocity. This module will allow your client to order a dedicated servers as well as reinstall and manage the server.

Admin Features
Create/Suspend/Unsuspend/Terminate Server

Import products from Hivelocity (The SSLStore does this)

Synchronize Products from Hivelocity (The SSLStore does this)

Schedule synchronization of products and services. 

Client Features
Display IPMI info to client

Power On/Power Off/Reboot Server

Reinstall Server

Download and Installation
GitHub - hivelocity/bare-metal-provisioning-module-for-whmcs: Provision Hivelocity Dedicated Servers Automatically with The Bare Metal Provisioning Modules for WHMCS 

This is a steps by steps how to setup our WHMCS HV module.
 

All you need to get started is to have the Bare Metal module installed on your WHMCS, A https://my.hivelocity.net/sign-up , add a credit card on file to order servers.


This currently only works with the Six template.
 

Step 1. Create an account with us myVelocity  and add a credit card on file to order servers.


Upload The Module:
We recommend uploading the "bare-metal-provisioning-module-for-whmcs-master.zip" file using your preferred method (scp, sftp, ftp, via cPanel file manager, etc...) directly to the server, extract it, the resulting extraction has two folders under "bare-metal-provisioning-module-for-whmcs-master/modules/" > "addons" and "servers".

Old Way
Module Installation:

Move the contents of "addons" folder to the path of /whmcs/ installation folder. This depends on where you set your WHMCS path ex. "/var/www/html/whmcs/modules/addons/"

Login to WHMCS go to System settings -> Addon and activate the Hivelocity Pricing Tool Module under Addon Modules. If you would like to receive emails on price changes, click the check box next to "Check if you want to receive an email notification about the price change of Hivelocity"

We recommend uploading the "bare-metal-provisioning-module-for-whmcs-master.zip" file using your preferred method (scp, sftp, ftp, via cPanel file manager, etc...) directly to the server, extract it, the resulting extraction has two folders under "bare-metal-provisioning-module-for-whmcs-master/modules/" > "addons" and "servers".

New way

cd ~/ | git clone git@github.com:hivelocity/bare-metal-provisioning-module-for-whmcs.git ~/. 

cp -Rs ~/bare-metal-provisioning-module-for-whmcs/modules/addons/HivelocityPricingTool/ [path to modules/addons folder]/HivelocityPricingTool/ 

cp -Rs ~/bare-metal-provisioning-module-for-whmcs/modules/servers/Hivelocity/ [path to modules/servers folder]/Hivelocity

Chown the directories by your web user if necessary.

Server Setup

Move the contents of "servers" folder to the path of /whmcs/ installation folder. This depends on where you set your WHMCS path ex. "/var/www/html/whmcs/modules/servers/"

Next go to System settings -> Servers
Click add new server



Under Module Select Hivelocity.
Under Hostname enter core.hivelocity.net
Under access hash enter your API Key you get out of your myVelocity  then click continue. It should look like below image.


Give the server a Name Like Bare Metal or Dedicated Servers then go to the bottom and click save.

Click Create New Group and name it whatever you like.

Add your Hivelocity Server to the group. See image below


Create Products/Services

Go to System Settings -> Products and Services.

Click Create a new Group and give it a name.

Select Order Form Template you want, and payment gateways then click save.

Click Create a New Product.

On the product creation screen Select Server/VPS, Select the product Group you created from the drop down, and Select the Hivelocity from the Module drop down then click continue. See example below 


Make changes as needed to the Product Details tab and click save. Example below


Click the Pricing Tab and tick Recurring. 

Next tick One Time/Monthly and click save. 

Make sure to enable one billing period or the product will not show up in the pricing tool. Example below 


If you would like to manage the prices with the Hivelocity pricing tool, select the billing cycles you want enabled and leave it 0.00 and click save. Then later you can mark it up in the Hivelocity pricing tool.
 

Product Module configuration

If you do not do these steps in this order, you may have issues with your product working correctly, we can't stress enough how important is to click SAVE at any of the given steps below

Next go to the module tab and select the Server Group you created earlier from the drop down then click save.

Select the Server under product you want and click save.

Click generate configurable options next to the server you want then click save. Example below 


Go to the Addons Menu then Hivelocity Pricing tool.


You can either set your Profit margin individually or on all your servers at the top of the page. Add your percentage and click save or hit enter if you are doing them individually.


Setup the cronjob - add modules\addons\HivelocityPricingTool\cron.php to your cron job table.

You should now have a Bare Metal Server configured and in your store. 

There are other options under the module setting of the product you can configure including Metric Billing Transfer In and Out or 95% In and Out.

 

There are also addons which are included on the order form automatically when you generate configurable options.

cPanel, WHMCS, Litespeed Web Server, Managed Services, Load Balancing, Extra Bandwidth, DDOS Protection, Data Migration and Backup & Rapid Restore.

All of these addons will be added for purchase when you Generate configurable options. The Generate Configurable Options creates a generic name for each chosen package, please go to System-Settings>Configurable Options menu, click on Edit to change the name to something descriptive.

These modules currently only work with the six template.

For any questions or issues please contact our support team for assistance. Escalate to Developers if any bugs are found.
