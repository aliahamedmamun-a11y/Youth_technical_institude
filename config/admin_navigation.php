<?php

return [
    ['label' => 'Main', 'items' => [
        ['label' => 'Profile', 'route' => 'dashboards.super-admin', 'active' => ['dashboards.super-admin'], 'icon' => 'overview'],
        ['label' => 'Add Course', 'route' => 'super-admin.courses.create', 'active' => ['super-admin.courses.create'], 'icon' => 'courses'],
        ['label' => 'Remove Course', 'route' => 'super-admin.courses.index', 'active' => ['super-admin.courses.index'], 'icon' => 'courses'],
        ['label' => 'Add Student', 'route' => 'super-admin.students.create', 'active' => ['super-admin.students.create'], 'icon' => 'students'],
        ['label' => 'Branch Students Admin', 'route' => 'super-admin.students.index', 'active' => [], 'icon' => 'students'],
        ['label' => 'Remove Verified Branches', 'route' => 'super-admin.all-branches', 'active' => [], 'icon' => 'branches'],
        ['label' => 'Requested Branches', 'route' => 'super-admin.branch-applications.index', 'parameters' => ['status' => 'pending'], 'active' => ['super-admin.branch-applications.index'], 'icon' => 'branches', 'badge' => 'pendingBranchApplications'],
        ['label' => 'ALL-Branches-List', 'route' => 'super-admin.all-branches', 'active' => ['super-admin.all-branches'], 'icon' => 'branches'],
        ['label' => 'All Students', 'route' => 'super-admin.students.index', 'active' => ['super-admin.students.index'], 'icon' => 'students'],
        ['label' => 'Add Subject Suggestion', 'route' => 'super-admin.subject-suggestions.index', 'active' => ['super-admin.subject-suggestions.*'], 'icon' => 'semesters'],
        ['label' => 'AdminForm', 'route' => 'super-admin.admin-cards.index', 'active' => ['super-admin.admin-cards.*'], 'icon' => 'about'],
        ['label' => 'SuccessStudents', 'route' => 'super-admin.homepage.items.index', 'parameters' => ['section' => 'testimonials'], 'active' => [], 'icon' => 'homepage'],
        ['label' => 'homeSlider', 'route' => 'super-admin.homepage.items.index', 'parameters' => ['section' => 'hero'], 'active' => [], 'icon' => 'homepage'],
        ['label' => 'NoticeAdd', 'route' => 'super-admin.notices.create', 'active' => ['super-admin.notices.create'], 'icon' => 'notices'],
        ['label' => 'Student Reviews', 'route' => 'super-admin.homepage.items.index', 'parameters' => ['section' => 'testimonials'], 'active' => [], 'icon' => 'homepage'],
        ['label' => 'Branch Reviews', 'route' => 'super-admin.homepage.items.index', 'parameters' => ['section' => 'trust'], 'active' => [], 'icon' => 'homepage'],
        ['label' => 'Branch Message inbox', 'route' => 'super-admin.branch-messages.index', 'active' => ['super-admin.branch-messages.index'], 'icon' => 'overview'],
        ['label' => 'AdminMessageOMRSheet', 'route' => 'super-admin.branch-messages.board', 'active' => ['super-admin.branch-messages.board'], 'icon' => 'overview'],
        ['label' => 'AdminMessagingAdd', 'route' => 'super-admin.branch-messages.messaging-add', 'active' => ['super-admin.branch-messages.messaging-add'], 'icon' => 'overview'],
        ['label' => 'NoticeBoardAdd', 'route' => 'super-admin.notice-board-suggestions.create', 'active' => ['super-admin.notice-board-suggestions.create'], 'icon' => 'notices'],
        ['label' => 'NoticeBoardPush', 'route' => 'super-admin.notice-board-suggestions.index', 'active' => ['super-admin.notice-board-suggestions.index'], 'icon' => 'notices'],
        ['label' => 'AllTableAdminAdd', 'route' => 'super-admin.branch-messages.all-table-add', 'active' => ['super-admin.branch-messages.all-table-add'], 'icon' => 'overview'],
        ['label' => 'AllTableAdminPost', 'route' => 'super-admin.notice-board-suggestions.all-table-post', 'active' => ['super-admin.notice-board-suggestions.all-table-post'], 'icon' => 'overview'],
    ]],
];
