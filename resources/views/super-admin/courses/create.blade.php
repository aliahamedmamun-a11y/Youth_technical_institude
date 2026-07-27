<x-dashboard-shell title="Add Course" eyebrow="Academic management" description="Create a course for institute programmes and enrolment.">
    <x-course-form :action="route('super-admin.courses.store')" submit-label="Create course" />
</x-dashboard-shell>
