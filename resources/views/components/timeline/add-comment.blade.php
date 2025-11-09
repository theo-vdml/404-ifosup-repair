@props(['ticket'])

<div class="p-4 md:p-6 bg-slate-50">
    <x-form method="POST" multipart action="{{ route('tickets.notes.store', $ticket) }}">
        <x-form-field name="message" placeholder="Décrivez votre action ou ajoutez un commentaire..." type="textarea"
            label="Ajouter un commentaire" />
        <x-attachment-input name="attachments" button-label="Joindre des fichiers" button-icon="heroicon-o-paper-clip"
            :multiple="true" />
        <x-slot name="actions">
            <x-button type="submit" label="Publier" icon="heroicon-o-paper-airplane" variant="solid" />
        </x-slot>
    </x-form>
</div>
