<?php

namespace Netwerkstatt\Contact\Element;

use DNADesign\Elemental\Controllers\ElementController;
use Netwerkstatt\Contact\Controller\ContactFormTrait;
use SilverStripe\CMS\Model\SiteTree;
use SilverStripe\Control\Controller;
use RuntimeException;

/**
 * Class \Netwerkstatt\Contact\Element\ContactController
 *
 */
class ContactController extends ElementController
{
    use ContactFormTrait;

    /**
     * @config
     */
    private static $allowed_actions = [
        'ContactForm',
        'sendContactForm',
        'renderForm',
    ];

    protected function getFormSubmissionLink(): string
    {
        return $this->getElementActionLink('sendContactForm');
    }

    public function getControllerLink(string $action): string
    {
        return $this->getElementActionLink($action);
    }

    private function getElementActionLink(string $action): string
    {
        $page = $this->getElement()->getPage();
        if (!$page instanceof SiteTree) {
            throw new RuntimeException('The contact element must belong to a page.');
        }

        return Controller::join_links(
            $page->Link(true),
            'element',
            $this->ID,
            $action
        );
    }
}
