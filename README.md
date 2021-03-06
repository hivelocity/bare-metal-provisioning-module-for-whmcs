# bare-metal-provisioning-module-for-whmcs
#### Provision Hivelocity Dedicated Servers Automatically with The Bare Metal Provisioning Modules for WHMCS
##### Quick how to get started guide.
###### All you need to get started is to have the Bare Metal module installed on your WHMCS, A http://my.hivelocity.net account, and a credit card on file to order servers.
#### 1. Installation
- extract package to your main WHMCS directory
#### 2. Configuration
#### 2.1 Server
- go to Setup → Product/Services → Servers
- create server group
- add new server to the group
- select Hivelocity from Module dropdown
- use core.hivelocity.net as Hostname and your API key as Access Hash (Get this information from your https://my.hivelocity.net account.)
- save changes
#### 2.2 Product
- go to Setup → Product/Services → Product/Services
- create new product
- go to Module Settings tab
- select Your server group from the Server Group dropdown and Hivelocity from the Module
dropdown
- select Hivelocity product and credit card
- save changes
- new fields will appear
- configure product location, operating system and panel, these settings will be used if no
Configurable Options are created
- save changes
- if you want to create Configurable Options press Generate Configurable Options button
#### 2.3 Pricing Tool addon
- go to Setup → Addon Modules
- activate Hivelocity Pricing Tool module
- check Full Administrator checkbox
- save changes
- add modules\addons\HivelocityPricingTool\cron.php to your cron job table
- Pricing Tool is available at Addons → Hivelocity Pricing Tool
##### This currently only works with the six template.
