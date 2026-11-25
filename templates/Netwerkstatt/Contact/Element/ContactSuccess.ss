<% if $SuccessMessage %>
    <div class="border-2 border-orange-500 bg-white p-6 text-grey-700" role="status" aria-live="polite">
        $SuccessMessage.RAW
    </div>
<% else %>
    <div class="border-2 border-orange-500 bg-white p-6 text-grey-700" role="status" aria-live="polite">
        <%t ContactElement.SuccessMessage 'Your request has been sent successfully.' %>
    </div>
<% end_if %>
