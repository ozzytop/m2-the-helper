<?php

namespace Ozzytop\TheHelper\Helper;
use \Magento\Framework\App\Helper\AbstractHelper;

class Data extends AbstractHelper
{

    public function __construct(
        Data $helper,
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Cms\Model\Page $page,
        \Magento\Cms\Api\PageRepositoryInterface $pageRepositoryInterface,
        \Magento\Store\Api\Data\StoreInterface $store,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
    )
    {
        $this->helper = $helper;
        $this->_page = $page;
        $this->_pageRepositoryInterface = $pageRepositoryInterface;
        $this->_store = $store;
        $this->_storeManager = $storeManager;
        $this->scopeConfig = $scopeConfig;
    }

    public function getPageIdentifier()
    {
        return $this->_page->getIdentifier();
    }

    public function getPageId()
    {
        return $this->_page->getId();
    }

    public function getPages($id)
    {
            // If the cms page is enabled as default, is going to return 0. If is not set the default, is going
            // to retrieve every store_id
            $pages = $this->_pageRepositoryInterface->getById($id)->getData();
            $stores = $this->_store->getList();
            var_dump($stores);
            foreach($pages['store_id'] as $pageId){
                $idStore = intval($pageId);
                var_dump($this->_store->get($idStore));
            } 
            return $pages['store_id'];
    }

    public function getStores(){
        $stores = $this->_storeManager->getStores();
        foreach($stores as $store){
            $arrayStores[] = $store->getData();
        }
        return $arrayStores;        
    }
    
    public function getWebsites() {
        $websites = $this->_storeManager->getWebsites();
        foreach($websites as $website){
            $arrayWebsites[] = $website->getData();
        }
        return $arrayWebsites;
    }

    public function getLanguagesStore(){
        $localeForAllStores = [];
        $storeScope = \Magento\Store\Model\ScopeInterface::SCOPE_STORE;
        $stores = $this->_storeManager->getStores();

        foreach($stores as $store) {
            $localeForAllStores[] = $this->scopeConfig->getValue(self::GENERAL_LOCALE_CODE, $storeScope, $store->getStoreId());
        }
        return $localeForAllStores;

    }
    
    /**
     * Get store identifier
     *
     * @return  int
     */
    public function getStoreId()
    {
        return $this->_storeManager->getStore()->getId();
    }

    /**
     * Get website identifier
     *
     * @return string|int|null
     */
    public function getWebsiteId()
    {
        return $this->_storeManager->getStore()->getWebsiteId();
    }

    /**
     * Get Store code
     *
     * @return string
     */
    public function getStoreCode()
    {
        return $this->_storeManager->getStore()->getCode();
    }

    /**
     * Get Store name
     *
     * @return string
     */
    public function getStoreName()
    {
        return $this->_storeManager->getStore()->getName();
    }

    /**
     * Get current url for store
     *
     * @param bool|string $fromStore Include/Exclude from_store parameter from URL
     * @return string     
     */
    public function getStoreUrl($fromStore = true)
    {
        return $this->_storeManager->getStore()->getCurrentUrl($fromStore);
    }

    /**
     * Check if store is active
     *
     * @return boolean
     */
    public function isStoreActive()
    {
        return $this->_storeManager->getStore()->isActive();
    }
    

}