<x-dashboard-shell title="Edit Course" eyebrow="Academic Management" description="Update course information and enrolment availability.">
    <div class="mx-auto max-w-4xl py-6">
        <x-course-form :course="$course" :action="route('super-admin.courses.update', $course)" method="PUT" submit-label="Update Course Info" />
    </div>
</x-dashboard-shell>
