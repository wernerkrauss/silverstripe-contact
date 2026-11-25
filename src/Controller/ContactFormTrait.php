<?php

namespace Netwerkstatt\Contact\Controller;

use Exception;
use Netwerkstatt\Contact\Model\ContactRequest;
use SilverStripe\Control\HTTPRequest;
use SilverStripe\Control\HTTPResponse;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\Form;
use SilverStripe\Forms\FormAction;
use SilverStripe\Forms\Validation\RequiredFieldsValidator;
use Psr\Log\LoggerInterface;
use SilverStripe\Core\Injector\Injector;

trait ContactFormTrait
{
    public function renderForm(): HTTPResponse|string
    {
        if ($this->isAjaxRequest()) {
            return $this->renderWith(
                'Netwerkstatt/Contact/Element/ContactFormPartial',
                ['RenderedForm' => $this->ContactForm()]
            );
        }

        return $this->redirect($this->Link());
    }

    public function ContactForm(): Form
    {
        $contactRequest = singleton(ContactRequest::class);
        $fields = $contactRequest->getFrontendFields();
        $actions = FieldList::create(FormAction::create(
            'sendContactForm',
            _t('ContactController.ContactFormSendContactRequest', 'Send contact request')
        ));
        $validator = RequiredFieldsValidator::create($contactRequest->getRequiredFields());

        $form = Form::create($this, 'ContactForm', $fields, $actions, $validator);

        $form->setFormAction($this->getFormSubmissionLink());
        $form->setAttribute('hx-post', $this->getFormSubmissionLink());
        $form->enableSpamProtection();

        $this->extend('updateContactForm', $form);

        return $form;
    }

    public function sendContactForm(HTTPRequest $request)
    {
        $session = $request->getSession();
        $form = $this->ContactForm();
        $form->loadDataFrom($request->postVars());

        if (!$form->validate()->isValid()) {
            if ($this->isAjaxRequest()) {
                $this->getResponse()->addHeader('X-Status', 'Error');
                return $this->renderWith(
                    'Netwerkstatt/Contact/Element/ContactFormPartial',
                    ['RenderedForm' => $form]
                );
            }
                $session->set('ContactForm.info.' . $this->getContactFormSessionKey(), ['Success' => false]);
            return $this->redirect($this->Link());
        }

        try {
            $contactRequest = ContactRequest::create();
            $form->saveInto($contactRequest);
            $contactRequest->write();

            $contactRequest->sendEmail();

            if ($this->isAjaxRequest()) {
                $this->getResponse()->addHeader('X-Status', 'Success');
                return $this->renderWith('Netwerkstatt/Contact/Element/ContactSuccess');
            }

            $session->set('ContactForm.info.' . $this->getContactFormSessionKey(), ['Success' => true]);
            return $this->redirect($this->Link());
        } catch (Exception $e) {
            Injector::inst()->get(LoggerInterface::class)->error('Contact form email could not be sent', [
                'exception' => $e,
            ]);
            if ($this->isAjaxRequest()) {
                $this->getResponse()->addHeader('X-Status', 'Error');
                $form->sessionMessage(_t(
                    'ContactController.SendError',
                    'Sorry, your message could not be sent. Please try again later.'
                ), 'bad');
                return $this->renderWith(
                    'Netwerkstatt/Contact/Element/ContactFormPartial',
                    ['RenderedForm' => $form]
                );
            }
            $session->set('ContactForm.info.' . $this->getContactFormSessionKey(), ['Success' => false]);
            return $this->redirect($this->Link());
        }
    }

    protected function isAjaxRequest(): bool
    {
        return $this->getRequest()->isAjax() || $this->getRequest()->getHeader('HX-Request');
    }

    protected function getContactFormSessionKey(): string
    {
        return method_exists($this, 'getElement') ? (string) $this->getElement()->ID : 'page';
    }

    /**
     * @return string
     */
    abstract protected function getFormSubmissionLink(): string;
}
