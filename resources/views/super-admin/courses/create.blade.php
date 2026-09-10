<x-dashboard-shell title="Add Course" eyebrow="Academic Management" description="Create a new course or department for institute programmes.">
    <div class="mx-auto max-w-4xl py-6">
        <x-course-form :action="route('super-admin.courses.store')" submit-label="Create Course" />
    </div>
</x-dashboard-shell>
