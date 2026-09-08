<?php

return [
    ['label' => 'Overview', 'items' => [
        ['label' => 'Profile', 'description' => 'View and edit admin profile', 'route' => 'dashboards.super-admin', 'active' => ['dashboards.super-admin'], 'icon' => 'overview'],
    ]],
    ['label' => 'Registration Management', 'items' => [
        ['label' => 'Student List', 'description' => 'Records and documents', 'route' => 'super-admin.students.index', 'active' => ['super-admin.students.index'], 'icon' => 'students'],
        ['label' => 'Branch List', 'description' => 'All registered branches', 'route' => 'super-admin.branch-applications.index', 'active' => ['super-admin.branch-applications.index'], 'icon' => 'branches'],
        ['label' => 'Branch Approval', 'description' => 'Pending requests', 'route' => 'super-admin.branch-applications.index', 'parameters' => ['status' => 'pending'], 'active' => ['super-admin.branch-applications.*'], 'icon' => 'branches', 'badge' => 'pendingBranchApplications'],
        ['label' => 'Add New Student', 'description' => 'Register new student', 'route' => 'super-admin.students.create', 'active' => ['super-admin.students.create'], 'icon' => 'students'],
    ]],
    ['label' => 'Academic Setup', 'items' => [
        ['label' => 'Add Course List', 'description' => 'Manage institute courses', 'route' => 'super-admin.courses.index', 'active' => ['super-admin.courses.*'], 'icon' => 'courses'],
        ['label' => 'Teachers', 'description' => 'Teaching staff records', 'route' => 'super-admin.teachers.index', 'active' => ['super-admin.teachers.*'], 'icon' => 'teachers'],
        ['label' => 'Semester & Subjects', 'description' => 'Academic structure', 'route' => 'super-admin.semester-setup.index', 'active' => ['super-admin.semester-setup.*'], 'icon' => 'semesters'],
    ]],
    ['label' => 'Website & Gallery', 'items' => [
        ['label' => 'Add Gallery', 'description' => 'Manage photo gallery', 'route' => 'super-admin.homepage.items.index', 'parameters' => ['section' => 'gallery'], 'active' => ['super-admin.homepage.items.*'], 'icon' => 'homepage'],
        ['label' => 'Add Review', 'description' => 'Student testimonials', 'route' => 'super-admin.homepage.items.index', 'parameters' => ['section' => 'testimonials'], 'active' => ['super-admin.homepage.items.*'], 'icon' => 'homepage'],
        ['label' => 'Add Slider', 'description' => 'Homepage hero slider', 'route' => 'super-admin.homepage.items.index', 'parameters' => ['section' => 'hero'], 'active' => ['super-admin.homepage.items.*'], 'icon' => 'homepage'],
    ]],
    ['label' => 'Notifications', 'items' => [
        ['label' => 'Add Notice', 'description' => 'Create new notice', 'route' => 'super-admin.notices.create', 'active' => ['super-admin.notices.create'], 'icon' => 'notices'],
        ['label' => 'Add Notice Board', 'description' => 'Manage notices', 'route' => 'super-admin.notices.index', 'active' => ['super-admin.notices.index'], 'icon' => 'notices'],
    ]],
    ['label' => 'Institute Info', 'items' => [
        ['label' => 'Add About Institute', 'description' => 'Profile and history', 'route' => 'super-admin.about.index', 'active' => ['super-admin.about.*'], 'icon' => 'about'],
    ]],
];
