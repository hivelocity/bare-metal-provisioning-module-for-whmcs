# **bare-metal-provisioning-module-for-whmcs**
## Provision Hivelocity Dedicated Servers Automatically with The Bare Metal Provisioning Modules for WHMCS
#### Quick how to get started guide.
##### ***All you need to get started is to have the Bare Metal module installed on your WHMCS, A http://my.hivelocity.net account, and a credit card on file to order servers.***
###### This currently only works with the Six template.
**_Upload_**:
We recommend uploading the "bare-metal-provisioning-module-for-whmcs-master.zip" file using your preferred method **(scp, sftp, ftp, via cPanel file manager, etc...)** directly to the server, extract it, the resulting extraction has two folders under "bare-metal-provisioning-module-for-whmcs-master/modules/" > "addons" and "servers".
#### 1. _Module Installation_
1. Move the contents of "addons" folder to the path of /whmcs/ installation folder. This depends on where you set your WHMCS path ex. "/var/www/html/whmcs/modules/addons/"
2. Login to WHMCS go to System settings -> Addon and activate the Hivelocity Pricing Tool Module under Addon Modules. If you would like to recieve emails on price changes click the check box next to "Check if you want to receive an email notification about the price change of Hivelocity"
#### 2. _Server Setup_
Move the contents of "servers" folder to the path of /whmcs/ installation folder. This depends on where you set your WHMCS path ex. "/var/www/html/whmcs/modules/servers/"
1. Next go to System settings -> Servers 
2. Click add new server
3. Under Module Select Hivelocity.
4. Under Hostname enter core.hivelocity.net
5. Under access hash enter your API Key you get out of your **https://my.hivelocity.net/account** then click continue.
6. Give the server a Name Like Bare Metal or Dedicated Servers then go to the bottom and click save.
7. Click Create New Group and name it whatever you like..
8. Add your Hivelocity Server to the group.
#### 3a. _Create Products/Services_
1. Go to System Settings -> Products and Services.
2. Click Create a new Group and give it a name.
3. Select Order Form Template you want and payment gateways then click save.
4. Click Create a New Product.
5. On the product creation screen Select Server/VPS, Select the product Group you created from the drop down, and Select the Hivelocity from the Module drop down then click continue.
6. Make changes as needed to the Product Details tab and click save.
7. Click the Pricing Tab and tick Recurring. Next tick One Time/Monthly and click save. Make sure to enable one billing peroid or the product will not show up in the pricing tool. **_I normally just tick one time month and leave it 0.00 and click save. Then later you can mark it up in the Hivelocity pricing tool._**
#### 3b. Product Module configuration
##### If you do not do these steps in this order you may have issues with your product working correctly, we can't stress enough how important is to click SAVE at any of the given steps below
1. Next go to the module tab and select the Server Group you created earlier from the drop down then click save.
2. Select the Server under product you want and click save.
3. Click generate configurable options next to the server you want then click save.
4. Go to the Addons Menu then Hivelocity Pricing tool.
5. You can either set your Profit marging individually or on all your servers at the top of the page. Add your percentage and click save or hit enter if you are doing them individually.
6. Setup the cronjob - add modules\addons\HivelocityPricingTool\cron.php to your cron job table.

You should now have a Bare Metal Server configured and in your store. There are other options under the module setting of the product you can configure including Metric Billing Transfer In and Out or 95% In and Out.

There are also addons which are included on the order form automatically when you generate configurable options. cPanel, WHMCS, Litespeed Web Server, Managed Services, Load Balancing,  Extra Bandwidth, DDOS Protection, Data Migration and Backup & Rapid Restore. All of these addons will be added for purchase when you Generate configurable options.
The Generate Configurable Options creates a generic name for each chosen package, please go to System-Settings>Configurable Options menu, click on Edit to change the name to something descriptive.
##### _**These modules currently only work with the six template.**_
