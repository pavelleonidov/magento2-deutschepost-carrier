# Deutsche Post Carrier for Magento 2
 
This module adds an additional "Deutsche Post" carrier for your Magento 2 installation

## Requirements

The Deutsche Post carrier module is tested and working with Magento 2.1.x and Magento 2.2.x

## Installation

Via composer in the root directory of your Magento 2 installation:

```
composer config repositories.magento2-deutschepost-carrier git git@github.com:pavelleonidov/magento2-deutschepost-carrier.git;
composer require pavelleonidov/magento2-deutschepost-carrier
php bin/magento setup:upgrade && php bin/magento setup:di:compile
```

After completing these steps, select Stores -> Configuration -> SALES -> Shipping Methods in your Magento 2 backend and activate the Deutsche Post shipping method