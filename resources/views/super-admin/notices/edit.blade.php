<x-dashboard-shell title="Edit Announcement" eyebrow="Notifications" description="Update the content or visibility of an existing official notice.">
    <div class="mx-auto max-w-4xl py-6">
        <x-notice-form
            :notice="$notice"
            :action="route('super-admin.notices.update', $notice)"
            method="PUT"
            submit-label="Update Announcement"
        />
    </div>
</x-dashboard-shell>
