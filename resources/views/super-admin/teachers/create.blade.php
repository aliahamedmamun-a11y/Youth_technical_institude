<x-dashboard-shell title="Add Faculty Member" eyebrow="Teacher Management" description="Register a new teaching staff member into the institute directory.">
    <div class="mx-auto max-w-5xl py-6">
        <x-teacher-form :action="route('super-admin.teachers.store')" submit-label="Add Teacher" />
    </div>
</x-dashboard-shell>
