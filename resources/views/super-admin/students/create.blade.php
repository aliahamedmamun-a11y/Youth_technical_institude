<x-dashboard-shell
    title="Add Student"
    eyebrow="Student management"
    description="Register a new student and capture their registration details."
>

    <x-student-form
        :courses="$courses"
        :action="route('super-admin.students.store')"
        submit-label="Add student"
        :is-edit="false"
    />

</x-dashboard-shell>
