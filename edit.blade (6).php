<x-dashboard-shell title="Edit About Entry" eyebrow="Website content" description="Update this About Us story and its homepage visibility.">
    <x-about-form :about="$about" :action="route('super-admin.about.update', $about)" method="PUT" submit-label="Save changes" />
</x-dashboard-shell>
