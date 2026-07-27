<x-dashboard-shell title="Edit Course" eyebrow="Academic management" description="Update the course information and availability.">
    <x-course-form :course="$course" :action="route('super-admin.courses.update', $course)" method="PUT" submit-label="Save changes" />
</x-dashboard-shell>
