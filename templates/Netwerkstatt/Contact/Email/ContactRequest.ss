<p><%t ContactEmail.ContactRequestFrom 'Contact form request from' %> $FirstName $Surname ($Email)</p>
<% if $Phone %><p><%t ContactEmail.Phone 'Phone' %>: $Phone</p><% end_if %>
<p>$Message</p>
