<x-dashboard-shell title="Edit Notice" eyebrow="Content management" description="Update the notice shown to visitors.">
    <x-notice-form :notice="$notice" :action="route('super-admin.notices.update', $notice)" method="PUT" submit-label="Save changes" />
</x-dashboard-shell>
