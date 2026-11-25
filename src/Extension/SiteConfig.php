<?php

namespace Netwerkstatt\Contact\Extension;

use SilverStripe\Core\Extension;
use SilverStripe\Control\Email\Email;
use SilverStripe\Forms\EmailField;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\HTMLEditor\HTMLEditorField;

/**
 * Class \Netwerkstatt\Contact\Extension\SiteConfig
 *
 * @property \SilverStripe\SiteConfig\SiteConfig|SiteConfig $owner
 * @property string $ContactFormRecipientAddress
 * @property string $ContactFormSenderAddress
 * @property string $ContactFormSuccessMessage
 */
class SiteConfig extends Extension
{
    /**
     * @config
     */
    private static $db = [
//        'ContactFormTitle' => 'Varchar(255)',
        'ContactFormRecipientAddress' => 'Varchar(255)',
        'ContactFormSenderAddress' => 'Varchar(255)',
        'ContactFormSuccessMessage' => 'HTMLText',
    ];

    public function updateCMSFields(FieldList $fields)
    {
        $fields->findOrMakeTab('Root.Contact')->setTitle(
            _t('ContactSiteConfig.ContactTabTitle', 'Contact Form Settings')
        );
        $fields->addFieldsToTab('Root.Contact', [
//            TextField::create('ContactFormTitle', $this->getOwner()->fieldLabel('ContactFormTitle')),
            EmailField::create(
                'ContactFormRecipientAddress',
                $this->getOwner()->fieldLabel('ContactFormRecipientAddress')
            )
                ->setDescription($this->getOwner()->fieldLabel('ContactFormRecipientAddressDescription'))
            ,
            EmailField::create(
                'ContactFormSenderAddress',
                $this->getOwner()->fieldLabel('ContactFormSenderAddress')
            )
                ->setDescription($this->getOwner()->fieldLabel('ContactFormSenderAddressDescription')),
            HtmlEditorField::create(
                'ContactFormSuccessMessage',
                $this->getOwner()->fieldLabel('ContactFormSuccessMessage')
            )
        ]);
    }

    public function updateFieldLabels(&$labels)
    {
        $admin_email = Email::config()->get('admin_email');

        $labels['ContactFormRecipientAddressDescription'] = _t(
            'ContactSiteConfig.ContactFormRecipientAddressDescription',
            'Recipient Address. {email} if left blank',
            ['email' => $admin_email]
        );
        $labels['ContactFormSenderAddressDescription'] = _t(
            'ContactSiteConfig.ContactFormSenderAddressDescription',
            'Sender Address. {email} if left blank',
            ['email' => $admin_email]
        );
    }
}
