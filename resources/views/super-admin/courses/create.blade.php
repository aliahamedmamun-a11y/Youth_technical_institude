<x-dashboard-shell title="Add Department" eyebrow="Academic management" description="Create a department for institute programmes and enrolment.">
    <x-course-form :action="route('super-admin.courses.store')" submit-label="Create department" />
</x-dashboard-shell>
