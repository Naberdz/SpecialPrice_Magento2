<?php

namespace Wemessage\SpecialPrice\Model\Product;

use Magento\Catalog\Model\Locator\LocatorInterface;
use Magento\Ui\DataProvider\Modifier\ModifierInterface;
use Magento\Ui\Component\Form\Fieldset;
use Magento\Ui\Component\Form\Field;
use Magento\Framework\Stdlib\ArrayManager;
use Magento\Catalog\Api\Data\ProductAttributeInterface;
use Magento\Framework\Pricing\PriceCurrencyInterface;

class Fields implements ModifierInterface
{

    /**
     * @var LocatorInterface
     */
    private $locator;

    /**
     * @var ArrayManager
     */
    protected $arrayManager;

    /** @var PriceCurrencyInterface $priceCurrency */
    protected $priceCurrency;

    /**
     * Fields constructor.
     *
     * @param LocatorInterface $locator
     * @param ArrayManager $arrayManager
     */
    public function __construct(
        LocatorInterface $locator,
        ArrayManager $arrayManager,
        PriceCurrencyInterface $priceCurrency,
    ) {
        $this->locator = $locator;
        $this->arrayManager = $arrayManager;
        $this->priceCurrency = $priceCurrency;
    }

    /**
     * Modify Meta
     *
     * @param array $meta
     * @return array
     */
    public function modifyMeta(array $meta)
    {
        $product = $this->locator->getProduct();

        $containerPath = $this->arrayManager->findPath(ProductAttributeInterface::CODE_PRICE, $meta, null, 'children');

        // Check if the product has a special price set
        if ($product && $this->isSpecialPriceValid($product)) {
            // Add the special price after the price field 
            $meta = $this->arrayManager->merge($containerPath, $meta, [
                'arguments' => [
                    'data' => [
                        'config' => [
                            'additionalInfo' => '<strong style="color:red;">'.$this->priceCurrency->convertAndFormat($product->getSpecialPrice(), false, 2).'</strong>'
                        ]
                    ]
                ]

            ]);
        }
        return $meta;
    }

    /**
     * Modify Data
     *
     * @param array $data
     * @return array
     */
    public function modifyData(array $data)
    {
        return $data;
    }

    /**
     * Check if the product has a valid special price
     *
     * @param $product
     * @return bool
     */
    private function isSpecialPriceValid($product)
    {
        // Check if the special price is set
        if ($product->getSpecialPrice() !== null) {
            $currentDate = date('Y-m-d');

            // Check if the special price's start and end date are valid (if set)
            $specialFromDate = $product->getSpecialFromDate();
            $specialToDate = $product->getSpecialToDate();

            $isValidFrom = !$specialFromDate || strtotime($specialFromDate) <= strtotime($currentDate);
            $isValidTo = !$specialToDate || strtotime($specialToDate) >= strtotime($currentDate);

            // Return true if special price is valid
            if ($isValidFrom && $isValidTo) {
                return true;
            }
        }

        return false;
    }
}

