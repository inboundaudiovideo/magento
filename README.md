## Manual Installation ( Magento 2 )
1. Under the app directory, create code/Rayms folder if its not yet exist.
2. Inside the Rayms folder, clone the repository, run ```git clone https://github.com/proaudiolink/magento.git OrderEventsBroadcaster```
3. Under the project root directory, run the following commands : 
```
bin/magento module:enable Rayms_OrderEventsBroadcaster
bin/magento setup:upgrade
bin/magento setup:di:compile
```

Done.

