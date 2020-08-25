<?php


namespace FelixBraspag\Marketplace\Sellers;

class Subordinates implements \JsonSerializable
{
    private $masterMerchantId;
    private $merchantId;
    private $corporateName;
    private $fancyName;
    private $documentNumber;
    private $documentType;
    private $merchantCategoryCode;
    private $contactName;
    private $contactPhone;
    private $mailAddress;
    private $website;
    private $bankAccount;
    private $address;
    private $agreement;
    private $notification;
    private $attachments;

    private $blocked;
    private $analysis;

    public function __construct()
    {
        $this->bankAccount = new \stdClass();
        $this->bankAccount->bank = null;
        $this->bankAccount->bankAccountType = null;
        $this->bankAccount->number = null;
        $this->bankAccount->operation = null;
        $this->bankAccount->verifierDigit = null;
        $this->bankAccount->agencyNumber = null;
        $this->bankAccount->agencyDigit = null;
        $this->bankAccount->documentNumber = null;
        $this->bankAccount->documentType = null;

        $this->address = new \stdClass();
        $this->address->street = null;
        $this->address->number = null;
        $this->address->complement = null;
        $this->address->neighborhood = null;
        $this->address->city = null;
        $this->address->state = null;
        $this->address->zipCode = null;

        $this->agreement = new \stdClass();
        $this->agreement->fee = null;
        $this->agreement->mdrPercentage = null;
        $this->agreement->merchantDiscountRates = null;

        $this->notification = new \stdClass();
        $this->notification->url = null;
        $this->notification->headers = null;

        $this->attachments = null;

        $this->analysis = new \stdClass();
        $this->analysis->status = null;
        $this->analysis->score = null;
        $this->analysis->denialReason = null;

    }

    public function getMasterMerchantId()
    {
        return $this->masterMerchantId ?? null;
    }

    public function setMasterMerchantId($masterMerchantId)
    {
        $this->masterMerchantId = $masterMerchantId;

        return $this;
    }

    public function getMerchantId()
    {
        return $this->merchantId ?? null;
    }

    public function setMerchantId($merchantId)
    {
        $this->merchantId = $merchantId;

        return $this;
    }

    public function getCorporateName()
    {
        return $this->corporateName ?? null;
    }

    public function setCorporateName($corporateName)
    {
        $this->corporateName = $corporateName;

        return $this;
    }

    public function getFancyName()
    {
        return $this->subordinateMerchantId ?? null;
    }

    public function setFancyName($fancyName)
    {
        $this->fancyName = $fancyName;

        return $this;
    }

    public function getDocumentNumber()
    {
        return $this->documentNumber ?? null;
    }

    public function setDocumentNumber($documentNumber)
    {
        $this->documentNumber = $documentNumber;

        return $this;
    }

    public function getDocumentType()
    {
        return $this->documentType ?? null;
    }

    public function setDocumentType($documentType)
    {
        $this->documentType = $documentType;

        return $this;
    }

    public function getMerchantCategoryCode()
    {
        return $this->merchantCategoryCode ?? null;
    }

    public function setMerchantCategoryCode($merchantCategoryCode)
    {
        $this->merchantCategoryCode = $merchantCategoryCode;

        return $this;
    }

    public function getContactName()
    {
        return $this->contactName ?? null;
    }

    public function setContactName($contactName)
    {
        $this->contactName = $contactName;

        return $this;
    }

    public function getContactPhone()
    {
        return $this->contactPhone ?? null;
    }

    public function setContactPhone($contactPhone)
    {
        $this->contactPhone = $contactPhone;

        return $this;
    }

    public function getMailAddress()
    {
        return $this->MailAddress ?? null;
    }

    public function setMailAddress($mailAddress)
    {
        $this->mailAddress = $mailAddress;

        return $this;
    }

    public function getWebsite()
    {
        return $this->website ?? null;
    }

    public function setWebsite($website)
    {
        $this->website = $website;

        return $this;
    }

    public function getBankAccountBank()
    {
        return $this->bankAccount->bank ?? null;
    }

    public function setBankAccountBank($bank)
    {
        $this->bankAccount->bank = $bank;

        return $this;
    }

    public function getBankAccountBankAccountType()
    {
        return $this->bankAccount->bankAccountType ?? null;
    }

    public function setBankAccountBankAccountType($bankAccountType)
    {
        $this->bankAccount->bankAccountType = $bankAccountType;

        return $this;
    }

    public function getBankAccountNumber()
    {
        return $this->bankAccount->number ?? null;
    }

    public function setBankAccountNumber($number)
    {
        $this->bankAccount->number = $number;

        return $this;
    }

    public function getBankAccountOperation()
    {
        return $this->bankAccount->operation ?? null;
    }

    public function setBankAccountOperation($operation)
    {
        $this->bankAccount->operation = $operation;

        return $this;
    }

    public function getBankAccountVerifierDigit()
    {
        return $this->bankAccount->verifierDigit ?? null;
    }

    public function setBankAccountVerifierDigit($verifierDigit)
    {
        $this->bankAccount->verifierDigit = $verifierDigit;

        return $this;
    }

    public function getBankAccountAgencyNumber()
    {
        return $this->bankAccount->agencyNumber ?? null;
    }

    public function setBankAccountAgencyNumber($agencyNumber)
    {
        $this->bankAccount->agencyNumber = $agencyNumber;

        return $this;
    }

    public function getBankAccountAgencyDigit()
    {
        return $this->bankAccount->agencyDigit ?? null;
    }

    public function setBankAccountAgencyDigit($agencyDigit)
    {
        $this->bankAccount->agencyDigit = $agencyDigit;

        return $this;
    }

    public function getBankAccountDocumentNumber()
    {
        return $this->bankAccount->documentNumber ?? null;
    }

    public function setBankAccountDocumentNumber($documentNumber)
    {
        $this->bankAccount->documentNumber = $documentNumber;

        return $this;
    }

    public function getBankAccountDocumentType()
    {
        return $this->bankAccount->documentType ?? null;
    }

    public function setBankAccountDocumentType($documentType)
    {
        $this->bankAccount->documentType = $documentType;

        return $this;
    }

    public function getAddressStreet()
    {
        return $this->address->street ?? null;
    }

    public function setAddressStreet($street)
    {
        $this->address->street = $street;

        return $this;
    }

    public function getAddressNumber()
    {
        return $this->address->number ?? null;
    }

    public function setAddressNumber($number)
    {
        $this->address->number = $number;

        return $this;
    }

    public function getAddressComplement()
    {
        return $this->address->complement ?? null;
    }

    public function setAddressComplement($complement)
    {
        $this->address->complement = $complement;

        return $this;
    }

    public function getAddressNeighborhood()
    {
        return $this->address->neighborhood ?? null;
    }

    public function setAddressNeighborhood($neighborhood)
    {
        $this->address->neighborhood = $neighborhood;

        return $this;
    }

    public function getAddressCity()
    {
        return $this->address->city ?? null;
    }

    public function setAddressCity($city)
    {
        $this->address->city = $city;

        return $this;
    }

    public function getAddressState()
    {
        return $this->address->state ?? null;
    }

    public function setAddressState($state)
    {
        $this->address->state = $state;

        return $this;
    }

    public function getAddressZipCode()
    {
        return $this->address->zipCode ?? null;
    }

    public function setAddressZipCode($zipCode)
    {
        $this->address->zipCode = $zipCode;

        return $this;
    }

    public function getAgreementFee()
    {
        return $this->agreement->fee ?? null;
    }

    public function setAgreementFee($fee)
    {
        $this->agreement->fee = $fee;

        return $this;
    }

    public function getAgreementMdrPercentage()
    {
        return $this->agreement->mdrPercentage ?? null;
    }

    public function setAgreementMdrPercentage($mdrPercentage)
    {
        $this->agreement->mdrPercentage = $mdrPercentage;

        return $this;
    }

    public function getAgreementMerchantDiscountRates()
    {
        return $this->agreement->merchantDiscountRates ?? null;
    }

    public function setAgreementMerchantDiscountRates(array $merchantDiscountRates)
    {
        $this->agreement->merchantDiscountRates = $merchantDiscountRates;

        return $this;
    }

    public function getNotificationUrl()
    {
        return $this->notification->url ?? null;
    }

    public function setNotificationUrl($url)
    {
        $this->notification->url = $url;

        return $this;
    }

    public function getNotificationHeaders()
    {
        return $this->notification->headers ?? null;
    }

    public function setNotificationHeaders(array $headers)
    {
        $this->notification->headers = $headers;

        return $this;
    }

    public function getAttachments()
    {
        return $this->attachments ?? null;
    }

    public function setAttachments(array $attachments)
    {
        $this->attachments = $attachments;

        return $this;
    }

    public function getBlocked()
    {
        return $this->blocked ?? null;
    }

    public function getAnalysis()
    {
        return $this->analysis ?? null;
    }

    public function jsonSerialize()
    {

        $objects = get_object_vars($this);

        if(isset($objects['masterMerchantId'])){
            unset($objects['masterMerchantId']);
        }

        if(isset($objects['merchantId'])){
            unset($objects['merchantId']);
        }

        if(isset($objects['analysis'])){
            unset($objects['analysis']);
        }

        return $objects;
    }

    public static function fromJson($json)
    {
        $object = json_decode($json);

        $subordinate = new Subordinates();
        $subordinate->populate($object);

        return $subordinate;
    }

    public function populate(\stdClass $data)
    {
        $this->masterMerchantId         = $data->MasterMerchantId ?? null;
        $this->merchantId               = $data->MerchantId ?? null;
        $this->corporateName            = $data->CorporateName ?? null;
        $this->fancyName                = $data->MasterMerchantId ?? null;
        $this->documentNumber           = $data->FancyName ?? null;
        $this->documentType             = $data->DocumentType ?? null;
        $this->merchantCategoryCode     = $data->MerchantCategoryCode ?? null;
        $this->contactName              = $data->ContactName ?? null;
        $this->contactPhone             = $data->ContactPhone ?? null;
        $this->mailAddress              = $data->MailAddress ?? null;
        $this->website                  = $data->Website ?? null;
        $this->bankAccount              = $data->BankAccount ?? null;
        $this->address                  = $data->Address ?? null;
        $this->agreement                = $data->Agreement ?? null;
        $this->notification             = $data->Notification ?? null;
        $this->attachments              = $data->Attachments ?? null;

        $this->blocked                  = $data->Blocked ?? null;
        $this->analysis->status         = $data->Analysis->Status ?? null;
        $this->analysis->score          = $data->Analysis->Score ?? null;
        $this->analysis->denialReason   = $data->Analysis->DenialReason ?? null;

    }
}
