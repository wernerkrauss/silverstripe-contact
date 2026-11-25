<%t ContactEmail.ContactRequestFrom 'Contact form request from' %> $FirstName $Surname ($Email)
<% if $Phone %><%t ContactEmail.Phone 'Phone' %>: $Phone<% end_if %>

$Message
