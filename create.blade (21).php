<x-dashboard-shell title="Create Notice" eyebrow="Content management" description="Publish a short announcement to the homepage notice ticker.">
    <x-notice-form :notice="$notice" :action="route('super-admin.notices.store')" submit-label="Create notice" />
</x-dashboard-shell>
