<x-dashboard-shell title="Edit Faculty Member" eyebrow="Teacher Management" description="Update the teaching staff member's information and assignments.">
    <div class="mx-auto max-w-5xl py-6">
        <x-teacher-form
            :teacher="$teacher"
            :action="route('super-admin.teachers.update', $teacher)"
            method="PUT"
            submit-label="Update Teacher Info"
        />
    </div>
</x-dashboard-shell>
