<div id="contact-form-container-{$ID}" class="w-full contact-form-wrapper">
    <% with $getFormInfo %>
        <% if $Success %>
            <% include Netwerkstatt\Contact\Element\ContactSuccess %>
        <% else %>
            <% if $ErrorMessage %>
                <div class="mb-4 rounded-md bg-red-50 p-4 text-sm text-red-700">$ErrorMessage</div>
            <% end_if %>
            <div hx-target="#contact-form-container-{$Up.ID}" hx-swap="outerHTML" class="w-full contact-form-wrapper">
                $Up.RenderedForm
            </div>
        <% end_if %>
    <% end_with %>
</div>
