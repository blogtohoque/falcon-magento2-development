<?php
declare(strict_types=1);

namespace Deity\Catalog\Model\Data;

use Deity\CatalogApi\Api\Data\ProductDetailExtensionInterface;
use Deity\CatalogApi\Api\Data\ProductDetailInterface;
use Deity\CatalogApi\Api\Data\ProductPriceInterface;
use Deity\CatalogApi\Api\Data\ProductStockInterface;
use Deity\CatalogApi\Model\FilterProductCustomAttributeInterface;
use Magento\Eav\Model\Config;
use Magento\Framework\Api\AttributeInterface;
use Magento\Framework\Api\AttributeInterfaceFactory;
use Magento\Framework\Api\ExtensionAttributesFactory;

/**
 * Class ProductDetail
 *
 * @package Deity\Catalog\Model\Data
 */
class ProductDetail implements ProductDetailInterface
{

    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $description;

    /**
     * @var string
     */
    private $image;

    /**
     * @var string
     */
    private $imageResized;

    /**
     * @var int
     */
    private $isSalable;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $sku;

    /**
     * @var string
     */
    private $typeId;

    /**
     * @var array
     */
    private $mediaGallery;

    /**
     * @var string
     */
    private $urlPath;

    /**
     * @var ProductPriceInterface
     */
    private $priceObject;

    /**
     * @var ProductStockInterface
     */
    private $stockObject;

    /**
     * @var \Magento\Catalog\Api\Data\ProductAttributeMediaGalleryEntryInterface[]
     */
    private $tierPrices;

    /**
     * @var \Magento\Catalog\Api\Data\ProductCustomOptionInterface[]
     */
    private $options;

    /**
     * @var \Magento\Catalog\Api\Data\ProductLinkInterface[]
     */
    private $productLinks;

    /**
     * @var ProductDetailExtensionInterface
     */
    private $extensionAttributes;

    /**
     * @var ExtensionAttributesFactory
     */
    private $extensionAttributesFactory;

    /**
     * @var AttributeInterface[]
     */
    private $customAttributes = [];

    /**
     * @var AttributeInterfaceFactory
     */
    private $customAttributeFactory;

    /**
     * @var string[]
     */
    private $customAttributesCodes;

    /**
     * @var Config
     */
    private $eavConfig;

    /**
     * @var FilterProductCustomAttributeInterface
     */
    private $filterCustomAttribute;

    /**
     * ProductDetail constructor.
     * @param int $id
     * @param string $description
     * @param string $image
     * @param string $image_resized
     * @param int $is_salable
     * @param string $name
     * @param string $sku
     * @param string $url_path
     * @param string $type_id
     * @param array $media_gallery_sizes
     * @param ProductPriceInterface $price
     * @param ProductStockInterface $stock
     * @param ExtensionAttributesFactory $extensionAttributesFactory
     * @param AttributeInterfaceFactory $customAttributeFactory
     * @param FilterProductCustomAttributeInterface $filterCustomAttribute
     * @param Config $config
     * @param array $tier_prices
     * @param array $options
     * @param array $product_links
     */
    public function __construct(
        int $id,
        string $description,
        string $image,
        string $image_resized,
        int $is_salable,
        string $name,
        string $sku,
        string $url_path,
        string $type_id,
        array $media_gallery_sizes,
        ProductPriceInterface $price,
        ProductStockInterface $stock,
        ExtensionAttributesFactory $extensionAttributesFactory,
        AttributeInterfaceFactory $customAttributeFactory,
        FilterProductCustomAttributeInterface $filterCustomAttribute,
        Config $config,
        array $tier_prices,
        array $options = [],
        array $product_links = []
    ) {
        $this->description = $description;
        $this->filterCustomAttribute = $filterCustomAttribute;
        $this->eavConfig = $config;
        $this->options = $options;
        $this->productLinks = $product_links;
        $this->stockObject = $stock;
        $this->tierPrices = $tier_prices;
        $this->priceObject = $price;
        $this->urlPath = $url_path;
        $this->extensionAttributesFactory = $extensionAttributesFactory;
        $this->customAttributeFactory = $customAttributeFactory;
        $this->mediaGallery = $media_gallery_sizes;
        $this->id = $id;
        $this->image = $image;
        $this->imageResized = $image_resized;
        $this->isSalable = $is_salable;
        $this->name = $name;
        $this->sku = $sku;
        $this->typeId = $type_id;
    }

    /**
     * Get product sku
     *
     * @return string
     */
    public function getSku(): string
    {
        return $this->sku;
    }

    /**
     * Get product name
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Get full size product image url
     *
     * @return string
     */
    public function getImage(): string
    {
        return $this->image;
    }

    /**
     * Get resized product image
     *
     * @return string
     */
    public function getImageResized(): string
    {
        return $this->imageResized;
    }

    /**
     * Get product type id
     *
     * @return string
     */
    public function getTypeId(): string
    {
        return $this->typeId;
    }

    /**
     * Get if product is salable
     *
     * @return int
     */
    public function getIsSalable(): int
    {
        return $this->isSalable;
    }

    /**
     * Get product id
     *
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Get media gallery items
     *
     * @return \Deity\CatalogApi\Api\Data\GalleryMediaEntrySizeInterface[]
     */
    public function getMediaGallerySizes(): array
    {
        return $this->mediaGallery;
    }

    /**
     * Get extension attributes
     *
     * @return \Deity\CatalogApi\Api\Data\ProductDetailExtensionInterface
     */
    public function getExtensionAttributes()
    {
        if (!$this->extensionAttributes) {
            $this->extensionAttributes = $this->extensionAttributesFactory->create(ProductDetailInterface::class);
        }

        return $this->extensionAttributes;
    }

    /**
     * Set extension attributes
     *
     * @param \Deity\CatalogApi\Api\Data\ProductDetailExtensionInterface $extensionAttributes
     * @return \Deity\CatalogApi\Api\Data\ProductDetailInterface
     */
    public function setExtensionAttributes(ProductDetailExtensionInterface $extensionAttributes): ProductDetailInterface
    {
        $this->extensionAttributes = $extensionAttributes;
        return $this;
    }

    /**
     * Get product url path
     *
     * @return string
     */
    public function getUrlPath(): string
    {
        return $this->urlPath;
    }

    /**
     * Get product price object
     *
     * @return \Deity\CatalogApi\Api\Data\ProductPriceInterface
     */
    public function getPrice(): ProductPriceInterface
    {
        return $this->priceObject;
    }

    /**
     * Gets list of product tier prices
     *
     * @return \Magento\Catalog\Api\Data\ProductTierPriceInterface[]|null
     */
    public function getTierPrices()
    {
        return $this->tierPrices;
    }

    /**
     * Get stock info
     *
     * @return ProductStockInterface
     */
    public function getStock(): ProductStockInterface
    {
        return $this->stockObject;
    }

    /**
     * Get product links
     *
     * @return \Magento\Catalog\Api\Data\ProductLinkInterface[]
     */
    public function getProductLinks(): array
    {
        return $this->productLinks;
    }

    /**
     * Get product options
     *
     * @return \Magento\Catalog\Api\Data\ProductCustomOptionInterface[]|null
     */
    public function getOptions(): array
    {
        return $this->options;
    }

    /**
     * Get an attribute value.
     *
     * @param string $attributeCode
     * @return \Magento\Framework\Api\AttributeInterface|null
     */
    public function getCustomAttribute($attributeCode)
    {
        return $this->customAttributes[$attributeCode] ?? null;
    }

    /**
     * Set an attribute value for a given attribute code
     *
     * @param string $attributeCode
     * @param mixed $attributeValue
     * @return $this
     */
    public function setCustomAttribute($attributeCode, $attributeValue)
    {
        $customAttributesCodes = $this->getCustomAttributesCodes();
        /* If key corresponds to custom attribute code, populate custom attributes */
        if (in_array($attributeCode, $customAttributesCodes)) {
            /** @var AttributeInterface $attribute */
            $attribute = $this->customAttributeFactory->create();
            $attribute->setAttributeCode($attributeCode)
                ->setValue($attributeValue);
            $this->customAttributes[$attributeCode] = $attribute;
        }

        return $this;
    }

    /**
     * Retrieve custom attributes values.
     *
     * @return \Magento\Framework\Api\AttributeInterface[]
     */
    public function getCustomAttributes()
    {
        return $this->customAttributes;
    }

    /**
     * Set array of custom attributes
     *
     * @param \Magento\Framework\Api\AttributeInterface[] $attributes
     * @return $this
     * @throws \LogicException
     */
    public function setCustomAttributes(array $attributes)
    {
        $customAttributesCodes = $this->getCustomAttributesCodes();
        /** @var AttributeInterface $attributeObject */
        foreach ($attributes as $attributeObject) {
            /* If key corresponds to custom attribute code, populate custom attributes */
            if (in_array($attributeObject->getAttributeCode(), $customAttributesCodes)) {
                $this->customAttributes[$attributeObject->getAttributeCode()] = $attributeObject;
            }
        }
        return $this;
    }

    /**
     * Get a list of custom attribute codes that belongs to product attribute set.
     *
     * If attribute set not specified for product will return all product attribute codes
     *
     * @return string[]
     */
    private function getCustomAttributesCodes()
    {
        if ($this->customAttributesCodes === null) {
            $this->customAttributesCodes = array_keys(
                $this->filterCustomAttribute->execute(
                    $this->eavConfig->getEntityAttributes(
                        \Magento\Catalog\Model\Product::ENTITY,
                        $this
                    )
                )
            );
        }

        return $this->customAttributesCodes;
    }

    /**
     * Get Product description
     *
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }
}
