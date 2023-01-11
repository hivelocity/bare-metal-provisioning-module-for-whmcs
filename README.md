What's New!
Support for latest whmcs version 8.6.1/ PHP 8.1.13, ioncube 12x

Auto creations / import of products and configurations options.

DNS integration Domains NS records need to be pointed to our systems listed below.
ns3.hivelocity.net
ns4.hivelocity.net

Network graph

Ipmi access to system to system by whitelisting ip.

Server backup option using our R1 backup services

About the Hivelocity WHMCS Dedicated Server Module.
Hivelocity Dedicated Servers For WHMCS will let you automatically deploy dedicated servers powered by Hivelocity. This module will allow your client to order a dedicated servers as well as reinstall and manage the server.

Admin Features
Create/Suspend/Unsuspend/Terminate Server

Import products from Hivelocity (The SSLStore does this)

Synchronize Products from Hivelocity (The SSLStore does this)

Schedule synchronization of products and services.

Client Features Display IPMI info to client

Power On/Power Off/Reboot Server

Reinstall Server

Download and Installation
GitHub - hivelocity/bare-metal-provisioning-module-for-whmcs: Provision Hivelocity Dedicated Servers Automatically with The Bare Metal Provisioning Modules for WHMCS

This is a steps by steps how to setup our WHMCS HV module.

All you need to get started is to have the Bare Metal module installed on your WHMCS, A https://my.hivelocity.net/sign-up , add a credit card on file to order servers.

This currently only works with the Six template.

Step 1. Create an account with us myVelocity and add a credit card on file to order servers.

Upload The Module: We recommend uploading the "bare-metal-provisioning-module-for-whmcs-master.zip" file using your preferred method (scp, sftp, ftp, via cPanel file manager, etc...) directly to the server, extract it, the resulting extraction has three folders under "bare-metal-provisioning-module-for-whmcs-master/modules/" > "addons","servers" and templates.

Old Way Module Installation:

Extract the file in tmp folder then move all contents to your whmcs installation folder.

Move the contents of "addons" folder to the path of /whmcs/ installation folder. This depends on where you set your WHMCS path ex. "/var/www/html/whmcs/modules/addons/"

Step 2. Login to WHMCS go to System settings -> Addon and activate the Hivelocity Pricing Tool Module under Addon Modules. If you would like to receive emails on price changes, click the check box next to "Check if you want to receive an email notification about the price change of Hivelocity"

We recommend uploading the "bare-metal-provisioning-module-for-whmcs-master.zip" file using your preferred method (scp, sftp, ftp, via cPanel file manager, etc...) directly to the server, extract it, the resulting extraction has two folders under "bare-metal-provisioning-module-for-whmcs-master/modules/" > "addons" and "servers".

New way of Install

cd ~/ | git clone git@github.com:hivelocity/bare-metal-provisioning-module-for-whmcs.git ~/.

cp -Rs ~/bare-metal-provisioning-module-for-whmcs/modules/addons/HivelocityPricingTool/ [path to modules/addons folder]/HivelocityPricingTool/

cp -Rs ~/bare-metal-provisioning-module-for-whmcs/modules/servers/Hivelocity/ [path to modules/servers folder]/Hivelocity

Chown the directories by your web user if necessary.

Move the contents of "servers" folder to the path of /whmcs/ installation folder. This depends on where you set your WHMCS path ex. "/var/www/html/whmcs/modules/servers/"

Step 3. Module configuration

Server Setup

Next go to System settings -> Servers Click add new server

Under Module Select Hivelocity. Under Hostname enter core.hivelocity.net Under access hash enter your API Key you get out of your myVelocity then click continue.

Give the server a Name Like Bare Metal or Dedicated Servers then go to the bottom and click save.

Click Create New Group and name it whatever you like.

Add your Hivelocity Server to the group.

Create Products/Services

Go to System Settings -> Products and Services.

Click Create a new Group and give it a name.

Select Order Form Template you want, and payment gateways then click save.

**Run the following cron and wait 5-10 minutes all products and configuration options are getting generated.
/usr/local/bin/php public_html/modules/addons/HivelocityPricingTool/cron.php

Custom Options
There are other options under the module setting of the product you can configure including Metric Billing Transfer In and Out or 95% In and Out.

There are also addons which are included on the order form automatically when you generate configurable options.

cPanel, WHMCS, Litespeed Web Server, Managed Services, Load Balancing, Extra Bandwidth, DDOS Protection, Data Migration and Backup & Rapid Restore.

These modules currently only work with the six template.

If you would like to manage the prices with the Hivelocity pricing tool, select the billing cycles you want enabled and leave it 0.00 and click save.

Then later you can mark it up in the Hivelocity pricing tool.

Go to the Addons Menu then Hivelocity Pricing tool.

You can either set your Profit margin individually or on all your servers at the top of the page. Add your percentage and click save or hit enter if you are doing them individually.

Setup the cronjob - add modules\addons\HivelocityPricingTool\cron.php to your cron job table.

For any questions or issues please contact our support team for assistance. Escalate to Developers if any bugs are found.
