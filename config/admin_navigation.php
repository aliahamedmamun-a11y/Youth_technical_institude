<?php

return [
    ['label' => 'Overview', 'items' => [
        ['label' => 'Dashboard', 'description' => 'Today’s priorities and shortcuts', 'route' => 'dashboards.super-admin', 'active' => ['dashboards.super-admin'], 'icon' => 'overview'],
    ]],
    ['label' => 'People & Branches', 'items' => [
        ['label' => 'Students', 'description' => 'Records, results, and documents', 'route' => 'super-admin.students.index', 'active' => ['super-admin.students.*', 'super-admin.results.*', 'super-admin.enrollments.results.*'], 'icon' => 'students'],
        ['label' => 'Teachers', 'description' => 'Teaching staff records', 'route' => 'super-admin.teachers.index', 'active' => ['super-admin.teachers.*'], 'icon' => 'teachers'],
        ['label' => 'Branch Approvals', 'description' => 'Review new branch requests', 'route' => 'super-admin.branch-applications.index', 'active' => ['super-admin.branch-applications.*'], 'icon' => 'branches', 'badge' => 'pendingBranchApplications'],
    ]],
    ['label' => 'Academic Management', 'items' => [
        ['label' => 'Departments & Courses', 'description' => 'Programs offered by the institute', 'route' => 'super-admin.courses.index', 'active' => ['super-admin.courses.index', 'super-admin.courses.create', 'super-admin.courses.edit', 'super-admin.courses.show'], 'icon' => 'courses'],
        ['label' => 'Semesters & Subjects', 'description' => 'Course structure and subjects', 'route' => 'super-admin.semester-setup.index', 'active' => ['super-admin.semester-setup.*', 'super-admin.courses.semesters.*', 'super-admin.semesters.subjects.*'], 'icon' => 'semesters'],
        ['label' => 'Results & Certificates', 'description' => 'Publish results and print documents', 'route' => 'super-admin.students.index', 'active' => ['super-admin.students.results.*', 'super-admin.students.documents.*'], 'icon' => 'documents'],
    ]],
    ['label' => 'Website Content', 'items' => [
        ['label' => 'Homepage', 'description' => 'Hero, gallery, testimonials, and contact', 'route' => 'super-admin.homepage.items.index', 'parameters' => ['hero'], 'active' => ['super-admin.homepage.*'], 'icon' => 'homepage'],
        ['label' => 'Notices', 'description' => 'Important public updates', 'route' => 'super-admin.notices.index', 'active' => ['super-admin.notices.*'], 'icon' => 'notices'],
        ['label' => 'News & Announcements', 'description' => 'Institute stories and public updates', 'route' => 'super-admin.news.index', 'active' => ['super-admin.news.*'], 'icon' => 'news'],
        ['label' => 'About the Institute', 'description' => 'Profile and leadership information', 'route' => 'super-admin.about.index', 'active' => ['super-admin.about.*'], 'icon' => 'about'],
    ]],
];
