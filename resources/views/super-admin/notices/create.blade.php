<x-dashboard-shell title="Create Announcement" eyebrow="Notifications" description="Draft and publish a new official notice for students and staff.">
    <div class="mx-auto max-w-4xl py-6">
        <x-notice-form
            :notice="$notice"
            :action="route('super-admin.notices.store')"
            submit-label="Publish Announcement"
        />
    </div>
</x-dashboard-shell>
