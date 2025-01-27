# Special Price Visibility for Magento2
A Magento 2 plugin that shows SpecialPrice if available at product edit page.

The main reason for this module is to notify customer if product has Special Price without the need to click on Advanced Pricing button.


![Scherm­afbeelding 2025-01-27 om 14 43 41](https://github.com/user-attachments/assets/ea476d74-8996-48f0-9fae-3ea522030ab0)

# Installation From github
1. Create directory: `mkdir -p app/code/Wemessage/SpecialPrice`
2. Download and copy the files from this repository to the above folder
3. Run following commands:
   ```
   bin/magento mo:en Wemessage_SpecialPrice
   bin/magento s:up --keep-generated
   bin/magento c:c
   ```


# Installation with composer
1.  Run following commands:
   ```
   composer require wemessage/module-specialprice-magento2
   bin/magento mo:en Wemessage_SpecialPrice
   bin/magento s:up --keep-generated
   bin/magento c:c
   ```
