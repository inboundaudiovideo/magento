## Manual Installation ( Magento 2 )
1. Under the app directory, create code/Rayms/OrderEventsBroadcaster folder if its not yet exist.
2. Inside the OrderEventsBroadcaster folder, clone the repository, run ```git clone https://github.com/proaudiolink/magento.git```
3. Under the project root directory, run the following commands : 
```
bin/magento setup:upgrade
bin/magento setup:di:compile
```

## Manual Installation ( Magento 1 )
1. Under the app/code/local directory, create Rayms/OrderEventsBroadcaster folder if its not yet exist.
2. Inside the OrderEventsBroadcaster folder, clone the repository, run ```git clone -b version-magento1 --single-branch https://github.com/proaudiolink/magento.git```
3. Go to the project root directory, delete cache folder found inside the var directory.


Done.

