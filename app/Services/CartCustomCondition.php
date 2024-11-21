<?php
namespace App\Services;

use Darryldecode\Cart\CartCondition;

class CartCustomCondition extends CartCondition {
    public function apply($totalOrSubTotalOrPrice, $conditionValue)
    {
        if ( $this->valueIsPercentage($conditionValue) ) {
            if ( $this->valueIsToBeSubtracted($conditionValue) ) {
                $price = $totalOrSubTotalOrPrice;
                if ($this->getTarget() == 'subtotal') {
                    $price = \Cart::getSubTotal();
                } elseif ($this->getTarget() == 'total'){
                    $price = \Cart::getTotal();
                }

                $value = Helpers::normalizePrice( $this->cleanValue($conditionValue) );
                $this->parsedRawValue = $price * ($value / 100);
                $result = floatval($totalOrSubTotalOrPrice - $this->parsedRawValue);
            } else if ( $this->valueIsToBeAdded($conditionValue) ) {
                $value = Helpers::normalizePrice( $this->cleanValue($conditionValue) );
                $this->parsedRawValue = $totalOrSubTotalOrPrice * ($value / 100);
                $result = floatval($totalOrSubTotalOrPrice + $this->parsedRawValue);
            } else {
                $value = Helpers::normalizePrice($conditionValue);
                $this->parsedRawValue = $totalOrSubTotalOrPrice * ($value / 100);
                $result = floatval($totalOrSubTotalOrPrice + $this->parsedRawValue);
            }
        } else {
            if( $this->valueIsToBeSubtracted($conditionValue) ) {
                $this->parsedRawValue = Helpers::normalizePrice( $this->cleanValue($conditionValue) );
                $result = floatval($totalOrSubTotalOrPrice - $this->parsedRawValue);
            } else if ( $this->valueIsToBeAdded($conditionValue) ) {
                $this->parsedRawValue = Helpers::normalizePrice( $this->cleanValue($conditionValue) );
                $result = floatval($totalOrSubTotalOrPrice + $this->parsedRawValue);
            } else {
                $this->parsedRawValue = Helpers::normalizePrice($conditionValue);
                $result = floatval($totalOrSubTotalOrPrice + $this->parsedRawValue);
            }
        }

        return $result < 0 ? 0.00 : $result;
    }

    public function getCalculatedValue($totalOrSubTotalOrPrice)
    {
        $this->apply($totalOrSubTotalOrPrice, $this->getValue());
        return $this->parsedRawValue;
    }
}