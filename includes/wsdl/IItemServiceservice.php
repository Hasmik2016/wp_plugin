<?php
if (!class_exists("TRecordOptions")) {
    /**
     * TRecordOptions
     */
    class TRecordOptions
    {
    }
}
if (!class_exists("TRecord")) {
    /**
     * TRecord
     */
    class TRecord
    {
    }
}
if (!class_exists("TExtraProperty")) {
    /**
     * TExtraProperty
     */
    class TExtraProperty
    {
    }
}
if (!class_exists("TDeletedOptions")) {
    /**
     * TDeletedOptions
     */
    class TDeletedOptions
    {
    }
}
if (!class_exists("TDeletedRecord")) {
    /**
     * TDeletedRecord
     */
    class TDeletedRecord
    {
    }
}
if (!class_exists("TSystemSettingGetOption")) {
    /**
     * TSystemSettingGetOption
     */
    class TSystemSettingGetOption
    {
    }
}
if (!class_exists("TSystemSettings")) {
    /**
     * TSystemSettings
     */
    class TSystemSettings
    {
    }
}
if (!class_exists("TSystemInformation")) {
    /**
     * TSystemInformation
     */
    class TSystemInformation
    {
    }
}
if (!class_exists("TDimmensionSetting")) {
    /**
     * TDimmensionSetting
     */
    class TDimmensionSetting
    {
    }
}
if (!class_exists("TProjectSetting")) {
    /**
     * TProjectSetting
     */
    class TProjectSetting
    {
    }
}
if (!class_exists("TGeneralSetting")) {
    /**
     * TGeneralSetting
     */
    class TGeneralSetting
    {
    }
}
if (!class_exists("TInventorySetting")) {
    /**
     * TInventorySetting
     */
    class TInventorySetting
    {
    }
}
if (!class_exists("TCustomerSetting")) {
    /**
     * TCustomerSetting
     */
    class TCustomerSetting
    {
    }
}
if (!class_exists("TVendorSetting")) {
    /**
     * TVendorSetting
     */
    class TVendorSetting
    {
    }
}
if (!class_exists("TSaleSetting")) {
    /**
     * TSaleSetting
     */
    class TSaleSetting
    {
    }
}
if (!class_exists("TRegistrationEntry")) {
    /**
     * TRegistrationEntry
     */
    class TRegistrationEntry
    {
    }
}
if (!class_exists("TGLJournalHead")) {
    /**
     * TGLJournalHead
     */
    class TGLJournalHead
    {
    }
}
if (!class_exists("TGLJournalLine")) {
    /**
     * TGLJournalLine
     */
    class TGLJournalLine
    {
    }
}
if (!class_exists("TGeneralLedgerOptions")) {
    /**
     * TGeneralLedgerOptions
     */
    class TGeneralLedgerOptions
    {
    }
}
if (!class_exists("TGeneralLedgerAccountGetOptions")) {
    /**
     * TGeneralLedgerAccountGetOptions
     */
    class TGeneralLedgerAccountGetOptions
    {
    }
}
if (!class_exists("TGeneralLedgerAccount")) {
    /**
     * TGeneralLedgerAccount
     */
    class TGeneralLedgerAccount
    {
    }
}
if (!class_exists("TItemOptions")) {
    /**
     * TItemOptions
     */
    class TItemOptions
    {
        public $IncludeBarCodes = false;
        public $IncludeGroups = false;
        public $IncludeItemCategories = false;
        public $IncludeUnitcodes = false;
        public $OnlyGetWebshopItems = false;
        public $IncludeWarehouse = false;
        public $IfNotFoundReturnNil = false;
        public $ShowAllAttachments = false;
        public $OnlyMedicine = false;
        public $IncludeChanges = false;
        public $IncludeAttachments = false;
        public $IncludeAlternative = false;
        public $DisableCategorieCheck = false;
        public $DisableTransactionCheck = false;
        public $IncludeVendorLinks = false;
        public $ExtraProperties = false;

    }
}
if (!class_exists("TItem")) {
    /**
     * TItem
     */
    class TItem
    {
        public $RecordId;
        public $RecordCreated;
        public $RecordModified;
        public $ItemCode;
        public $AliasItemCode;
        public $Description;
        public $Description2;
        public $Group;
        public $ItemClass;
        public $UnitCode;
        public $UnitQuantity;
        public $NetWeight;
        public $UnitVolume;
        public $TotalQuantityInWarehouse;
        public $PurchasePrice;
        public $CurrencyCode;
        public $Exchange;
        public $Purchasefactor;
        public $CostPrice;
        public $ProfitRatio1;
        public $UnitPrice1;
        public $UnitPrice1WithTax;
        public $UnitPrice2;
        public $UnitPrice2WithTax;
        public $UnitPrice3;
        public $UnitPrice3WithTax;
        public $PropositionPrice;
        public $PropositionDateTo;
        public $ShowItemInWebShop;
        public $CurrPrices;
        public $ItemCategories;
        public $ExtraDesc1;
        public $ExtraDesc2;
        public $IsVariation;
        public $Variation;
        public $TaxPercent;
        public $BarCodes;
        public $AllowNegativeInventiry;
        public $AllowDiscount;
        public $DiscountQuantity;
        public $Discount;
        public $MaxDiscountAllowed;
        public $Inactive;
        public $Warehouses;
        public $DefaultSaleQuantity;
        public $Changes;
        public $Attachments;
        public $VendorLinks;
        public $UnitCodes;
        public $ExtraProperties;
        public $Alternative;
    }
}
if (!class_exists("TCurrencyPrice")) {
    /**
     * TCurrencyPrice
     */
    class TCurrencyPrice
    {
    }
}
if (!class_exists("TItemCategory")) {
    /**
     * TItemCategory
     */
    class TItemCategory
    {
    }
}
if (!class_exists("TItemSubCategory")) {
    /**
     * TItemSubCategory
     */
    class TItemSubCategory
    {
    }
}
if (!class_exists("TVariation")) {
    /**
     * TVariation
     */
    class TVariation
    {
    }
}
if (!class_exists("TBarCode")) {
    /**
     * TBarCode
     */
    class TBarCode
    {
    }
}
if (!class_exists("TCustomerItemReceiverBarCode")) {
    /**
     * TCustomerItemReceiverBarCode
     */
    class TCustomerItemReceiverBarCode extends TBarCode
    {
    }
}
if (!class_exists("TWharehouseItem")) {
    /**
     * TWharehouseItem
     */
    class TWharehouseItem
    {
    }
}
if (!class_exists("TRecordChange")) {
    /**
     * TRecordChange
     */
    class TRecordChange
    {
    }
}
if (!class_exists("TFieldChanges")) {
    /**
     * TFieldChanges
     */
    class TFieldChanges
    {
    }
}
if (!class_exists("TAttachment")) {
    /**
     * TAttachment
     */
    class TAttachment
    {
    }
}
if (!class_exists("TItemVendorLink")) {
    /**
     * TItemVendorLink
     */
    class TItemVendorLink
    {
    }
}
if (!class_exists("TItemUnit")) {
    /**
     * TItemUnit
     */
    class TItemUnit
    {
    }
}
if (!class_exists("TItemCriteria")) {
    /**
     * TItemCriteria
     */
    class TItemCriteria
    {
    }
}
if (!class_exists("TItemUnits")) {
    /**
     * TItemUnits
     */
    class TItemUnits
    {
    }
}
if (!class_exists("TCustomerItemReceiverLocationLink")) {
    /**
     * TCustomerItemReceiverLocationLink
     */
    class TCustomerItemReceiverLocationLink
    {
    }
}
if (!class_exists("TInventoryJournal")) {
    /**
     * TInventoryJournal
     */
    class TInventoryJournal
    {
    }
}
if (!class_exists("TInventoryJournalLine")) {
    /**
     * TInventoryJournalLine
     */
    class TInventoryJournalLine
    {
    }
}
if (!class_exists("TInventorying")) {
    /**
     * TInventorying
     */
    class TInventorying
    {
    }
}
if (!class_exists("TInventoryingLine")) {
    /**
     * TInventoryingLine
     */
    class TInventoryingLine
    {
    }
}
if (!class_exists("TInventoryTransfer")) {
    /**
     * TInventoryTransfer
     */
    class TInventoryTransfer
    {
    }
}
if (!class_exists("TVendor")) {
    /**
     * TVendor
     */
    class TVendor
    {
    }
}
if (!class_exists("TInvoice")) {
    /**
     * TInvoice
     */
    class TInvoice
    {

        public $Options;
        public $RecordID;
        public $InvoiceNumber;
        public $OrderNumber;
        public $Origin;
        public $SalesOrderType;
        public $CustomerNumber;
        public $Customer;
        public $InvoiceDate;
        public $SalePerson;
        public $TotalAmount;
        public $TotalAmountWithTax;
        public $ItemReceiver;
        public $ItemReciverContact;
        public $ContactNumber;
        public $Contact;
        public $Lines;
        public $Payments;
        public $PaymentTerm;
        public $ReferenceNumber;
        public $Reference;
        public $CurrencyCode;
        public $Text1;
        public $Text2;
        public $Dim1;
        public $Job;
        public $ClaimStatus;
        public $SettledType;
        public $SettledAmount;
        public $Discount;
        public $DiscountPercent;
        public $ExtraProperties;
        public $AttachmentFile;
        public $Exchange;
    }
}
if (!class_exists("TInvoiceOptions")) {
    /**
     * TInvoiceOptions
     */
    class TInvoiceOptions
    {

        public $Customer;
        public $Contact;
        public $Itemreciver;
        public $Job;
        public $Reference;
        public $FindNewPrices;
        public $isPrescription;
        public $IncludeAttachment;
        public $ExtraProperties;
        public $LineExtraProperties;
    }
}
if (!class_exists("TActionMethod")) {
    /**
     * TActionMethod
     */
    class TActionMethod
    {
    }
}
if (!class_exists("TSalesOrderType")) {
    /**
     * TSalesOrderType
     */
    class TSalesOrderType
    {
    }
}
if (!class_exists("TCustomer")) {
    /**
     * TCustomer
     */
    class TCustomer
    {
        public $RecordID;
        public $Number;
        public $Name;
        public $SSNumber;
        public $Address1;
        public $Address2;
        public $Address3;
        public $Address4;
        public $ZipCode;
        public $City;
        public $CountryCode;
        public $CountryName;
        public $CountyCode;
        public $OriginCountryCode;
        public $Phone;
        public $PhoneLocal;
        public $PhoneMobile;
        public $PhoneFax;
        public $Email;
        public $Password;
        public $Group;
        public $SalesPerson;
        public $Discount;
        public $ItemReceivers;
        public $UseItemReceiver;
        public $Contacts;
        public $PaymentTerm;
        public $PaymentMode;
        public $BSSID;
        public $BSSCondition;
        public $CurrencyCode;
        public $NoVat;
        public $LedgerCode;
        public $RecordCreated;
        public $RecordModified;
        public $Blocked;
        public $Gender;
        public $CreditCard;
        public $PriceGroup;
        public $BillingFree;
        public $Properties;
        public $Memos;
        public $Changes;
        public $Attachments;
        public $Invoices;
        public $BalanceAmount;
        public $Jobs;
        public $ExtraProperties;
    }
}
if (!class_exists("TGender")) {
    /**
     * TGender
     */
    class TGender
    {
    }
}
if (!class_exists("TCreditCard")) {
    /**
     * TCreditCard
     */
    class TCreditCard
    {
    }
}
if (!class_exists("TItemReceiver")) {
    /**
     * TItemReceiver
     */
    class TItemReceiver
    {

        public $Customer;
        public $Number;
        public $Name;
        public $Address1;
        public $Address2;
        public $Address3;
        public $Address4;
        public $ZipCode;
        public $City;
        public $CountryCode;
        public $SSNumber;
        public $Phone;
        public $PhoneLocal;
        public $PhoneMobile;
        public $Fax;
        public $Email;
        public $URL;
        public $Telex;
        public $EANNumber;
        public $VATNumber;
        public $Blocked;
        public $Modified;
    }
}
if (!class_exists("TContact")) {
    /**
     * TContact
     */
    class TContact
    {
    }
}
if (!class_exists("TReference")) {
    /**
     * TReference
     */
    class TReference
    {
    }
}
if (!class_exists("TJob")) {
    /**
     * TJob
     */
    class TJob
    {
    }
}
if (!class_exists("TAttachmentFile")) {
    /**
     * TAttachmentFile
     */
    class TAttachmentFile
    {
    }
}
if (!class_exists("TCustomerProperty")) {
    /**
     * TCustomerProperty
     */
    class TCustomerProperty
    {
    }
}
if (!class_exists("TMemo")) {
    /**
     * TMemo
     */
    class TMemo
    {
    }
}
if (!class_exists("TInvoiceEntry")) {
    /**
     * TInvoiceEntry
     */
    class TInvoiceEntry
    {
    }
}
if (!class_exists("TInvoiceLine")) {
    /**
     * TInvoiceLine
     */
    class TInvoiceLine
    {
        public $SequenceNumber;
        public $ItemCode;
        public $Text;
        public $Text2;
        public $Warehouse;
        public $Quantity;
        public $UnitCode;
        public $UnitPrice;
        public $UnitPriceWithTax;
        public $Discount;
        public $DiscountAmount;
        public $DiscountAmountWithTax;
        public $TotalAmount;
        public $TotalAmountWithTax;
        public $Variations;
        public $Dim1;
        public $ExtraProperties;
    }
}
if (!class_exists("TPayment")) {
    /**
     * TPayment
     */
    class TPayment
    {

        public $PaymentTypeId;
        public $Amount;
    }
}
if (!class_exists("TItemWarehouse")) {
    /**
     * TItemWarehouse
     */
    class TItemWarehouse
    {
    }
}
if (!class_exists("TItemGroup")) {
    /**
     * TItemGroup
     */
    class TItemGroup
    {
    }
}
if (!class_exists("TCustomerOptions")) {
    /**
     * TCustomerOptions
     */
    class TCustomerOptions
    {
        public $IncludeContacts = false;
        public $IncludeItemRecievers = false;
        public $IncludeProperties = false;
        public $IncludeMemos = false;
        public $HTMLEncodeMemos = false;
        public $IncludeChanges = false;
        public $IncludeAttachments = false;
        public $ShowAllAttachments = false;
        public $IncludeJobs = false;
        public $ExtraProperties = false;
        public $LookupTransactions = false;
        public $IncludeInvoiceList = false;
        public $ItemReciver = false;
        public $InvoiceLimitFrom = false;
    }
}
if (!class_exists("TCustomerGroup")) {
    /**
     * TCustomerGroup
     */
    class TCustomerGroup
    {
    }
}
if (!class_exists("TBalance")) {
    /**
     * TBalance
     */
    class TBalance
    {
    }
}
if (!class_exists("TCustomerPaymentTerm")) {
    /**
     * TCustomerPaymentTerm
     */
    class TCustomerPaymentTerm
    {
    }
}
if (!class_exists("TCustomerPaymentMode")) {
    /**
     * TCustomerPaymentMode
     */
    class TCustomerPaymentMode
    {
    }
}
if (!class_exists("TPaymentMode")) {
    /**
     * TPaymentMode
     */
    class TPaymentMode
    {
    }
}
if (!class_exists("TPaymentTerm")) {
    /**
     * TPaymentTerm
     */
    class TPaymentTerm
    {
    }
}
if (!class_exists("TCustomerLedgerCode")) {
    /**
     * TCustomerLedgerCode
     */
    class TCustomerLedgerCode
    {
    }
}
if (!class_exists("TSubscriptionType")) {
    /**
     * TSubscriptionType
     */
    class TSubscriptionType
    {
    }
}
if (!class_exists("TSubscription")) {
    /**
     * TSubscription
     */
    class TSubscription
    {
    }
}
if (!class_exists("TSubscriber")) {
    /**
     * TSubscriber
     */
    class TSubscriber
    {
    }
}
if (!class_exists("TTrialSubscription")) {
    /**
     * TTrialSubscription
     */
    class TTrialSubscription
    {
    }
}
if (!class_exists("TSubscriptionRate")) {
    /**
     * TSubscriptionRate
     */
    class TSubscriptionRate
    {
    }
}
if (!class_exists("TSubscriptionDiscount")) {
    /**
     * TSubscriptionDiscount
     */
    class TSubscriptionDiscount
    {
    }
}
if (!class_exists("TSubscriptionOptions")) {
    /**
     * TSubscriptionOptions
     */
    class TSubscriptionOptions
    {
    }
}
if (!class_exists("TVendorItem")) {
    /**
     * TVendorItem
     */
    class TVendorItem
    {
    }
}
if (!class_exists("TVendorTransactionsOptions")) {
    /**
     * TVendorTransactionsOptions
     */
    class TVendorTransactionsOptions
    {
    }
}
if (!class_exists("TVendorTransaction")) {
    /**
     * TVendorTransaction
     */
    class TVendorTransaction
    {
    }
}
if (!class_exists("TVendorInvoiceOptions")) {
    /**
     * TVendorInvoiceOptions
     */
    class TVendorInvoiceOptions
    {
    }
}
if (!class_exists("TVendorInvoiceType")) {
    /**
     * TVendorInvoiceType
     */
    class TVendorInvoiceType
    {
    }
}
if (!class_exists("TVendorInvoice")) {
    /**
     * TVendorInvoice
     */
    class TVendorInvoice
    {
    }
}
if (!class_exists("TVendorInvoiceApproval")) {
    /**
     * TVendorInvoiceApproval
     */
    class TVendorInvoiceApproval
    {
    }
}
if (!class_exists("TVendorInvoiceLine")) {
    /**
     * TVendorInvoiceLine
     */
    class TVendorInvoiceLine
    {
    }
}
if (!class_exists("TPurchaseOrder")) {
    /**
     * TPurchaseOrder
     */
    class TPurchaseOrder
    {
    }
}
if (!class_exists("TPurchaseOrderLine")) {
    /**
     * TPurchaseOrderLine
     */
    class TPurchaseOrderLine
    {
    }
}
if (!class_exists("TPurchaseOptions")) {
    /**
     * TPurchaseOptions
     */
    class TPurchaseOptions
    {
    }
}
if (!class_exists("TSubscriptionOrderFilter")) {
    /**
     * TSubscriptionOrderFilter
     */
    class TSubscriptionOrderFilter
    {
    }
}
if (!class_exists("TEmployee")) {
    /**
     * TEmployee
     */
    class TEmployee
    {
    }
}
if (!class_exists("TTimeClockStampType")) {
    /**
     * TTimeClockStampType
     */
    class TTimeClockStampType
    {
    }
}
if (!class_exists("TInvoiceGetOptions")) {
    /**
     * TInvoiceGetOptions
     */
    class TInvoiceGetOptions
    {
    }
}
if (!class_exists("TInvoiceClaim")) {
    /**
     * TInvoiceClaim
     */
    class TInvoiceClaim
    {
    }
}
if (!class_exists("TSaleStatisticOptions")) {
    /**
     * TSaleStatisticOptions
     */
    class TSaleStatisticOptions
    {
    }
}
if (!class_exists("TSalesStatistic")) {
    /**
     * TSalesStatistic
     */
    class TSalesStatistic
    {
    }
}
if (!class_exists("TOrder")) {
    /**
     * TOrder
     */
    class TOrder
    {
        public $OrderNumber;
        public $Customer;
        public $OrderDate;
        public $SalePerson;
        public $TotalAmount;
        public $ItemReceiver;
        public $Contact;
        public $Lines;
        public $ReferenceNumber;
        public $CustomerOrderNo;
        public $CurrencyCode;
        public $Text1;
        public $Text2;
        public $Goodsmarking;
        public $CustomerOrderDate;
        public $RequestedDeliveryDate;
        public $Options;
        public $Status;
        public $DeliveryStatus;
        public $ConfirmedDeliveryDate;
        public $FinalDeliveryDate;
        public $OrgSalesOrderDate;
        public $ExtraProperties;
    }
}
if (!class_exists("TOrderOptions")) {
    /**
     * TOrderOptions
     */
    class TOrderOptions
    {
    }
}
if (!class_exists("TOrderLine")) {
    /**
     * TOrderLine
     */
    class TOrderLine
    {
    }
}
if (!class_exists("TPaymentPlanRequest")) {
    /**
     * TPaymentPlanRequest
     */
    class TPaymentPlanRequest
    {
    }
}
if (!class_exists("TPaymentPlanTransaction")) {
    /**
     * TPaymentPlanTransaction
     */
    class TPaymentPlanTransaction
    {
    }
}
if (!class_exists("TPaymentPlanCancel")) {
    /**
     * TPaymentPlanCancel
     */
    class TPaymentPlanCancel
    {
    }
}
if (!class_exists("TQuoteGetOptions")) {
    /**
     * TQuoteGetOptions
     */
    class TQuoteGetOptions
    {
    }
}
if (!class_exists("TQuote")) {
    /**
     * TQuote
     */
    class TQuote
    {
    }
}
if (!class_exists("TQuoteLine")) {
    /**
     * TQuoteLine
     */
    class TQuoteLine
    {
    }
}
if (!class_exists("TSOActionIn")) {
    /**
     * TSOActionIn
     */
    class TSOActionIn
    {
    }
}
if (!class_exists("TSOActionResult")) {
    /**
     * TSOActionResult
     */
    class TSOActionResult
    {
    }
}
if (!class_exists("TSalesPerson")) {
    /**
     * TSalesPerson
     */
    class TSalesPerson
    {
    }
}
if (!class_exists("TWSPaymentType")) {
    /**
     * TWSPaymentType
     */
    class TWSPaymentType
    {
    }
}
if (!class_exists("TImageFormat")) {
    /**
     * TImageFormat
     */
    class TImageFormat
    {
    }
}
if (!class_exists("TCurrency")) {
    /**
     * TCurrency
     */
    class TCurrency
    {
    }
}
if (!class_exists("TCountry")) {
    /**
     * TCountry
     */
    class TCountry
    {
    }
}
if (!class_exists("TCounty")) {
    /**
     * TCounty
     */
    class TCounty
    {
    }
}
if (!class_exists("TDim1")) {
    /**
     * TDim1
     */
    class TDim1
    {
    }
}
if (!class_exists("TDim2")) {
    /**
     * TDim2
     */
    class TDim2
    {
    }
}
if (!class_exists("TMemberSubscriptionGroupTypes")) {
    /**
     * TMemberSubscriptionGroupTypes
     */
    class TMemberSubscriptionGroupTypes
    {
    }
}
if (!class_exists("TMemberSubscriptionGroup")) {
    /**
     * TMemberSubscriptionGroup
     */
    class TMemberSubscriptionGroup
    {
    }
}
if (!class_exists("TMemberSubscriptionAllergies")) {
    /**
     * TMemberSubscriptionAllergies
     */
    class TMemberSubscriptionAllergies
    {
    }
}
if (!class_exists("TMemberSubscription")) {
    /**
     * TMemberSubscription
     */
    class TMemberSubscription
    {
    }
}
if (!class_exists("TCardInfo")) {
    /**
     * TCardInfo
     */
    class TCardInfo
    {
    }
}
if (!class_exists("TCardType")) {
    /**
     * TCardType
     */
    class TCardType
    {
    }
}
if (!class_exists("TMESubscriptionDays")) {
    /**
     * TMESubscriptionDays
     */
    class TMESubscriptionDays
    {
    }
}
if (!class_exists("TValidSubscriptions")) {
    /**
     * TValidSubscriptions
     */
    class TValidSubscriptions
    {
    }
}
if (!class_exists("TValidAtDate")) {
    /**
     * TValidAtDate
     */
    class TValidAtDate
    {
    }
}
if (!class_exists("TWorkJournalLine")) {
    /**
     * TWorkJournalLine
     */
    class TWorkJournalLine
    {
    }
}
if (!class_exists("TWorkJournalCostLine")) {
    /**
     * TWorkJournalCostLine
     */
    class TWorkJournalCostLine
    {
    }
}
if (!class_exists("TWorkOptions")) {
    /**
     * TWorkOptions
     */
    class TWorkOptions
    {
    }
}
if (!class_exists("TWorkLine")) {
    /**
     * TWorkLine
     */
    class TWorkLine
    {
    }
}
if (!class_exists("TWorkCostLine")) {
    /**
     * TWorkCostLine
     */
    class TWorkCostLine
    {
    }
}
if (!class_exists("TJobInvoiceOptions")) {
    /**
     * TJobInvoiceOptions
     */
    class TJobInvoiceOptions
    {
    }
}
if (!class_exists("TJobTransactionsOptions")) {
    /**
     * TJobTransactionsOptions
     */
    class TJobTransactionsOptions
    {
    }
}
if (!class_exists("TJobTransaction")) {
    /**
     * TJobTransaction
     */
    class TJobTransaction
    {
    }
}
if (!class_exists("TMemberOptions")) {
    /**
     * TMemberOptions
     */
    class TMemberOptions
    {
    }
}
if (!class_exists("TMemberV2")) {
    /**
     * TMemberV2
     */
    class TMemberV2
    {
    }
}
if (!class_exists("TMemberStatistics")) {
    /**
     * TMemberStatistics
     */
    class TMemberStatistics
    {
    }
}
if (!class_exists("TMemberSubGroup")) {
    /**
     * TMemberSubGroup
     */
    class TMemberSubGroup
    {
    }
}
if (!class_exists("TMemberCarrer")) {
    /**
     * TMemberCarrer
     */
    class TMemberCarrer
    {
    }
}
if (!class_exists("TMemberMembership")) {
    /**
     * TMemberMembership
     */
    class TMemberMembership
    {
    }
}
if (!class_exists("TMemberMembershipType")) {
    /**
     * TMemberMembershipType
     */
    class TMemberMembershipType
    {
    }
}
if (!class_exists("TMemberEducation")) {
    /**
     * TMemberEducation
     */
    class TMemberEducation
    {
    }
}
if (!class_exists("TMemberApplication")) {
    /**
     * TMemberApplication
     */
    class TMemberApplication
    {
    }
}
if (!class_exists("TMemberApplicationStatus")) {
    /**
     * TMemberApplicationStatus
     */
    class TMemberApplicationStatus
    {
    }
}
if (!class_exists("TMemberApplicationManagedBy")) {
    /**
     * TMemberApplicationManagedBy
     */
    class TMemberApplicationManagedBy
    {
    }
}
if (!class_exists("TMemberApplicationDetail")) {
    /**
     * TMemberApplicationDetail
     */
    class TMemberApplicationDetail
    {
    }
}
if (!class_exists("TMemberApplicationTypeOfPayment")) {
    /**
     * TMemberApplicationTypeOfPayment
     */
    class TMemberApplicationTypeOfPayment
    {
    }
}
if (!class_exists("TWorkPlace")) {
    /**
     * TWorkPlace
     */
    class TWorkPlace
    {
    }
}
if (!class_exists("TMaternityLeave")) {
    /**
     * TMaternityLeave
     */
    class TMaternityLeave
    {
    }
}
if (!class_exists("TMemberFund")) {
    /**
     * TMemberFund
     */
    class TMemberFund
    {
    }
}
if (!class_exists("TMemberFundPayment")) {
    /**
     * TMemberFundPayment
     */
    class TMemberFundPayment
    {
    }
}
if (!class_exists("TMemberResume")) {
    /**
     * TMemberResume
     */
    class TMemberResume
    {
    }
}
if (!class_exists("TMemberInfo")) {
    /**
     * TMemberInfo
     */
    class TMemberInfo
    {
    }
}
if (!class_exists("TMemberFee")) {
    /**
     * TMemberFee
     */
    class TMemberFee
    {
    }
}
if (!class_exists("TPerson")) {
    /**
     * TPerson
     */
    class TPerson
    {
    }
}
if (!class_exists("TMemberFeeOptions")) {
    /**
     * TMemberFeeOptions
     */
    class TMemberFeeOptions
    {
    }
}
if (!class_exists("TMemberGroup")) {
    /**
     * TMemberGroup
     */
    class TMemberGroup
    {
    }
}
if (!class_exists("TApplicationResult")) {
    /**
     * TApplicationResult
     */
    class TApplicationResult
    {
    }
}
if (!class_exists("TMembershipCompany")) {
    /**
     * TMembershipCompany
     */
    class TMembershipCompany
    {
    }
}
if (!class_exists("TFund")) {
    /**
     * TFund
     */
    class TFund
    {
    }
}
if (!class_exists("TGrant")) {
    /**
     * TGrant
     */
    class TGrant
    {
    }
}
if (!class_exists("TGrantRights")) {
    /**
     * TGrantRights
     */
    class TGrantRights
    {
    }
}
if (!class_exists("TGrantRuleType")) {
    /**
     * TGrantRuleType
     */
    class TGrantRuleType
    {
    }
}
if (!class_exists("TGrantType")) {
    /**
     * TGrantType
     */
    class TGrantType
    {
    }
}
if (!class_exists("TGrantFieldRequirement")) {
    /**
     * TGrantFieldRequirement
     */
    class TGrantFieldRequirement
    {
    }
}
if (!class_exists("TPurpose")) {
    /**
     * TPurpose
     */
    class TPurpose
    {
    }
}
if (!class_exists("TWorkPlace2")) {
    /**
     * TWorkPlace2
     */
    class TWorkPlace2
    {
    }
}
if (!class_exists("TMemberResumeType")) {
    /**
     * TMemberResumeType
     */
    class TMemberResumeType
    {
    }
}
if (!class_exists("TMemberResumeGroup")) {
    /**
     * TMemberResumeGroup
     */
    class TMemberResumeGroup
    {
    }
}
if (!class_exists("TMemberMovement")) {
    /**
     * TMemberMovement
     */
    class TMemberMovement
    {
    }
}
if (!class_exists("TElectionBallot")) {
    /**
     * TElectionBallot
     */
    class TElectionBallot
    {
    }
}
if (!class_exists("TElectionHead")) {
    /**
     * TElectionHead
     */
    class TElectionHead
    {
    }
}
if (!class_exists("TElectionLine")) {
    /**
     * TElectionLine
     */
    class TElectionLine
    {
    }
}
if (!class_exists("TElectionAnswer")) {
    /**
     * TElectionAnswer
     */
    class TElectionAnswer
    {
    }
}
if (!class_exists("TWSResult")) {
    /**
     * TWSResult
     */
    class TWSResult
    {
    }
}
if (!class_exists("TTimeClockStampInfo")) {
    /**
     * TTimeClockStampInfo
     */
    class TTimeClockStampInfo
    {
    }
}
if (!class_exists("TCourse")) {
    /**
     * TCourse
     */
    class TCourse
    {
    }
}
if (!class_exists("TLessonSchedule")) {
    /**
     * TLessonSchedule
     */
    class TLessonSchedule
    {
    }
}
if (!class_exists("TCategory")) {
    /**
     * TCategory
     */
    class TCategory
    {
    }
}
if (!class_exists("TCourseType")) {
    /**
     * TCourseType
     */
    class TCourseType
    {
    }
}
if (!class_exists("TParticipant")) {
    /**
     * TParticipant
     */
    class TParticipant
    {
    }
}
if (!class_exists("TPriceInfo")) {
    /**
     * TPriceInfo
     */
    class TPriceInfo
    {
    }
}
if (!class_exists("TPaymentInfo")) {
    /**
     * TPaymentInfo
     */
    class TPaymentInfo
    {
    }
}
if (!class_exists("TEMPaymentType")) {
    /**
     * TEMPaymentType
     */
    class TEMPaymentType
    {
    }
}
if (!class_exists("TEnrollmentResult")) {
    /**
     * TEnrollmentResult
     */
    class TEnrollmentResult
    {
    }
}
if (!class_exists("TLocation")) {
    /**
     * TLocation
     */
    class TLocation
    {
    }
}
if (!class_exists("TEMBooking")) {
    /**
     * TEMBooking
     */
    class TEMBooking
    {
    }
}
if (!class_exists("TEMResourceBooking")) {
    /**
     * TEMResourceBooking
     */
    class TEMResourceBooking
    {
    }
}
if (!class_exists("TEMBookingResponse")) {
    /**
     * TEMBookingResponse
     */
    class TEMBookingResponse
    {
    }
}
if (!class_exists("TEMResourceGroup")) {
    /**
     * TEMResourceGroup
     */
    class TEMResourceGroup
    {
    }
}
if (!class_exists("TEMResourceAvailability")) {
    /**
     * TEMResourceAvailability
     */
    class TEMResourceAvailability
    {
    }
}
if (!class_exists("TEMResourcePrices")) {
    /**
     * TEMResourcePrices
     */
    class TEMResourcePrices
    {
    }
}
if (!class_exists("TUser")) {
    /**
     * TUser
     */
    class TUser
    {
    }
}
if (!class_exists("TCompany")) {
    /**
     * TCompany
     */
    class TCompany
    {
    }
}
if (!class_exists("TToken")) {
    /**
     * TToken
     */
    class TToken
    {
    }
}
if (!class_exists("Security")) {
    /**
     * Security
     */
    class Security
    {
    }
}
if (!class_exists("TUsernameToken")) {
    /**
     * TUsernameToken
     */
    class TUsernameToken
    {
    }
}
if (!class_exists("BasicSecurity")) {
    /**
     * BasicSecurity
     */
    class BasicSecurity
    {
    }
}
if (!class_exists("TokenSecurity")) {
    /**
     * TokenSecurity
     */
    class TokenSecurity
    {
    }
}
if (!class_exists("ResponseHeader")) {
    /**
     * ResponseHeader
     */
    class ResponseHeader
    {
    }
}
if (!class_exists("TStringDynArray")) {
    /**
     * TStringDynArray
     */
    class TStringDynArray
    {
    }
}
if (!class_exists("TComboBox_JournalLineType")) {
    /**
     * TComboBox_JournalLineType
     */
    class TComboBox_JournalLineType
    {
    }
}
if (!class_exists("TComboBox_Group")) {
    /**
     * TComboBox_Group
     */
    class TComboBox_Group
    {
    }
}
if (!class_exists("TComboBox_AccountType")) {
    /**
     * TComboBox_AccountType
     */
    class TComboBox_AccountType
    {
    }
}
if (!class_exists("TComboBox_ItemClass")) {
    /**
     * TComboBox_ItemClass
     */
    class TComboBox_ItemClass
    {
    }
}
if (!class_exists("TComboBox_SOOrigin")) {
    /**
     * TComboBox_SOOrigin
     */
    class TComboBox_SOOrigin
    {
    }
}
if (!class_exists("TComboBox_BSSCondition")) {
    /**
     * TComboBox_BSSCondition
     */
    class TComboBox_BSSCondition
    {
    }
}
if (!class_exists("TComboBox_ARCreditCardType")) {
    /**
     * TComboBox_ARCreditCardType
     */
    class TComboBox_ARCreditCardType
    {
    }
}
if (!class_exists("TComboBox_PriceGroup")) {
    /**
     * TComboBox_PriceGroup
     */
    class TComboBox_PriceGroup
    {
    }
}
if (!class_exists("TComboBox_Settled")) {
    /**
     * TComboBox_Settled
     */
    class TComboBox_Settled
    {
    }
}
if (!class_exists("TComboBox_PjJobType")) {
    /**
     * TComboBox_PjJobType
     */
    class TComboBox_PjJobType
    {
    }
}
if (!class_exists("TComboBox_PjJobStatus")) {
    /**
     * TComboBox_PjJobStatus
     */
    class TComboBox_PjJobStatus
    {
    }
}
if (!class_exists("TComboBox_PjBillingMode")) {
    /**
     * TComboBox_PjBillingMode
     */
    class TComboBox_PjBillingMode
    {
    }
}
if (!class_exists("TComboBox_PjDiscountType")) {
    /**
     * TComboBox_PjDiscountType
     */
    class TComboBox_PjDiscountType
    {
    }
}
if (!class_exists("TComboBox_BSSClaimStatus")) {
    /**
     * TComboBox_BSSClaimStatus
     */
    class TComboBox_BSSClaimStatus
    {
    }
}
if (!class_exists("TComboBox_ORMemberFeeRate")) {
    /**
     * TComboBox_ORMemberFeeRate
     */
    class TComboBox_ORMemberFeeRate
    {
    }
}
if (!class_exists("TComboBox_Origin")) {
    /**
     * TComboBox_Origin
     */
    class TComboBox_Origin
    {
    }
}
if (!class_exists("TComboBox_JournalLineCode")) {
    /**
     * TComboBox_JournalLineCode
     */
    class TComboBox_JournalLineCode
    {
    }
}
if (!class_exists("TComboBox_JournalHeadType")) {
    /**
     * TComboBox_JournalHeadType
     */
    class TComboBox_JournalHeadType
    {
    }
}
if (!class_exists("TComboBox_DebCred")) {
    /**
     * TComboBox_DebCred
     */
    class TComboBox_DebCred
    {
    }
}
if (!class_exists("TComboBox_APRecordType")) {
    /**
     * TComboBox_APRecordType
     */
    class TComboBox_APRecordType
    {
    }
}
if (!class_exists("TComboBox_InputSchemeCommandType")) {
    /**
     * TComboBox_InputSchemeCommandType
     */
    class TComboBox_InputSchemeCommandType
    {
    }
}
if (!class_exists("TComboBox_InvoiceLineType")) {
    /**
     * TComboBox_InvoiceLineType
     */
    class TComboBox_InvoiceLineType
    {
    }
}
if (!class_exists("TComboBox_APApporvedStatus")) {
    /**
     * TComboBox_APApporvedStatus
     */
    class TComboBox_APApporvedStatus
    {
    }
}
if (!class_exists("TComboBox_APInvoiceOrigin")) {
    /**
     * TComboBox_APInvoiceOrigin
     */
    class TComboBox_APInvoiceOrigin
    {
    }
}
if (!class_exists("TComboBox_PrEmployeeStatus")) {
    /**
     * TComboBox_PrEmployeeStatus
     */
    class TComboBox_PrEmployeeStatus
    {
    }
}
if (!class_exists("TComboBox_SOHeadStatus")) {
    /**
     * TComboBox_SOHeadStatus
     */
    class TComboBox_SOHeadStatus
    {
    }
}
if (!class_exists("TComboBox_SODeliveryStatus")) {
    /**
     * TComboBox_SODeliveryStatus
     */
    class TComboBox_SODeliveryStatus
    {
    }
}
if (!class_exists("TComboBox_PjJournalLineUnit")) {
    /**
     * TComboBox_PjJournalLineUnit
     */
    class TComboBox_PjJournalLineUnit
    {
    }
}
if (!class_exists("TComboBox_PjJournalLineType")) {
    /**
     * TComboBox_PjJournalLineType
     */
    class TComboBox_PjJournalLineType
    {
    }
}
if (!class_exists("TComboBox_PjJournalCode")) {
    /**
     * TComboBox_PjJournalCode
     */
    class TComboBox_PjJournalCode
    {
    }
}
if (!class_exists("TComboBox_PjRecordBilledStatus")) {
    /**
     * TComboBox_PjRecordBilledStatus
     */
    class TComboBox_PjRecordBilledStatus
    {
    }
}
if (!class_exists("TComboBox_EMPartBookingStatus")) {
    /**
     * TComboBox_EMPartBookingStatus
     */
    class TComboBox_EMPartBookingStatus
    {
    }
}
if (!class_exists("TComboBox_EMPartPaymentStatus")) {
    /**
     * TComboBox_EMPartPaymentStatus
     */
    class TComboBox_EMPartPaymentStatus
    {
    }
}
if (!class_exists("IItemServiceservice")) {
    /**
     * IItemServiceservice
     *
     */
    class IItemServiceservice extends SoapClient
    {
        /**
         * Default class map for wsdl=>php
         * @access private
         * @var array
         */
        private static $classmap = array(
            "TRecordOptions" => "TRecordOptions",
            "TRecord" => "TRecord",
            "TExtraProperty" => "TExtraProperty",
            "TDeletedOptions" => "TDeletedOptions",
            "TDeletedRecord" => "TDeletedRecord",
            "TSystemSettingGetOption" => "TSystemSettingGetOption",
            "TSystemSettings" => "TSystemSettings",
            "TSystemInformation" => "TSystemInformation",
            "TDimmensionSetting" => "TDimmensionSetting",
            "TProjectSetting" => "TProjectSetting",
            "TGeneralSetting" => "TGeneralSetting",
            "TInventorySetting" => "TInventorySetting",
            "TCustomerSetting" => "TCustomerSetting",
            "TVendorSetting" => "TVendorSetting",
            "TSaleSetting" => "TSaleSetting",
            "TRegistrationEntry" => "TRegistrationEntry",
            "TGLJournalHead" => "TGLJournalHead",
            "TGLJournalLine" => "TGLJournalLine",
            "TGeneralLedgerOptions" => "TGeneralLedgerOptions",
            "TGeneralLedgerAccountGetOptions" => "TGeneralLedgerAccountGetOptions",
            "TGeneralLedgerAccount" => "TGeneralLedgerAccount",
            "TItemOptions" => "TItemOptions",
            "TItem" => "TItem",
            "TCurrencyPrice" => "TCurrencyPrice",
            "TItemCategory" => "TItemCategory",
            "TItemSubCategory" => "TItemSubCategory",
            "TVariation" => "TVariation",
            "TBarCode" => "TBarCode",
            "TCustomerItemReceiverBarCode" => "TCustomerItemReceiverBarCode",
            "TWharehouseItem" => "TWharehouseItem",
            "TRecordChange" => "TRecordChange",
            "TFieldChanges" => "TFieldChanges",
            "TAttachment" => "TAttachment",
            "TItemVendorLink" => "TItemVendorLink",
            "TItemUnit" => "TItemUnit",
            "TItemCriteria" => "TItemCriteria",
            "TItemUnits" => "TItemUnits",
            "TCustomerItemReceiverLocationLink" => "TCustomerItemReceiverLocationLink",
            "TInventoryJournal" => "TInventoryJournal",
            "TInventoryJournalLine" => "TInventoryJournalLine",
            "TInventorying" => "TInventorying",
            "TInventoryingLine" => "TInventoryingLine",
            "TInventoryTransfer" => "TInventoryTransfer",
            "TVendor" => "TVendor",
            "TInvoice" => "TInvoice",
            "TInvoiceOptions" => "TInvoiceOptions",
            "TActionMethod" => "TActionMethod",
            "TSalesOrderType" => "TSalesOrderType",
            "TCustomer" => "TCustomer",
            "TGender" => "TGender",
            "TCreditCard" => "TCreditCard",
            "TItemReceiver" => "TItemReceiver",
            "TContact" => "TContact",
            "TReference" => "TReference",
            "TJob" => "TJob",
            "TAttachmentFile" => "TAttachmentFile",
            "TCustomerProperty" => "TCustomerProperty",
            "TMemo" => "TMemo",
            "TInvoiceEntry" => "TInvoiceEntry",
            "TInvoiceLine" => "TInvoiceLine",
            "TPayment" => "TPayment",
            "TItemWarehouse" => "TItemWarehouse",
            "TItemGroup" => "TItemGroup",
            "TCustomerOptions" => "TCustomerOptions",
            "TCustomerGroup" => "TCustomerGroup",
            "TBalance" => "TBalance",
            "TCustomerPaymentTerm" => "TCustomerPaymentTerm",
            "TCustomerPaymentMode" => "TCustomerPaymentMode",
            "TPaymentMode" => "TPaymentMode",
            "TPaymentTerm" => "TPaymentTerm",
            "TCustomerLedgerCode" => "TCustomerLedgerCode",
            "TSubscriptionType" => "TSubscriptionType",
            "TSubscription" => "TSubscription",
            "TSubscriber" => "TSubscriber",
            "TTrialSubscription" => "TTrialSubscription",
            "TSubscriptionRate" => "TSubscriptionRate",
            "TSubscriptionDiscount" => "TSubscriptionDiscount",
            "TSubscriptionOptions" => "TSubscriptionOptions",
            "TVendorItem" => "TVendorItem",
            "TVendorTransactionsOptions" => "TVendorTransactionsOptions",
            "TVendorTransaction" => "TVendorTransaction",
            "TVendorInvoiceOptions" => "TVendorInvoiceOptions",
            "TVendorInvoiceType" => "TVendorInvoiceType",
            "TVendorInvoice" => "TVendorInvoice",
            "TVendorInvoiceApproval" => "TVendorInvoiceApproval",
            "TVendorInvoiceLine" => "TVendorInvoiceLine",
            "TPurchaseOrder" => "TPurchaseOrder",
            "TPurchaseOrderLine" => "TPurchaseOrderLine",
            "TPurchaseOptions" => "TPurchaseOptions",
            "TSubscriptionOrderFilter" => "TSubscriptionOrderFilter",
            "TEmployee" => "TEmployee",
            "TTimeClockStampType" => "TTimeClockStampType",
            "TInvoiceGetOptions" => "TInvoiceGetOptions",
            "TInvoiceClaim" => "TInvoiceClaim",
            "TSaleStatisticOptions" => "TSaleStatisticOptions",
            "TSalesStatistic" => "TSalesStatistic",
            "TOrder" => "TOrder",
            "TOrderOptions" => "TOrderOptions",
            "TOrderLine" => "TOrderLine",
            "TPaymentPlanRequest" => "TPaymentPlanRequest",
            "TPaymentPlanTransaction" => "TPaymentPlanTransaction",
            "TPaymentPlanCancel" => "TPaymentPlanCancel",
            "TQuoteGetOptions" => "TQuoteGetOptions",
            "TQuote" => "TQuote",
            "TQuoteLine" => "TQuoteLine",
            "TSOActionIn" => "TSOActionIn",
            "TSOActionResult" => "TSOActionResult",
            "TSalesPerson" => "TSalesPerson",
            "TWSPaymentType" => "TWSPaymentType",
            "TImageFormat" => "TImageFormat",
            "TCurrency" => "TCurrency",
            "TCountry" => "TCountry",
            "TCounty" => "TCounty",
            "TDim1" => "TDim1",
            "TDim2" => "TDim2",
            "TMemberSubscriptionGroupTypes" => "TMemberSubscriptionGroupTypes",
            "TMemberSubscriptionGroup" => "TMemberSubscriptionGroup",
            "TMemberSubscriptionAllergies" => "TMemberSubscriptionAllergies",
            "TMemberSubscription" => "TMemberSubscription",
            "TCardInfo" => "TCardInfo",
            "TCardType" => "TCardType",
            "TMESubscriptionDays" => "TMESubscriptionDays",
            "TValidSubscriptions" => "TValidSubscriptions",
            "TValidAtDate" => "TValidAtDate",
            "TWorkJournalLine" => "TWorkJournalLine",
            "TWorkJournalCostLine" => "TWorkJournalCostLine",
            "TWorkOptions" => "TWorkOptions",
            "TWorkLine" => "TWorkLine",
            "TWorkCostLine" => "TWorkCostLine",
            "TJobInvoiceOptions" => "TJobInvoiceOptions",
            "TJobTransactionsOptions" => "TJobTransactionsOptions",
            "TJobTransaction" => "TJobTransaction",
            "TMemberOptions" => "TMemberOptions",
            "TMemberV2" => "TMemberV2",
            "TMemberStatistics" => "TMemberStatistics",
            "TMemberSubGroup" => "TMemberSubGroup",
            "TMemberCarrer" => "TMemberCarrer",
            "TMemberMembership" => "TMemberMembership",
            "TMemberMembershipType" => "TMemberMembershipType",
            "TMemberEducation" => "TMemberEducation",
            "TMemberApplication" => "TMemberApplication",
            "TMemberApplicationStatus" => "TMemberApplicationStatus",
            "TMemberApplicationManagedBy" => "TMemberApplicationManagedBy",
            "TMemberApplicationDetail" => "TMemberApplicationDetail",
            "TMemberApplicationTypeOfPayment" => "TMemberApplicationTypeOfPayment",
            "TWorkPlace" => "TWorkPlace",
            "TMaternityLeave" => "TMaternityLeave",
            "TMemberFund" => "TMemberFund",
            "TMemberFundPayment" => "TMemberFundPayment",
            "TMemberResume" => "TMemberResume",
            "TMemberInfo" => "TMemberInfo",
            "TMemberFee" => "TMemberFee",
            "TPerson" => "TPerson",
            "TMemberFeeOptions" => "TMemberFeeOptions",
            "TMemberGroup" => "TMemberGroup",
            "TApplicationResult" => "TApplicationResult",
            "TMembershipCompany" => "TMembershipCompany",
            "TFund" => "TFund",
            "TGrant" => "TGrant",
            "TGrantRights" => "TGrantRights",
            "TGrantRuleType" => "TGrantRuleType",
            "TGrantType" => "TGrantType",
            "TGrantFieldRequirement" => "TGrantFieldRequirement",
            "TPurpose" => "TPurpose",
            "TWorkPlace2" => "TWorkPlace2",
            "TMemberResumeType" => "TMemberResumeType",
            "TMemberResumeGroup" => "TMemberResumeGroup",
            "TMemberMovement" => "TMemberMovement",
            "TElectionBallot" => "TElectionBallot",
            "TElectionHead" => "TElectionHead",
            "TElectionLine" => "TElectionLine",
            "TElectionAnswer" => "TElectionAnswer",
            "TWSResult" => "TWSResult",
            "TTimeClockStampInfo" => "TTimeClockStampInfo",
            "TCourse" => "TCourse",
            "TLessonSchedule" => "TLessonSchedule",
            "TCategory" => "TCategory",
            "TCourseType" => "TCourseType",
            "TParticipant" => "TParticipant",
            "TPriceInfo" => "TPriceInfo",
            "TPaymentInfo" => "TPaymentInfo",
            "TEMPaymentType" => "TEMPaymentType",
            "TEnrollmentResult" => "TEnrollmentResult",
            "TLocation" => "TLocation",
            "TEMBooking" => "TEMBooking",
            "TEMResourceBooking" => "TEMResourceBooking",
            "TEMBookingResponse" => "TEMBookingResponse",
            "TEMResourceGroup" => "TEMResourceGroup",
            "TEMResourceAvailability" => "TEMResourceAvailability",
            "TEMResourcePrices" => "TEMResourcePrices",
            "TUser" => "TUser",
            "TCompany" => "TCompany",
            "TToken" => "TToken",
            "Security" => "Security",
            "TUsernameToken" => "TUsernameToken",
            "BasicSecurity" => "BasicSecurity",
            "TokenSecurity" => "TokenSecurity",
            "ResponseHeader" => "ResponseHeader",
            "TStringDynArray" => "TStringDynArray",
            "TComboBox_JournalLineType" => "TComboBox_JournalLineType",
            "TComboBox_Group" => "TComboBox_Group",
            "TComboBox_AccountType" => "TComboBox_AccountType",
            "TComboBox_ItemClass" => "TComboBox_ItemClass",
            "TComboBox_SOOrigin" => "TComboBox_SOOrigin",
            "TComboBox_BSSCondition" => "TComboBox_BSSCondition",
            "TComboBox_ARCreditCardType" => "TComboBox_ARCreditCardType",
            "TComboBox_PriceGroup" => "TComboBox_PriceGroup",
            "TComboBox_Settled" => "TComboBox_Settled",
            "TComboBox_PjJobType" => "TComboBox_PjJobType",
            "TComboBox_PjJobStatus" => "TComboBox_PjJobStatus",
            "TComboBox_PjBillingMode" => "TComboBox_PjBillingMode",
            "TComboBox_PjDiscountType" => "TComboBox_PjDiscountType",
            "TComboBox_BSSClaimStatus" => "TComboBox_BSSClaimStatus",
            "TComboBox_ORMemberFeeRate" => "TComboBox_ORMemberFeeRate",
            "TComboBox_Origin" => "TComboBox_Origin",
            "TComboBox_JournalLineCode" => "TComboBox_JournalLineCode",
            "TComboBox_JournalHeadType" => "TComboBox_JournalHeadType",
            "TComboBox_DebCred" => "TComboBox_DebCred",
            "TComboBox_APRecordType" => "TComboBox_APRecordType",
            "TComboBox_InputSchemeCommandType" => "TComboBox_InputSchemeCommandType",
            "TComboBox_InvoiceLineType" => "TComboBox_InvoiceLineType",
            "TComboBox_APApporvedStatus" => "TComboBox_APApporvedStatus",
            "TComboBox_APInvoiceOrigin" => "TComboBox_APInvoiceOrigin",
            "TComboBox_PrEmployeeStatus" => "TComboBox_PrEmployeeStatus",
            "TComboBox_SOHeadStatus" => "TComboBox_SOHeadStatus",
            "TComboBox_SODeliveryStatus" => "TComboBox_SODeliveryStatus",
            "TComboBox_PjJournalLineUnit" => "TComboBox_PjJournalLineUnit",
            "TComboBox_PjJournalLineType" => "TComboBox_PjJournalLineType",
            "TComboBox_PjJournalCode" => "TComboBox_PjJournalCode",
            "TComboBox_PjRecordBilledStatus" => "TComboBox_PjRecordBilledStatus",
            "TComboBox_EMPartBookingStatus" => "TComboBox_EMPartBookingStatus",
            "TComboBox_EMPartPaymentStatus" => "TComboBox_EMPartPaymentStatus",
        );

        /**
         * Constructor using wsdl location and options array
         * @param string $wsdl WSDL location for this service
         * @param array $options Options for the SoapClient
         */
        public function __construct($wsdl = "http://webservice.dkvistun.is/DemoDev/dkwsitemscgi.exe/wsdl/IItemService", $options = array())
        {
            foreach (self::$classmap as $wsdlClassName => $phpClassName) {
                if (!isset($options['classmap'][$wsdlClassName])) {
                    $options['classmap'][$wsdlClassName] = $phpClassName;
                }
            }
            parent::__construct($wsdl, $options);
        }

        /**
         * Checks if an argument list matches against a valid argument type list
         * @param array $arguments The argument list to check
         * @param array $validParameters A list of valid argument types
         * @return boolean true if arguments match against validParameters
         * @throws Exception invalid function signature message
         */
        public function _checkArguments($arguments, $validParameters)
        {
            $variables = "";
            foreach ($arguments as $arg) {
                $type = gettype($arg);
                if ($type == "object") {
                    $type = get_class($arg);
                }
                $variables .= "(" . $type . ")";
            }
            if (!in_array($variables, $validParameters)) {
                throw new Exception("Invalid parameter types: " . str_replace(")(", ", ", $variables));
            }
            return true;
        }

        /**
         * Service Call: GetRecords
         * @return
         * @throws Exception invalid function signature message
         */
        public function GetRecords()
        {
            return $this->__soapCall("GetRecords", array());
        }


        /**
         * Service Call: GetRecordEX
         * @return
         * @throws Exception invalid function signature message
         */
        public function GetRecordEX()
        {
            return $this->__soapCall("GetRecordEX", array());
        }


        /**
         * Service Call: GetRecordLines
         * @return
         * @throws Exception invalid function signature message
         */
        public function GetRecordLines()
        {
            return $this->__soapCall("GetRecordLines", array());
        }


        /**
         * Service Call: GetRecordLinesEX
         * @return
         * @throws Exception invalid function signature message
         */
        public function GetRecordLinesEX()
        {
            return $this->__soapCall("GetRecordLinesEX", array());
        }


        /**
         * Service Call: GetRecordCount
         * @return
         * @throws Exception invalid function signature message
         */
        public function GetRecordCount()
        {
            return $this->__soapCall("GetRecordCount", array());
        }


        /**
         * Service Call: GetRecordCountEX
         * @return
         * @throws Exception invalid function signature message
         */
        public function GetRecordCountEX()
        {
            return $this->__soapCall("GetRecordCountEX", array());
        }


        /**
         * Service Call: GetRecordTableIndexNumber
         * @return
         * @throws Exception invalid function signature message
         */
        public function GetRecordTableIndexNumber()
        {
            return $this->__soapCall("GetRecordTableIndexNumber", array());
        }


        /**
         * Service Call: GetRecordFieldList
         * @return
         * @throws Exception invalid function signature message
         */
        public function GetRecordFieldList()
        {
            return $this->__soapCall("GetRecordFieldList", array());
        }


        /**
         * Service Call: GetDeleted
         * @return
         * @throws Exception invalid function signature message
         */
        public function GetDeleted()
        {
            return $this->__soapCall("GetDeleted", array());
        }


        /**
         * Service Call: GetDeletedID
         * @return
         * @throws Exception invalid function signature message
         */
        public function GetDeletedID()
        {
            return $this->__soapCall("GetDeletedID", array());
        }


        /**
         * Service Call: GetSystemSettings
         * @return
         * @throws Exception invalid function signature message
         */
        public function GetSystemSettings()
        {
            return $this->__soapCall("GetSystemSettings", array());
        }


        /**
         * Service Call: GetSSNRegistration
         * @return
         * @throws Exception invalid function signature message
         */
        public function GetSSNRegistration()
        {
            return $this->__soapCall("GetSSNRegistration", array());
        }


        /**
         * Service Call: CreateGeneralLedgerJournal
         * @return
         * @throws Exception invalid function signature message
         */
        public function CreateGeneralLedgerJournal()
        {
            return $this->__soapCall("CreateGeneralLedgerJournal", array());
        }


        /**
         * Service Call: GetGeneralLedgerAccounts
         * @return
         * @throws Exception invalid function signature message
         */
        public function GetGeneralLedgerAccounts()
        {
            return $this->__soapCall("GetGeneralLedgerAccounts", array());
        }


        /**
         * Service Call: GetItem
         * @return
         * @throws Exception invalid function signature message
         */
        public function GetItem()
        {
            return $this->__soapCall("GetItem", array());
        }


        /**
         * Service Call: GetItemFromRecordID
         * @return
         * @throws Exception invalid function signature message
         */
        public function GetItemFromRecordID()
        {
            return $this->__soapCall("GetItemFromRecordID", array());
        }


        /**
         * Service Call: GetItems
         * @return
         * @throws Exception invalid function signature message
         */
        public function GetItems()
        {
            return $this->__soapCall("GetItems", array());
        }


        /**
         * Service Call: GetItemsFromArray
         * @return
         * @throws Exception invalid function signature message
         */
        public function GetItemsFromArray()
        {
            return $this->__soapCall("GetItemsFromArray", array());
        }


        /**
         * Service Call: GetItemsEx
         * @return
         * @throws Exception invalid function signature message
         */
        public function GetItemsEx()
        {
            return $this->__soapCall("GetItemsEx", array());
        }


        /**
         * Service Call: GetDeletedItems
         * @return
         * @throws Exception invalid function signature message
         */
        public function GetDeletedItems()
        {
            return $this->__soapCall("GetDeletedItems", array());
        }


        /**
         * Service Call: NumberOfModifiedItems
         * @return
         * @throws Exception invalid function signature message
         */
        public function NumberOfModifiedItems()
        {
            return $this->__soapCall("NumberOfModifiedItems", array());
        }


        /**
         * Service Call: GetItemCount
         * @return
         * @throws Exception invalid function signature message
         */
        public function GetItemCount()
        {
            return $this->__soapCall("GetItemCount", array());
        }


        /**
         * Service Call: CreateItem
         * @return
         * @throws Exception invalid function signature message
         */
        public function CreateItem()
        {
            return $this->__soapCall("CreateItem", array());
        }


        /**
         * Service Call: CreateItems
         * @return
         * @throws Exception invalid function signature message
         */
        public function CreateItems()
        {
            return $this->__soapCall("CreateItems", array());
        }


        /**
         * Service Call: UpdateItem
         * @return
         * @throws Exception invalid function signature message
         */
        public function UpdateItem()
        {
            return $this->__soapCall("UpdateItem", array());
        }


        /**
         * Service Call: UpdateItems
         * @return
         * @throws Exception invalid function signature message
         */
        public function UpdateItems()
        {
            return $this->__soapCall("UpdateItems", array());
        }


        /**
         * Service Call: ItemExists
         * @return
         * @throws Exception invalid function signature message
         */
        public function ItemExists()
        {
            return $this->__soapCall("ItemExists", array());
        }


        /**
         * Service Call: GetItemUnits
         * @return
         * @throws Exception invalid function signature message
         */
        public function GetItemUnits()
        {
            return $this->__soapCall("GetItemUnits", array());
        }


        /**
         * Service Call: getBarCodes
         * @return
         * @throws Exception invalid function signature message
         */
        public function getBarCodes()
        {
            return $this->__soapCall("getBarCodes", array());
        }


        /**
         * Service Call: CreateBarcode
         * @return
         * @throws Exception invalid function signature message
         */
        public function CreateBarcode()
        {
            return $this->__soapCall("CreateBarcode", array());
        }


        /**
         * Service Call: DeleteBarcode
         * @return
         * @throws Exception invalid function signature message
         */
        public function DeleteBarcode()
        {
            return $this->__soapCall("DeleteBarcode", array());
        }


        /**
         * Service Call: GetCustomerItemReceiverLocationBarCodes
         * @return
         * @throws Exception invalid function signature message
         */
        public function GetCustomerItemReceiverLocationBarCodes()
        {
            return $this->__soapCall("GetCustomerItemReceiverLocationBarCodes", array());
        }


        /**
         * Service Call: GetCustomerItemReceiverLocationLink
         * @return
         * @throws Exception invalid function signature message
         */
        public function GetCustomerItemReceiverLocationLink()
        {
            return $this->__soapCall("GetCustomerItemReceiverLocationLink", array());
        }


        /**
         * Service Call: CreateInventoryJournal
         * @return
         * @throws Exception invalid function signature message
         */
        public function CreateInventoryJournal()
        {
            return $this->__soapCall("CreateInventoryJournal", array());
        }


        /**
         * Service Call: CreateInventorying
         * @return
         * @throws Exception invalid function signature message
         */
        public function CreateInventorying()
        {
            return $this->__soapCall("CreateInventorying", array());
        }


        /**
         * Service Call: CreateInventoryTransfer
         * @return
         * @throws Exception invalid function signature message
         */
        public function CreateInventoryTransfer()
        {
            return $this->__soapCall("CreateInventoryTransfer", array());
        }


        /**
         * Service Call: GetItemCategories
         * @return
         * @throws Exception invalid function signature message
         */
        public function GetItemCategories()
        {
            return $this->__soapCall("GetItemCategories", array());
        }


        /**
         * Service Call: GetItemVendors
         * @return
         * @throws Exception invalid function signature message
         */
        public function GetItemVendors()
        {
            return $this->__soapCall("GetItemVendors", array());
        }


        /**
         * Service Call: GetCustomerItemDiscounts
         * @return
         * @throws Exception invalid function signature message
         */
        public function GetCustomerItemDiscounts()
        {
            return $this->__soapCall("GetCustomerItemDiscounts", array());
        }


        /**
         * Service Call: GetQuantityInItemWarehouse
         * @return
         * @throws Exception invalid function signature message
         */
        public function GetQuantityInItemWarehouse()
        {
            return $this->__soapCall("GetQuantityInItemWarehouse", array());
        }


        /**
         * Service Call: GetAllQuantityInItemWarehouse
         * @return
         * @throws Exception invalid function signature message
         */
        public function GetAllQuantityInItemWarehouse()
        {
            return $this->__soapCall("GetAllQuantityInItemWarehouse", array());
        }


        /**
         * Service Call: GetItemGroups
         * @return
         * @throws Exception invalid function signature message
         */
        public function GetItemGroups()
        {
            return $this->__soapCall("GetItemGroups", array());
        }


        /**
         * Service Call: GetItemsByGroup
         * @return
         * @throws Exception invalid function signature message
         */
        public function GetItemsByGroup()
        {
            return $this->__soapCall("GetItemsByGroup", array());
        }


        /**
         * Service Call: GetItemsByGroupRecordID
         * @return
         * @throws Exception invalid function signature message
         */
        public function GetItemsByGroupRecordID()
        {
            return $this->__soapCall("GetItemsByGroupRecordID", array());
        }


        /**
         * Service Call: GetCustomer
         * @return
         * @throws Exception invalid function signature message
         */
        public function GetCustomer()
        {
            return $this->__soapCall("GetCustomer", array());
        }


        /**
         * Service Call: GetCustomers
         * @return
         * @throws Exception invalid function signature message
         */
        public function GetCustomers()
        {
            return $this->__soapCall("GetCustomers", array());
        }


        /**
         * Service Call: GetCustomersEx
         * @return
         * @throws Exception invalid function signature message
         */
        public function GetCustomersEx()
        {
            return $this->__soapCall("GetCustomersEx", array());
        }


        /**
         * Service Call: GetCustomerFromPhoneNumber
         * @return
         * @throws Exception invalid function signature message
         */
        public function GetCustomerFromPhoneNumber()
        {
            return $this->__soapCall("GetCustomerFromPhoneNumber", array());
        }


        /**
         * Service Call: GetCustomersBySalesPerson
         * @return
         * @throws Exception invalid function signature message
         */
        public function GetCustomersBySalesPerson()
        {
            return $this->__soapCall("GetCustomersBySalesPerson", array());
        }


        /**
         * Service Call: NumberOfModifiedCustomers
         * @return
         * @throws Exception invalid function signature message
         */
        public function NumberOfModifiedCustomers()
        {
            return $this->__soapCall("NumberOfModifiedCustomers", array());
        }


        /**
         * Service Call: GetCustomerGroup
         * @return
         * @throws Exception invalid function signature message
         */
        public function GetCustomerGroup()
        {
            return $this->__soapCall("GetCustomerGroup", array());
        }


        /**
         * Service Call: GetCustomerBalance
         * @return
         * @throws Exception invalid function signature message
         */
        public function GetCustomerBalance()
        {
            return $this->__soapCall("GetCustomerBalance", array());
        }


        /**
         * Service Call: UpdateCustomer
         * @return
         * @throws Exception invalid function signature message
         */
        public function UpdateCustomer()
        {
            return $this->__soapCall("UpdateCustomer", array());
        }


        /**
         * Service Call: UpdateCustomers
         * @return
         * @throws Exception invalid function signature message
         */
        public function UpdateCustomers()
        {
            return $this->__soapCall("UpdateCustomers", array());
        }


        /**
         * Service Call: CreateCustomer
         * @return
         * @throws Exception invalid function signature message
         */
        public function CreateCustomer()
        {
            return $this->__soapCall("CreateCustomer", array());
        }


        /**
         * Service Call: CreateCustomers
         * @return
         * @throws Exception invalid function signature message
         */
        public function CreateCustomers()
        {
            return $this->__soapCall("CreateCustomers", array());
        }


        /**
         * Service Call: CustomerCount
         * @return
         * @throws Exception invalid function signature message
         */
        public function CustomerCount()
        {
            return $this->__soapCall("CustomerCount", array());
        }


        /**
         * Service Call: DeleteCustomer
         * @return
         * @throws Exception invalid function signature message
         */
        public function DeleteCustomer()
        {
            return $this->__soapCall("DeleteCustomer", array());
        }


        /**
         * Service Call: DeleteCustomers
         * @return
         * @throws Exception invalid function signature message
         */
        public function DeleteCustomers()
        {
            return $this->__soapCall("DeleteCustomers", array());
        }


        /**
         * Service Call: CustomerExists
         * @return
         * @throws Exception invalid function signature message
         */
        public function CustomerExists()
        {
            return $this->__soapCall("CustomerExists", array());
        }


        /**
         * Service Call: GetCustomerPaymentTerms
         * @return
         * @throws Exception invalid function signature message
         */
        public function GetCustomerPaymentTerms()
        {
            return $this->__soapCall("GetCustomerPaymentTerms", array());
        }


        /**
         * Service Call: GetCustomerPaymentModes
         * @return
         * @throws Exception invalid function signature message
         */
        public function GetCustomerPaymentModes()
        {
            return $this->__soapCall("GetCustomerPaymentModes", array());
        }


        /**
         * Service Call: GetPaymentModes
         * @return
         * @throws Exception invalid function signature message
         */
        public function GetPaymentModes()
        {
            return $this->__soapCall("GetPaymentModes", array());
        }


        /**
         * Service Call: GetPaymentTerms
         * @return
         * @throws Exception invalid function signature message
         */
        public function GetPaymentTerms()
        {
            return $this->__soapCall("GetPaymentTerms", array());
        }


        /**
         * Service Call: GetCustomerLedgerCodes
         * @return
         * @throws Exception invalid function signature message
         */
        public function GetCustomerLedgerCodes()
        {
            return $this->__soapCall("GetCustomerLedgerCodes", array());
        }


        /**
         * Service Call: UploadCustomerAttachment
         * @return
         * @throws Exception invalid function signature message
         */
        public function UploadCustomerAttachment()
        {
            return $this->__soapCall("UploadCustomerAttachment", array());
        }


        /**
         * Service Call: CreatedContact
         * @return
         * @throws Exception invalid function signature message
         */
        public function CreatedContact()
        {
            return $this->__soapCall("CreatedContact", array());
        }


        /**
         * Service Call: DeleteContact
         * @return
         * @throws Exception invalid function signature message
         */
        public function DeleteContact()
        {
            return $this->__soapCall("DeleteContact", array());
        }


        /**
         * Service Call: UpdateContact
         * @return
         * @throws Exception invalid function signature message
         */
        public function UpdateContact()
        {
            return $this->__soapCall("UpdateContact", array());
        }


        /**
         * Service Call: CreateItemReceiver
         * @return
         * @throws Exception invalid function signature message
         */
        public function CreateItemReceiver()
        {
            return $this->__soapCall("CreateItemReceiver", array());
        }


        /**
         * Service Call: DeleteItemReceiver
         * @return
         * @throws Exception invalid function signature message
         */
        public function DeleteItemReceiver()
        {
            return $this->__soapCall("DeleteItemReceiver", array());
        }


        /**
         * Service Call: UpdateItemReceiver
         * @return
         * @throws Exception invalid function signature message
         */
        public function UpdateItemReceiver()
        {
            return $this->__soapCall("UpdateItemReceiver", array());
        }


        /**
         * Service Call: CreateCustomerMemo
         * @return
         * @throws Exception invalid function signature message
         */
        public function CreateCustomerMemo()
        {
            return $this->__soapCall("CreateCustomerMemo", array());
        }


        /**
         * Service Call: UpdateCustomerMemo
         * @return
         * @throws Exception invalid function signature message
         */
        public function UpdateCustomerMemo()
        {
            return $this->__soapCall("UpdateCustomerMemo", array());
        }


        /**
         * Service Call: DeleteCustomerMemo
         * @return
         * @throws Exception invalid function signature message
         */
        public function DeleteCustomerMemo()
        {
            return $this->__soapCall("DeleteCustomerMemo", array());
        }


        /**
         * Service Call: GetSubscriptionTypes
         * @return
         * @throws Exception invalid function signature message
         */
        public function GetSubscriptionTypes()
        {
            return $this->__soapCall("GetSubscriptionTypes", array());
        }


        /**
         * Service Call: GetSubscriptionType
         * @return
         * @throws Exception invalid function signature message
         */
        public function GetSubscriptionType()
        {
            return $this->__soapCall("GetSubscriptionType", array());
        }


        /**
         * Service Call: CreateSubscription
         * @return
         * @throws Exception invalid function signature message
         */
        public function CreateSubscription()
        {
            return $this->__soapCall("CreateSubscription", array());
        }


        /**
         * Service Call: getSubscriptions
         * @return
         * @throws Exception invalid function signature message
         */
        public function getSubscriptions()
        {
            return $this->__soapCall("getSubscriptions", array());
        }


        /**
         * Service Call: getSubscriptionsEx
         * @return
         * @throws Exception invalid function signature message
         */
        public function getSubscriptionsEx()
        {
            return $this->__soapCall("getSubscriptionsEx", array());
        }


        /**
         * Service Call: SubscriptionExists
         * @return
         * @throws Exception invalid function signature message
         */
        public function SubscriptionExists()
        {
            return $this->__soapCall("SubscriptionExists", array());
        }


        /**
         * Service Call: GetSubscribers
         * @return
         * @throws Exception invalid function signature message
         */
        public function GetSubscribers()
        {
            return $this->__soapCall("GetSubscribers", array());
        }


        /**
         * Service Call: GetVendor
         * @return
         * @throws Exception invalid function signature message
         */
        public function GetVendor()
        {
            return $this->__soapCall("GetVendor", array());
        }


        /**
         * Service Call: GetVendors
         * @return
         * @throws Exception invalid function signature message
         */
        public function GetVendors()
        {
            return $this->__soapCall("GetVendors", array());
        }


        /**
         * Service Call: UpdateVendor
         * @return
         * @throws Exception invalid function signature message
         */
        public function UpdateVendor()
        {
            return $this->__soapCall("UpdateVendor", array());
        }


        /**
         * Service Call: CreateVendor
         * @return
         * @throws Exception invalid function signature message
         */
        public function CreateVendor()
        {
            return $this->__soapCall("CreateVendor", array());
        }


        /**
         * Service Call: VendorExists
         * @return
         * @throws Exception invalid function signature message
         */
        public function VendorExists()
        {
            return $this->__soapCall("VendorExists", array());
        }


        /**
         * Service Call: NumberOfModifiedVendors
         * @return
         * @throws Exception invalid function signature message
         */
        public function NumberOfModifiedVendors()
        {
            return $this->__soapCall("NumberOfModifiedVendors", array());
        }


        /**
         * Service Call: GetVendorItem
         * @return
         * @throws Exception invalid function signature message
         */
        public function GetVendorItem()
        {
            return $this->__soapCall("GetVendorItem", array());
        }


        /**
         * Service Call: GetVendorItems
         * @return
         * @throws Exception invalid function signature message
         */
        public function GetVendorItems()
        {
            return $this->__soapCall("GetVendorItems", array());
        }


        /**
         * Service Call: GetVendorTransactions
         * @return
         * @throws Exception invalid function signature message
         */
        public function GetVendorTransactions()
        {
            return $this->__soapCall("GetVendorTransactions", array());
        }


        /**
         * Service Call: GetVendorTransactionsEx
         * @return
         * @throws Exception invalid function signature message
         */
        public function GetVendorTransactionsEx()
        {
            return $this->__soapCall("GetVendorTransactionsEx", array());
        }


        /**
         * Service Call: GetVendorInvoices
         * @return
         * @throws Exception invalid function signature message
         */
        public function GetVendorInvoices()
        {
            return $this->__soapCall("GetVendorInvoices", array());
        }


        /**
         * Service Call: VendorInvoiceApprovement
         * @return
         * @throws Exception invalid function signature message
         */
        public function VendorInvoiceApprovement()
        {
            return $this->__soapCall("VendorInvoiceApprovement", array());
        }


        /**
         * Service Call: GetVendorInvoiceattachment
         * @return
         * @throws Exception invalid function signature message
         */
        public function GetVendorInvoiceattachment()
        {
            return $this->__soapCall("GetVendorInvoiceattachment", array());
        }


        /**
         * Service Call: UploadVendorInvoiceAttachment
         * @return
         * @throws Exception invalid function signature message
         */
        public function UploadVendorInvoiceAttachment()
        {
            return $this->__soapCall("UploadVendorInvoiceAttachment", array());
        }


        /**
         * Service Call: CreatePurchaseOrder
         * @return
         * @throws Exception invalid function signature message
         */
        public function CreatePurchaseOrder()
        {
            return $this->__soapCall("CreatePurchaseOrder", array());
        }


        /**
         * Service Call: DeletePurchaseOrder
         * @return
         * @throws Exception invalid function signature message
         */
        public function DeletePurchaseOrder()
        {
            return $this->__soapCall("DeletePurchaseOrder", array());
        }


        /**
         * Service Call: GetPurchaseOrder
         * @return
         * @throws Exception invalid function signature message
         */
        public function GetPurchaseOrder()
        {
            return $this->__soapCall("GetPurchaseOrder", array());
        }


        /**
         * Service Call: GetPurchaseOrderByNumber
         * @return
         * @throws Exception invalid function signature message
         */
        public function GetPurchaseOrderByNumber()
        {
            return $this->__soapCall("GetPurchaseOrderByNumber", array());
        }


        /**
         * Service Call: GetPurchaseOrders
         * @return
         * @throws Exception invalid function signature message
         */
        public function GetPurchaseOrders()
        {
            return $this->__soapCall("GetPurchaseOrders", array());
        }


        /**
         * Service Call: GetPurchaseOrderFromReference
         * @return
         * @throws Exception invalid function signature message
         */
        public function GetPurchaseOrderFromReference()
        {
            return $this->__soapCall("GetPurchaseOrderFromReference", array());
        }


        /**
         * Service Call: UpdatePurchaseOrder
         * @return
         * @throws Exception invalid function signature message
         */
        public function UpdatePurchaseOrder()
        {
            return $this->__soapCall("UpdatePurchaseOrder", array());
        }


        /**
         * Service Call: UpdatePurchaseOrderLine
         * @return
         * @throws Exception invalid function signature message
         */
        public function UpdatePurchaseOrderLine()
        {
            return $this->__soapCall("UpdatePurchaseOrderLine", array());
        }


        /**
         * Service Call: DeletePurchaseOrderLine
         * @return
         * @throws Exception invalid function signature message
         */
        public function DeletePurchaseOrderLine()
        {
            return $this->__soapCall("DeletePurchaseOrderLine", array());
        }


        /**
         * Service Call: CreateSubscriptionOrder
         * @return
         * @throws Exception invalid function signature message
         */
        public function CreateSubscriptionOrder()
        {
            return $this->__soapCall("CreateSubscriptionOrder", array());
        }


        /**
         * Service Call: GetSubscriptionOrders
         * @return
         * @throws Exception invalid function signature message
         */
        public function GetSubscriptionOrders()
        {
            return $this->__soapCall("GetSubscriptionOrders", array());
        }


        /**
         * Service Call: UpdateSubscriptionOrder
         * @return
         * @throws Exception invalid function signature message
         */
        public function UpdateSubscriptionOrder()
        {
            return $this->__soapCall("UpdateSubscriptionOrder", array());
        }


        /**
         * Service Call: UpdateSubscriptionOrderLine
         * @return
         * @throws Exception invalid function signature message
         */
        public function UpdateSubscriptionOrderLine()
        {
            return $this->__soapCall("UpdateSubscriptionOrderLine", array());
        }


        /**
         * Service Call: GetEmployees
         * @return
         * @throws Exception invalid function signature message
         */
        public function GetEmployees()
        {
            return $this->__soapCall("GetEmployees", array());
        }


        /**
         * Service Call: CreateInvoice
         * @return
         * @throws Exception invalid function signature message
         */
        public function CreateInvoice()
        {
            return $this->__soapCall("CreateInvoice", array());
        }


        /**
         * Service Call: CreateInvoices
         * @return
         * @throws Exception invalid function signature message
         */
        public function CreateInvoices()
        {
            return $this->__soapCall("CreateInvoices", array());
        }


        /**
         * Service Call: GetInvoice
         * @return
         * @throws Exception invalid function signature message
         */
        public function GetInvoice()
        {
            return $this->__soapCall("GetInvoice", array());
        }


        /**
         * Service Call: GetInvoicesModified
         * @return
         * @throws Exception invalid function signature message
         */
        public function GetInvoicesModified()
        {
            return $this->__soapCall("GetInvoicesModified", array());
        }


        /**
         * Service Call: GetUnPostedInvoices
         * @return
         * @throws Exception invalid function signature message
         */
        public function GetUnPostedInvoices()
        {
            return $this->__soapCall("GetUnPostedInvoices", array());
        }


        /**
         * Service Call: GetInvoices
         * @return
         * @throws Exception invalid function signature message
         */
        public function GetInvoices()
        {
            return $this->__soapCall("GetInvoices", array());
        }


        /**
         * Service Call: GetInvoicesChunk
         * @return
         * @throws Exception invalid function signature message
         */
        public function GetInvoicesChunk()
        {
            return $this->__soapCall("GetInvoicesChunk", array());
        }


        /**
         * Service Call: GetInvoicesEx
         * @return
         * @throws Exception invalid function signature message
         */
        public function GetInvoicesEx()
        {
            return $this->__soapCall("GetInvoicesEx", array());
        }


        /**
         * Service Call: GetInvoicesFromClaims
         * @return
         * @throws Exception invalid function signature message
         */
        public function GetInvoicesFromClaims()
        {
            return $this->__soapCall("GetInvoicesFromClaims", array());
        }


        /**
         * Service Call: DeleteInvoiceFromReference
         * @return
         * @throws Exception invalid function signature message
         */
        public function DeleteInvoiceFromReference()
        {
            return $this->__soapCall("DeleteInvoiceFromReference", array());
        }


        /**
         * Service Call: GetSalesStatistic
         * @return
         * @throws Exception invalid function signature message
         */
        public function GetSalesStatistic()
        {
            return $this->__soapCall("GetSalesStatistic", array());
        }


        /**
         * Service Call: CreateOrder
         * @return
         * @throws Exception invalid function signature message
         */
        public function CreateOrder()
        {
            return $this->__soapCall("CreateOrder", array());
        }


        /**
         * Service Call: CreateCustomerItemreceiverLocationOrder
         * @return
         * @throws Exception invalid function signature message
         */
        public function CreateCustomerItemreceiverLocationOrder()
        {
            return $this->__soapCall("CreateCustomerItemreceiverLocationOrder", array());
        }


        /**
         * Service Call: GetOrder
         * @return
         * @throws Exception invalid function signature message
         */
        public function GetOrder()
        {
            return $this->__soapCall("GetOrder", array());
        }


        /**
         * Service Call: GetOrders
         * @return
         * @throws Exception invalid function signature message
         */
        public function GetOrders()
        {
            return $this->__soapCall("GetOrders", array());
        }


        /**
         * Service Call: AddToOrder
         * @return
         * @throws Exception invalid function signature message
         */
        public function AddToOrder()
        {
            return $this->__soapCall("AddToOrder", array());
        }


        /**
         * Service Call: RemoveFromOrder
         * @return
         * @throws Exception invalid function signature message
         */
        public function RemoveFromOrder()
        {
            return $this->__soapCall("RemoveFromOrder", array());
        }


        /**
         * Service Call: UpdateOrderLine
         * @return
         * @throws Exception invalid function signature message
         */
        public function UpdateOrderLine()
        {
            return $this->__soapCall("UpdateOrderLine", array());
        }


        /**
         * Service Call: DeleteOrder
         * @return
         * @throws Exception invalid function signature message
         */
        public function DeleteOrder()
        {
            return $this->__soapCall("DeleteOrder", array());
        }


        /**
         * Service Call: DeleteUnPostedInvoice
         * @return
         * @throws Exception invalid function signature message
         */
        public function DeleteUnPostedInvoice()
        {
            return $this->__soapCall("DeleteUnPostedInvoice", array());
        }


        /**
         * Service Call: CreatePaymentPlan
         * @return
         * @throws Exception invalid function signature message
         */
        public function CreatePaymentPlan()
        {
            return $this->__soapCall("CreatePaymentPlan", array());
        }


        /**
         * Service Call: CancelPaymentPlan
         * @return
         * @throws Exception invalid function signature message
         */
        public function CancelPaymentPlan()
        {
            return $this->__soapCall("CancelPaymentPlan", array());
        }


        /**
         * Service Call: GetQuote
         * @return
         * @throws Exception invalid function signature message
         */
        public function GetQuote()
        {
            return $this->__soapCall("GetQuote", array());
        }


        /**
         * Service Call: GetQuotes
         * @return
         * @throws Exception invalid function signature message
         */
        public function GetQuotes()
        {
            return $this->__soapCall("GetQuotes", array());
        }


        /**
         * Service Call: GetQuotesByDate
         * @return
         * @throws Exception invalid function signature message
         */
        public function GetQuotesByDate()
        {
            return $this->__soapCall("GetQuotesByDate", array());
        }


        /**
         * Service Call: GetQuotesInChunks
         * @return
         * @throws Exception invalid function signature message
         */
        public function GetQuotesInChunks()
        {
            return $this->__soapCall("GetQuotesInChunks", array());
        }


        /**
         * Service Call: DeleteQuote
         * @return
         * @throws Exception invalid function signature message
         */
        public function DeleteQuote()
        {
            return $this->__soapCall("DeleteQuote", array());
        }


        /**
         * Service Call: DoSOAction
         * @return
         * @throws Exception invalid function signature message
         */
        public function DoSOAction()
        {
            return $this->__soapCall("DoSOAction", array());
        }


        /**
         * Service Call: GetSalesPerson
         * @return
         * @throws Exception invalid function signature message
         */
        public function GetSalesPerson()
        {
            return $this->__soapCall("GetSalesPerson", array());
        }


        /**
         * Service Call: GetSalesPersons
         * @return
         * @throws Exception invalid function signature message
         */
        public function GetSalesPersons()
        {
            return $this->__soapCall("GetSalesPersons", array());
        }


        /**
         * Service Call: SalesPersonsExists
         * @return
         * @throws Exception invalid function signature message
         */
        public function SalesPersonsExists()
        {
            return $this->__soapCall("SalesPersonsExists", array());
        }


        /**
         * Service Call: getPaymentTypes
         * @return
         * @throws Exception invalid function signature message
         */
        public function getPaymentTypes()
        {
            return $this->__soapCall("getPaymentTypes", array());
        }


        /**
         * Service Call: GetAttachment
         * @return
         * @throws Exception invalid function signature message
         */
        public function GetAttachment()
        {
            return $this->__soapCall("GetAttachment", array());
        }


        /**
         * Service Call: GetAttachmentImage
         * @return
         * @throws Exception invalid function signature message
         */
        public function GetAttachmentImage()
        {
            return $this->__soapCall("GetAttachmentImage", array());
        }


        /**
         * Service Call: getCurency
         * @return
         * @throws Exception invalid function signature message
         */
        public function getCurency()
        {
            return $this->__soapCall("getCurency", array());
        }


        /**
         * Service Call: GetCountry
         * @return
         * @throws Exception invalid function signature message
         */
        public function GetCountry()
        {
            return $this->__soapCall("GetCountry", array());
        }


        /**
         * Service Call: GetCounty
         * @return
         * @throws Exception invalid function signature message
         */
        public function GetCounty()
        {
            return $this->__soapCall("GetCounty", array());
        }


        /**
         * Service Call: GetDim1
         * @return
         * @throws Exception invalid function signature message
         */
        public function GetDim1()
        {
            return $this->__soapCall("GetDim1", array());
        }


        /**
         * Service Call: GetDim2
         * @return
         * @throws Exception invalid function signature message
         */
        public function GetDim2()
        {
            return $this->__soapCall("GetDim2", array());
        }


        /**
         * Service Call: HasAnyMemeberSubscription
         * @return
         * @throws Exception invalid function signature message
         */
        public function HasAnyMemeberSubscription()
        {
            return $this->__soapCall("HasAnyMemeberSubscription", array());
        }


        /**
         * Service Call: ValidMemberSubscription
         * @return
         * @throws Exception invalid function signature message
         */
        public function ValidMemberSubscription()
        {
            return $this->__soapCall("ValidMemberSubscription", array());
        }


        /**
         * Service Call: GetMemberSubscriptionGroupTypes
         * @return
         * @throws Exception invalid function signature message
         */
        public function GetMemberSubscriptionGroupTypes()
        {
            return $this->__soapCall("GetMemberSubscriptionGroupTypes", array());
        }


        /**
         * Service Call: GetMemberSubscriptionGroups
         * @return
         * @throws Exception invalid function signature message
         */
        public function GetMemberSubscriptionGroups()
        {
            return $this->__soapCall("GetMemberSubscriptionGroups", array());
        }


        /**
         * Service Call: GetMemberSubscriptionAllergies
         * @return
         * @throws Exception invalid function signature message
         */
        public function GetMemberSubscriptionAllergies()
        {
            return $this->__soapCall("GetMemberSubscriptionAllergies", array());
        }


        /**
         * Service Call: CreateMemberSubscription
         * @return
         * @throws Exception invalid function signature message
         */
        public function CreateMemberSubscription()
        {
            return $this->__soapCall("CreateMemberSubscription", array());
        }


        /**
         * Service Call: GetMemberSubscription
         * @return
         * @throws Exception invalid function signature message
         */
        public function GetMemberSubscription()
        {
            return $this->__soapCall("GetMemberSubscription", array());
        }


        /**
         * Service Call: GetMemberSubscriptionByPassword
         * @return
         * @throws Exception invalid function signature message
         */
        public function GetMemberSubscriptionByPassword()
        {
            return $this->__soapCall("GetMemberSubscriptionByPassword", array());
        }


        /**
         * Service Call: PostValidSubscriptions
         * @return
         * @throws Exception invalid function signature message
         */
        public function PostValidSubscriptions()
        {
            return $this->__soapCall("PostValidSubscriptions", array());
        }


        /**
         * Service Call: GetCurrPrices
         * @return
         * @throws Exception invalid function signature message
         */
        public function GetCurrPrices()
        {
            return $this->__soapCall("GetCurrPrices", array());
        }


        /**
         * Service Call: GetJob
         * @return
         * @throws Exception invalid function signature message
         */
        public function GetJob()
        {
            return $this->__soapCall("GetJob", array());
        }


        /**
         * Service Call: GetJobs
         * @return
         * @throws Exception invalid function signature message
         */
        public function GetJobs()
        {
            return $this->__soapCall("GetJobs", array());
        }


        /**
         * Service Call: CreateJob
         * @return
         * @throws Exception invalid function signature message
         */
        public function CreateJob()
        {
            return $this->__soapCall("CreateJob", array());
        }


        /**
         * Service Call: UpdateJob
         * @return
         * @throws Exception invalid function signature message
         */
        public function UpdateJob()
        {
            return $this->__soapCall("UpdateJob", array());
        }


        /**
         * Service Call: AddToWorkJournal
         * @return
         * @throws Exception invalid function signature message
         */
        public function AddToWorkJournal()
        {
            return $this->__soapCall("AddToWorkJournal", array());
        }


        /**
         * Service Call: GetWorkItems
         * @return
         * @throws Exception invalid function signature message
         */
        public function GetWorkItems()
        {
            return $this->__soapCall("GetWorkItems", array());
        }


        /**
         * Service Call: AddWorkItem
         * @return
         * @throws Exception invalid function signature message
         */
        public function AddWorkItem()
        {
            return $this->__soapCall("AddWorkItem", array());
        }


        /**
         * Service Call: AddWorkItems
         * @return
         * @throws Exception invalid function signature message
         */
        public function AddWorkItems()
        {
            return $this->__soapCall("AddWorkItems", array());
        }


        /**
         * Service Call: UpdateWorkItem
         * @return
         * @throws Exception invalid function signature message
         */
        public function UpdateWorkItem()
        {
            return $this->__soapCall("UpdateWorkItem", array());
        }


        /**
         * Service Call: UpdateWorkItems
         * @return
         * @throws Exception invalid function signature message
         */
        public function UpdateWorkItems()
        {
            return $this->__soapCall("UpdateWorkItems", array());
        }


        /**
         * Service Call: DeleteWorkItem
         * @return
         * @throws Exception invalid function signature message
         */
        public function DeleteWorkItem()
        {
            return $this->__soapCall("DeleteWorkItem", array());
        }


        /**
         * Service Call: DeleteWorkItems
         * @return
         * @throws Exception invalid function signature message
         */
        public function DeleteWorkItems()
        {
            return $this->__soapCall("DeleteWorkItems", array());
        }


        /**
         * Service Call: GetWorkCostItems
         * @return
         * @throws Exception invalid function signature message
         */
        public function GetWorkCostItems()
        {
            return $this->__soapCall("GetWorkCostItems", array());
        }


        /**
         * Service Call: AddWorkCostItem
         * @return
         * @throws Exception invalid function signature message
         */
        public function AddWorkCostItem()
        {
            return $this->__soapCall("AddWorkCostItem", array());
        }


        /**
         * Service Call: AddWorkCostItems
         * @return
         * @throws Exception invalid function signature message
         */
        public function AddWorkCostItems()
        {
            return $this->__soapCall("AddWorkCostItems", array());
        }


        /**
         * Service Call: UpdateWorkCostItem
         * @return
         * @throws Exception invalid function signature message
         */
        public function UpdateWorkCostItem()
        {
            return $this->__soapCall("UpdateWorkCostItem", array());
        }


        /**
         * Service Call: UpdateWorkCostItems
         * @return
         * @throws Exception invalid function signature message
         */
        public function UpdateWorkCostItems()
        {
            return $this->__soapCall("UpdateWorkCostItems", array());
        }


        /**
         * Service Call: DeleteWorkCostItem
         * @return
         * @throws Exception invalid function signature message
         */
        public function DeleteWorkCostItem()
        {
            return $this->__soapCall("DeleteWorkCostItem", array());
        }


        /**
         * Service Call: DeleteWorkCostItems
         * @return
         * @throws Exception invalid function signature message
         */
        public function DeleteWorkCostItems()
        {
            return $this->__soapCall("DeleteWorkCostItems", array());
        }


        /**
         * Service Call: GetJobInvoices
         * @return
         * @throws Exception invalid function signature message
         */
        public function GetJobInvoices()
        {
            return $this->__soapCall("GetJobInvoices", array());
        }


        /**
         * Service Call: GetJobTransactions
         * @return
         * @throws Exception invalid function signature message
         */
        public function GetJobTransactions()
        {
            return $this->__soapCall("GetJobTransactions", array());
        }


        /**
         * Service Call: GetJobTransactionsEX
         * @return
         * @throws Exception invalid function signature message
         */
        public function GetJobTransactionsEX()
        {
            return $this->__soapCall("GetJobTransactionsEX", array());
        }


        /**
         * Service Call: CheckMember
         * @return
         * @throws Exception invalid function signature message
         */
        public function CheckMember()
        {
            return $this->__soapCall("CheckMember", array());
        }


        /**
         * Service Call: CheckMember2
         * @return
         * @throws Exception invalid function signature message
         */
        public function CheckMember2()
        {
            return $this->__soapCall("CheckMember2", array());
        }


        /**
         * Service Call: GetMember
         * @return
         * @throws Exception invalid function signature message
         */
        public function GetMember()
        {
            return $this->__soapCall("GetMember", array());
        }


        /**
         * Service Call: GetMembers
         * @return
         * @throws Exception invalid function signature message
         */
        public function GetMembers()
        {
            return $this->__soapCall("GetMembers", array());
        }


        /**
         * Service Call: GetMembersFromConditions
         * @return
         * @throws Exception invalid function signature message
         */
        public function GetMembersFromConditions()
        {
            return $this->__soapCall("GetMembersFromConditions", array());
        }


        /**
         * Service Call: GetMembersFromConditionsEx
         * @return
         * @throws Exception invalid function signature message
         */
        public function GetMembersFromConditionsEx()
        {
            return $this->__soapCall("GetMembersFromConditionsEx", array());
        }


        /**
         * Service Call: CreateMember
         * @return
         * @throws Exception invalid function signature message
         */
        public function CreateMember()
        {
            return $this->__soapCall("CreateMember", array());
        }


        /**
         * Service Call: UpdateMember
         * @return
         * @throws Exception invalid function signature message
         */
        public function UpdateMember()
        {
            return $this->__soapCall("UpdateMember", array());
        }


        /**
         * Service Call: UpdateMembers
         * @return
         * @throws Exception invalid function signature message
         */
        public function UpdateMembers()
        {
            return $this->__soapCall("UpdateMembers", array());
        }


        /**
         * Service Call: GetMembersEx
         * @return
         * @throws Exception invalid function signature message
         */
        public function GetMembersEx()
        {
            return $this->__soapCall("GetMembersEx", array());
        }


        /**
         * Service Call: GetModifiedMembers
         * @return
         * @throws Exception invalid function signature message
         */
        public function GetModifiedMembers()
        {
            return $this->__soapCall("GetModifiedMembers", array());
        }


        /**
         * Service Call: NumberOfModifiedMembers
         * @return
         * @throws Exception invalid function signature message
         */
        public function NumberOfModifiedMembers()
        {
            return $this->__soapCall("NumberOfModifiedMembers", array());
        }


        /**
         * Service Call: MemberActiveInVactionFund
         * @return
         * @throws Exception invalid function signature message
         */
        public function MemberActiveInVactionFund()
        {
            return $this->__soapCall("MemberActiveInVactionFund", array());
        }


        /**
         * Service Call: CreateMemberFee
         * @return
         * @throws Exception invalid function signature message
         */
        public function CreateMemberFee()
        {
            return $this->__soapCall("CreateMemberFee", array());
        }


        /**
         * Service Call: MemberExists
         * @return
         * @throws Exception invalid function signature message
         */
        public function MemberExists()
        {
            return $this->__soapCall("MemberExists", array());
        }


        /**
         * Service Call: isMemberInGroup
         * @return
         * @throws Exception invalid function signature message
         */
        public function isMemberInGroup()
        {
            return $this->__soapCall("isMemberInGroup", array());
        }


        /**
         * Service Call: GetMemberGroups
         * @return
         * @throws Exception invalid function signature message
         */
        public function GetMemberGroups()
        {
            return $this->__soapCall("GetMemberGroups", array());
        }


        /**
         * Service Call: GetMemberSubGroups
         * @return
         * @throws Exception invalid function signature message
         */
        public function GetMemberSubGroups()
        {
            return $this->__soapCall("GetMemberSubGroups", array());
        }


        /**
         * Service Call: isGovermentEmployee
         * @return
         * @throws Exception invalid function signature message
         */
        public function isGovermentEmployee()
        {
            return $this->__soapCall("isGovermentEmployee", array());
        }


        /**
         * Service Call: CreateApplication
         * @return
         * @throws Exception invalid function signature message
         */
        public function CreateApplication()
        {
            return $this->__soapCall("CreateApplication", array());
        }


        /**
         * Service Call: SendApplicationAttachment
         * @return
         * @throws Exception invalid function signature message
         */
        public function SendApplicationAttachment()
        {
            return $this->__soapCall("SendApplicationAttachment", array());
        }


        /**
         * Service Call: GetApplicationAttachmentInfo
         * @return
         * @throws Exception invalid function signature message
         */
        public function GetApplicationAttachmentInfo()
        {
            return $this->__soapCall("GetApplicationAttachmentInfo", array());
        }


        /**
         * Service Call: GetMembershipData
         * @return
         * @throws Exception invalid function signature message
         */
        public function GetMembershipData()
        {
            return $this->__soapCall("GetMembershipData", array());
        }


        /**
         * Service Call: GetAllMembershipCompanies
         * @return
         * @throws Exception invalid function signature message
         */
        public function GetAllMembershipCompanies()
        {
            return $this->__soapCall("GetAllMembershipCompanies", array());
        }


        /**
         * Service Call: GetWorkplaces
         * @return
         * @throws Exception invalid function signature message
         */
        public function GetWorkplaces()
        {
            return $this->__soapCall("GetWorkplaces", array());
        }


        /**
         * Service Call: GetAllWorkplaces
         * @return
         * @throws Exception invalid function signature message
         */
        public function GetAllWorkplaces()
        {
            return $this->__soapCall("GetAllWorkplaces", array());
        }


        /**
         * Service Call: GetMemberCarrerArray
         * @return
         * @throws Exception invalid function signature message
         */
        public function GetMemberCarrerArray()
        {
            return $this->__soapCall("GetMemberCarrerArray", array());
        }


        /**
         * Service Call: GetMemberMembershipArray
         * @return
         * @throws Exception invalid function signature message
         */
        public function GetMemberMembershipArray()
        {
            return $this->__soapCall("GetMemberMembershipArray", array());
        }


        /**
         * Service Call: GetMemberEducationArray
         * @return
         * @throws Exception invalid function signature message
         */
        public function GetMemberEducationArray()
        {
            return $this->__soapCall("GetMemberEducationArray", array());
        }


        /**
         * Service Call: GetMemberApplicationArray
         * @return
         * @throws Exception invalid function signature message
         */
        public function GetMemberApplicationArray()
        {
            return $this->__soapCall("GetMemberApplicationArray", array());
        }


        /**
         * Service Call: GetMemberFundsArray
         * @return
         * @throws Exception invalid function signature message
         */
        public function GetMemberFundsArray()
        {
            return $this->__soapCall("GetMemberFundsArray", array());
        }


        /**
         * Service Call: GetMemberSubGroupsArray
         * @return
         * @throws Exception invalid function signature message
         */
        public function GetMemberSubGroupsArray()
        {
            return $this->__soapCall("GetMemberSubGroupsArray", array());
        }


        /**
         * Service Call: GetMemberResumeTypes
         * @return
         * @throws Exception invalid function signature message
         */
        public function GetMemberResumeTypes()
        {
            return $this->__soapCall("GetMemberResumeTypes", array());
        }


        /**
         * Service Call: GetMemberResumeGroups
         * @return
         * @throws Exception invalid function signature message
         */
        public function GetMemberResumeGroups()
        {
            return $this->__soapCall("GetMemberResumeGroups", array());
        }


        /**
         * Service Call: GetMembersMovementsByTypeAndDate
         * @return
         * @throws Exception invalid function signature message
         */
        public function GetMembersMovementsByTypeAndDate()
        {
            return $this->__soapCall("GetMembersMovementsByTypeAndDate", array());
        }


        /**
         * Service Call: GetElections
         * @return
         * @throws Exception invalid function signature message
         */
        public function GetElections()
        {
            return $this->__soapCall("GetElections", array());
        }


        /**
         * Service Call: GetElection
         * @return
         * @throws Exception invalid function signature message
         */
        public function GetElection()
        {
            return $this->__soapCall("GetElection", array());
        }


        /**
         * Service Call: GetElectionLines
         * @return
         * @throws Exception invalid function signature message
         */
        public function GetElectionLines()
        {
            return $this->__soapCall("GetElectionLines", array());
        }


        /**
         * Service Call: ReturnVotes
         * @return
         * @throws Exception invalid function signature message
         */
        public function ReturnVotes()
        {
            return $this->__soapCall("ReturnVotes", array());
        }


        /**
         * Service Call: TimeClockStampedInEmployees
         * @return
         * @throws Exception invalid function signature message
         */
        public function TimeClockStampedInEmployees()
        {
            return $this->__soapCall("TimeClockStampedInEmployees", array());
        }


        /**
         * Service Call: TimeClockStampEmployee
         * @return
         * @throws Exception invalid function signature message
         */
        public function TimeClockStampEmployee()
        {
            return $this->__soapCall("TimeClockStampEmployee", array());
        }


        /**
         * Service Call: TimeClockEmployeeStatus
         * @return
         * @throws Exception invalid function signature message
         */
        public function TimeClockEmployeeStatus()
        {
            return $this->__soapCall("TimeClockEmployeeStatus", array());
        }


        /**
         * Service Call: GetCourses
         * @return
         * @throws Exception invalid function signature message
         */
        public function GetCourses()
        {
            return $this->__soapCall("GetCourses", array());
        }


        /**
         * Service Call: GetCompletedCourses
         * @return
         * @throws Exception invalid function signature message
         */
        public function GetCompletedCourses()
        {
            return $this->__soapCall("GetCompletedCourses", array());
        }


        /**
         * Service Call: GetCancelledCourses
         * @return
         * @throws Exception invalid function signature message
         */
        public function GetCancelledCourses()
        {
            return $this->__soapCall("GetCancelledCourses", array());
        }


        /**
         * Service Call: GetParticipantCourses
         * @return
         * @throws Exception invalid function signature message
         */
        public function GetParticipantCourses()
        {
            return $this->__soapCall("GetParticipantCourses", array());
        }


        /**
         * Service Call: GetParticipantCourseTypes
         * @return
         * @throws Exception invalid function signature message
         */
        public function GetParticipantCourseTypes()
        {
            return $this->__soapCall("GetParticipantCourseTypes", array());
        }


        /**
         * Service Call: GetParticipantsInCourse
         * @return
         * @throws Exception invalid function signature message
         */
        public function GetParticipantsInCourse()
        {
            return $this->__soapCall("GetParticipantsInCourse", array());
        }


        /**
         * Service Call: GetCourseTypes
         * @return
         * @throws Exception invalid function signature message
         */
        public function GetCourseTypes()
        {
            return $this->__soapCall("GetCourseTypes", array());
        }


        /**
         * Service Call: EnrollInCourse
         * @return
         * @throws Exception invalid function signature message
         */
        public function EnrollInCourse()
        {
            return $this->__soapCall("EnrollInCourse", array());
        }


        /**
         * Service Call: RemoveParticipantFromCourse
         * @return
         * @throws Exception invalid function signature message
         */
        public function RemoveParticipantFromCourse()
        {
            return $this->__soapCall("RemoveParticipantFromCourse", array());
        }


        /**
         * Service Call: ChangeParticipantPaymentStatus
         * @return
         * @throws Exception invalid function signature message
         */
        public function ChangeParticipantPaymentStatus()
        {
            return $this->__soapCall("ChangeParticipantPaymentStatus", array());
        }


        /**
         * Service Call: GetLocation
         * @return
         * @throws Exception invalid function signature message
         */
        public function GetLocation()
        {
            return $this->__soapCall("GetLocation", array());
        }


        /**
         * Service Call: CreateEMBooking
         * @return
         * @throws Exception invalid function signature message
         */
        public function CreateEMBooking()
        {
            return $this->__soapCall("CreateEMBooking", array());
        }


        /**
         * Service Call: GetEMResourceGroups
         * @return
         * @throws Exception invalid function signature message
         */
        public function GetEMResourceGroups()
        {
            return $this->__soapCall("GetEMResourceGroups", array());
        }


        /**
         * Service Call: AuthenticateUser
         * @return
         * @throws Exception invalid function signature message
         */
        public function AuthenticateUser()
        {
            return $this->__soapCall("AuthenticateUser", array());
        }


        /**
         * Service Call: getUsers
         * @return
         * @throws Exception invalid function signature message
         */
        public function getUsers()
        {
            return $this->__soapCall("getUsers", array());
        }


        /**
         * Service Call: GetCompany
         * @return
         * @throws Exception invalid function signature message
         */
        public function GetCompany()
        {
            return $this->__soapCall("GetCompany", array());
        }


        /**
         * Service Call: GetUserCompanies
         * @return
         * @throws Exception invalid function signature message
         */
        public function GetUserCompanies()
        {
            return $this->__soapCall("GetUserCompanies", array());
        }


        /**
         * Service Call: CreateToken
         * @return
         * @throws Exception invalid function signature message
         */
        public function CreateToken()
        {
            return $this->__soapCall("CreateToken", array());
        }


        /**
         * Service Call: CreateTokenForUser
         * @return
         * @throws Exception invalid function signature message
         */
        public function CreateTokenForUser()
        {
            return $this->__soapCall("CreateTokenForUser", array());
        }


        /**
         * Service Call: RemoveToken
         * @return
         * @throws Exception invalid function signature message
         */
        public function RemoveToken()
        {
            return $this->__soapCall("RemoveToken", array());
        }


        /**
         * Service Call: GetToken
         * @return
         * @throws Exception invalid function signature message
         */
        public function GetToken()
        {
            return $this->__soapCall("GetToken", array());
        }


        /**
         * Service Call: ValidateToken
         * @return
         * @throws Exception invalid function signature message
         */
        public function ValidateToken()
        {
            return $this->__soapCall("ValidateToken", array());
        }


        /**
         * Service Call: RefreshToken
         * @return
         * @throws Exception invalid function signature message
         */
        public function RefreshToken()
        {
            return $this->__soapCall("RefreshToken", array());
        }


    }
}
?>