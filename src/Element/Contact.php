<?php

namespace Netwerkstatt\Site\Element;

use SilverStripe\Model\ArrayData;
use DNADesign\Elemental\Models\BaseElement;
use SilverStripe\Control\Controller;
use SilverStripe\SiteConfig\SiteConfig as SSSiteConfig;
use Netwerkstatt\Contact\Element\ContactController;

/**
 * Class \Netwerkstatt\Contact\Element\Contact
 *
 */
class Contact extends BaseElement
{
    /**
     * @config
     */
    private static $table_name = 'ElementContact';

    /**
     * @config
     */
    private static $singular_name = 'Contact form element';

    /**
     * @config
     */
    private static $plural_name = 'Contact form elements';

    private static $class_description = 'A simple contact form element';

    private static $controller_class = ContactController::class;

    /**
     * @config
     */
    private static bool $inline_editable = false;


    public function ContactForm()
    {
        /** @var ContactController $controller */
        $controller = $this->getController();
        return $controller->ContactForm();
    }

    public function getFormInfo(): ArrayData
    {
        $session = Controller::curr()->getRequest()->getSession();
        $key = 'ContactForm.info.' . $this->ID;
        $info = $session->get($key) ?: [];

        if ($info) {
            $session->clear($key);
        }

        return ArrayData::create($info);
    }

    public function getSuccessMessage()
    {
        $siteConfig = SSSiteConfig::current_site_config();

        return $siteConfig->ContactFormSuccessMessage;
    }
}
