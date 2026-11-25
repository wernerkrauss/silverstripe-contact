<?php

namespace Netwerkstatt\Contact\Admin;

use Netwerkstatt\Contact\Model\ContactRequest;
use SilverStripe\Admin\ModelAdmin;

/**
 * Class \Netwerkstatt\Contact\Admin\ContactAdmin
 *
 */
class ContactAdmin extends ModelAdmin
{
    /**
     * @config
     */
    private static $managed_models = [
        ContactRequest::class,
    ];

    /**
     * @config
     */
    private static $url_segment = 'contact';

    /**
     * @config
     */
    private static $menu_title = 'Contact Requests';
}
