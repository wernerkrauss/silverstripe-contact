<?php

namespace Netwerkstatt\Contact\Tests;

use Netwerkstatt\Contact\Model\ContactRequest;
use SilverStripe\Dev\SapphireTest;

class ContactRequestTest extends SapphireTest
{
    protected $usesDatabase = true;

    public function testRequiredFields(): void
    {
        $required = singleton(ContactRequest::class)->getRequiredFields();
        $this->assertContains('Surname', $required);
        $this->assertContains('Email', $required);
        $this->assertContains('Message', $required);
    }

    public function testWriteAndRead(): void
    {
        $request = ContactRequest::create([
            'FirstName' => 'Erika',
            'Surname' => 'Musterfrau',
            'Email' => 'erika@example.com',
            'Message' => 'Hello there',
        ]);
        $id = $request->write();
        $this->assertGreaterThan(0, $id);

        $found = ContactRequest::get()->byID($id);
        $this->assertNotNull($found);
        $this->assertSame('erika@example.com', $found->Email);
    }

    public function testCannotBeEditedOrDeletedViaCms(): void
    {
        $request = singleton(ContactRequest::class);
        $this->assertFalse($request->canEdit());
        $this->assertFalse($request->canDelete());
    }
}
