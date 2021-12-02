#!/usr/bin/bash

echo "syncing HivelocityPricingTool..."
\cp -rf /root/bare-metal-provisioning-module-for-whmcs/modules/addons/HivelocityPricingTool/* /home/devedgevana/public_html/modules/addons/HivelocityPricingTool;
chown -R devedgevana:devedgevana /home/devedgevana/public_html/modules/addons/HivelocityPricingTool;


echo "syncing Hivelocity..."
\cp -rf /root/bare-metal-provisioning-module-for-whmcs/modules/servers/Hivelocity/* /home/devedgevana/public_html/modules/servers/Hivelocity;
chown -R devedgevana:devedgevana /home/devedgevana/public_html/modules/servers/Hivelocity;

echo "Done."
