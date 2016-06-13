<?php

namespace TurnTo\SocialCommerce\Helper;

use Magento\Store\Model\ScopeInterface;

/**
 * Class Config - Assists with retrieval of TurnTo configuration settings
 *
 * @package TurnTo\SocialCommerce\Helper
 */
class Config extends \Magento\Framework\App\Helper\AbstractHelper
{
    /**
     * General Settings
     */
    const XML_PATH_SOCIALCOMMERCE_ENABLED = 'turnto_socialcommerce_configuration/general/enabled';
    
    const XML_PATH_SOCIALCOMMERCE_SITE_KEY = 'turnto_socialcommerce_configuration/general/site_key';

    const XML_PATH_SOCIALCOMMERCE_AUTHORIZATION_KEY = 'turnto_socialcommerce_configuration/general/authorization_key';
    
    const XML_PATH_SOCIALCOMMERCE_VERSION = 'turnto_socialcommerce_configuration/general/version';

    const XML_PATH_SOCIALCOMMERCE_URL = 'turnto_socialcommerce_configuration/general/url';

    const XML_PATH_SOCIALCOMMERCE_STATIC_URL = 'turnto_socialcommerce_configuration/general/static_url';

    const XML_PATH_SOCIALCOMMERCE_AUTHENTICATION_KEY = 'turnto_socialcommerce_configuration/general/authentication_key';

    /**
     * Product Groups
     */
    const XML_PATH_SOCIALCOMMERCE_PRODUCT_GROUP = 'turnto_socialcommerce_configuration/product_attribute_mappings/';

    const UPC_ATTRIBUTE = 'upc_attribute';

    const MPN_ATTRIBUTE = 'mpn_attribute';

    const ISBN_ATTRIBUTE = 'isbn_attribute';

    const EAN_ATTRIBUTE = 'ean_attribute';

    const JAN_ATTRIBUTE = 'jan_attribute';

    const ASIN_ATTRIBUTE = 'asin_attribute';

    const BRAND_ATTRIBUTE = 'brand_attribute';

    const PRODUCT_ATTRIBUTE_MAPPING_KEYS = [
        self::UPC_ATTRIBUTE,
        self::MPN_ATTRIBUTE,
        self::ISBN_ATTRIBUTE,
        self::EAN_ATTRIBUTE,
        self::JAN_ATTRIBUTE,
        self::ASIN_ATTRIBUTE,
        self::BRAND_ATTRIBUTE
    ];

    /**#@+
     * XPATH's for module config settings
     */
    const XML_PATH_ENABLED = 'turnto_socialcommerce_configuration/general/enabled';

    const XML_PATH_SITE_KEY = 'turnto_socialcommerce_configuration/general/site_key';

    const XML_PATH_VERSION = 'turnto_socialcommerce_configuration/general/version';

    const XML_PATH_AUTHORIZATION_KEY = 'turnto_socialcommerce_configuration/general/authorization_key';

    const XML_PATH_SOCIALCOMMERCE_ENABLE_QA = 'turnto_socialcommerce_configuration/qa/enable_qa';

    const XML_PATH_SOCIALCOMMERCE_ENABLE_QA_TEASER = 'turnto_socialcommerce_configuration/qa/enable_qa_teaser';

    const XML_PATH_SOCIALCOMMERCE_SETUP_TYPE = 'turnto_socialcommerce_configuration/question_answer/setup_type';

    const XML_PATH_SOCIALCOMMERCE_ENABLE_REVIEWS = 'turnto_socialcommerce_configuration/reviews/enable_reviews';

    const XML_PATH_SOCIALCOMMERCE_ENABLE_REVIEWS_TEASER = 'turnto_socialcommerce_configuration/reviews/enable_reviews_teaser';

    const XML_PATH_SOCIALCOMMERCE_REVIEWS_SETUP_TYPE = 'turnto_socialcommerce_configuration/reviews/reviews_setup_type';

    const XML_PATH_ENABLE_PRODUCT_FEED_SUBMISSION = 'turnto_socialcommerce_configuration/product_feed/enable_automatic_submission';

    const XML_PATH_FEED_SUBMISSION_URL = 'turnto_socialcommerce_configuration/product_feed/feed_submission_url';

    const XML_PATH_PRODUCT_GROUP = 'turnto_socialcommerce_configuration/product_attribute_mappings/';
    /**#@-*/

    /**
     * Config constructor.
     * @param \Magento\Framework\App\Helper\Context $context
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     */
    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        \Magento\Store\Model\StoreManagerInterface $storeManager
    ) {
        $this->storeManager = $storeManager;
        parent::__construct($context);
    }

    /**
     * Gets the store code from the currently set/scoped store
     * @return string
     */
    protected function getCurrentStoreCode()
    {
        return $this->storeManager->getStore()->getCode();
    }

    /**
     * Gets the value of the setting that determines if TurnTo's configuration is enabled
     *
     * @param $scopeType
     * @param $scopeCode
     * @return mixed
     */
    public function getIsEnabled($scopeCode)
    {
        return $this->scopeConfig->getValue(
            self::XML_PATH_ENABLED,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE,
            $scopeCode
        );
    }

    /**
     * Gets the value of the setting that determines if automated Product Feed Submission is enabled
     *
     * @param $store = null
     * @return mixed
     */
    public function getIsProductFeedSubmissionEnabled($scopeCode)
    {
        return $this->scopeConfig->getValue(self::XML_PATH_ENABLE_PRODUCT_FEED_SUBMISSION,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE,
            $scopeCode
        );
    }

    /**
     * Gets the TurnTo Site Key
     *
     * @return mixed
     */
    public function getSiteKey($scopeCode)
    {
        return $this->scopeConfig->getValue(self::XML_PATH_SITE_KEY,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE,
            $scopeCode
        );
    }

    /**
     * Gets the TurnTo API Version
     *
     * @param $store = null
     * @return mixed
     */
    public function getTurnToVersion($scopeCode)
    {
        return str_replace(
            '.',
            '_',
            $this->scopeConfig->getValue(self::XML_PATH_VERSION,
                \Magento\Store\Model\ScopeInterface::SCOPE_STORE,
                $scopeCode
            )
        );
    }
    
    public function getStaticUrl($store = null)
    {
        return $this->scopeConfig->getValue(
            self::XML_PATH_SOCIALCOMMERCE_STATIC_URL,
            ScopeInterface::SCOPE_STORE,
            isset($store) ? $store : $this->getCurrentStoreCode()
        );
    }

    public function getUrl($store = null)
    {
        return $this->scopeConfig->getValue(
            self::XML_PATH_SOCIALCOMMERCE_URL,
            ScopeInterface::SCOPE_STORE,
            isset($store) ? $store : $this->getCurrentStoreCode()
        );
    }

    public function getStaticUrlWithoutProtocol($store = null)
    {
        return $this->removeProtocol($this->getStaticUrl($store));
    }

    public function getUrlWithoutProtocol($store = null)
    {
        return $this->removeProtocol($this->getUrl($store));
    }

    function removeProtocol($url)
    {
        $disallowed = array('http://', 'https://');
        foreach($disallowed as $d) {
            if(strpos($url, $d) === 0) {
                return str_replace($d, '', $url);
            }
        }
        return $url;
    }

    /**
     * Gets the TurnTo API Authorization Key
     *
     * @return mixed
     */
    public function getAuthorizationKey($scopeCode)
    {
        return $this->scopeConfig->getValue(self::XML_PATH_AUTHORIZATION_KEY,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE,
            $scopeCode
        );
    }

    /**
     * Gets the TurnTo URL to send a feed to
     *
     * @return mixed
     */
    public function getFeedUploadAddress($scopeCode)
    {
        return $this->scopeConfig->getValue(self::XML_PATH_FEED_SUBMISSION_URL,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE,
            $scopeCode
        );
    }

    /**
     * Gets the Product Attribute Code that corresponds to the mapping key (see constants on this class)
     *
     * @param $mappingKey
     * @param $scopeType
     * @param $scopeCode
     * @return mixed
     */
    public function getProductAttributeMapping($mappingKey, $scopeCode)
    {
        return $this->scopeConfig->getValue(self::XML_PATH_PRODUCT_GROUP . $mappingKey,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE,
            $scopeCode
        );
    }

    /**
     * Gets an associative array of any set product attributes related to GTIN, key => mappingKey, value => attr_code
     *
     * @return array
     */
    public function getGtinAttributesMap($scopeCode)
    {
        $gtinMap = [];
        foreach (self::PRODUCT_ATTRIBUTE_MAPPING_KEYS as $mappingKey) {
            $tempResult = null;
            $tempResult = $this->getProductAttributeMapping($mappingKey, $scopeCode);
            if (!empty($tempResult)) {
                $gtinMap[$mappingKey] = $tempResult;
            }
        }
        return $gtinMap;
    }

    public function getQaEnabled($store = null)
    {
        return $this->scopeConfig->getValue(
            self::XML_PATH_SOCIALCOMMERCE_ENABLE_QA,
            ScopeInterface::SCOPE_STORE,
            isset($store) ? $store : $this->getCurrentStoreCode()
        );
    }

    public function getQaTeaserEnabled($store = null)
    {
        return $this->scopeConfig->getValue(
            self::XML_PATH_SOCIALCOMMERCE_ENABLE_QA_TEASER,
            ScopeInterface::SCOPE_STORE,
            isset($store) ? $store : $this->getCurrentStoreCode()
        );
    }

    /**
     * Gets the Question and Answer Setup Type configuration value
     *
     * @return mixed
     */
    public function getSetupType($store = null)
    {
        return $this->scopeConfig->getValue(
            self::XML_PATH_SOCIALCOMMERCE_SETUP_TYPE,
            ScopeInterface::SCOPE_STORE,
            isset($store) ? $store : $this->getCurrentStoreCode()
        );
    }

    public function getReviewsEnabled($store = null)
    {
        return $this->scopeConfig->getValue(
            self::XML_PATH_SOCIALCOMMERCE_ENABLE_REVIEWS,
            ScopeInterface::SCOPE_STORE,
            isset($store) ? $store : $this->getCurrentStoreCode()
        );
    }

    public function getReviewsTeaserEnabled($store = null)
    {
        return $this->scopeConfig->getValue(
            self::XML_PATH_SOCIALCOMMERCE_ENABLE_REVIEWS_TEASER,
            ScopeInterface::SCOPE_STORE,
            isset($store) ? $store : $this->getCurrentStoreCode()
        );
    }

    /**
     * Gets the Reviews Setup Type configuration value
     *
     * @return mixed
     */
    public function getReviewsSetupType($store = null)
    {
        return $this->scopeConfig->getValue(
            self::XML_PATH_SOCIALCOMMERCE_REVIEWS_SETUP_TYPE,
            ScopeInterface::SCOPE_STORE,
            isset($store) ? $store : $this->getCurrentStoreCode()
        );
    }


}