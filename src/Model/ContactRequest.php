<?php

namespace Netwerkstatt\Contact\Model;

use Override;
use SilverStripe\Control\Email\Email;
use SilverStripe\ORM\DataObject;
use SilverStripe\SiteConfig\SiteConfig;

/**
 * Class \Netwerkstatt\Contact\Model\ContactRequest
 *
 * @property string $Street
 * @property string $Zip
 * @property string $City
 * @property string $Country
 * @property string $ArrivalDate
 * @property string $DepartureDate
 * @property int $Adults
 * @property int $Children
 * @property string $FirstName
 * @property string $Surname
 * @property string $Email
 * @property string $Phone
 * @property string $Message
 * @property int $ContactTravelTypeID
 */
class ContactRequest extends DataObject
{
    /**
     * @config
     */
    private static $table_name = 'ContactRequest';

    /**
     * @config
     */
    private static $db = [
        'FirstName' => 'Varchar',
        'Surname' => 'Varchar',
        'Email' => 'Email',
        'Phone' => 'Varchar',
        'Message' => 'Text',
    ];

    /**
     * @config
     */
    private static $summary_fields = [
        'Created.Nice' => 'Datum',
        'Surname',
        'FirstName',
        'Email',
    ];

    /**
     * @config
     */
    private static $default_sort = 'Created DESC';


    #[Override]
    public function canEdit($member = null): bool
    {
        return false;
    }

    #[Override]
    public function canDelete($member = null): bool
    {
        return false;
    }

    public function sendEmail()
    {
        $admin_email = Email::config()->get('admin_email');
        $from = SiteConfig::current_site_config()->ContactFormSenderAddress ?: $admin_email;
        $replyTo = $this->Email;
        $to = SiteConfig::current_site_config()->ContactFormRecipientAddress ?: $admin_email;
        $subject = _t(
            'ContactRequest.EmailSubject',
            'Contact Request from {firstname} {surname}',
            [
                'firstname' => $this->FirstName,
                'surname' => $this->Surname
            ]
        );
        $email = Email::create($from, $to, $subject);
        $email->setReplyTo($replyTo);
        $email->setHTMLTemplate('Netwerkstatt\Contact\Email\ContactRequest');
        $email->setPlainTemplate('Netwerkstatt\Contact\Email\ContactRequest_plain');
        $email->setData($this);

        $email->send();
    }

    public function getRequiredFields(): array
    {
        $required = ['Surname', 'Email', 'Message'];

        $this->extend('updateRequiredFields', $required);

        return $required;
    }
}
